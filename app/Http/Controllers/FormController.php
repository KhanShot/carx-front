<?php

namespace App\Http\Controllers;

use App\Events\FormStoreEvent;
use App\Http\Requests\FormStoreRequest;
use App\Http\Services\MobizonService;
use App\Models\Campaign;
use App\Models\Form;
use App\Models\FormImage;
use App\Models\SmsCode;
use App\Models\User;
use App\Notifications\FormCreatedNotification;
use App\Services\CampaignFormService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class FormController extends Controller
{
    public function store(FormStoreRequest $request)
    {
        $phone = $this->getNumber($request->get('phone'));

        $user_data = [
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'role' => 'user',
            'password' => Hash::make('password'),
        ];

        $user = User::query()->updateOrCreate(['phone'=> $request->get('phone')], $user_data);

        $data = [
            'user_id' => $user->id,
            'mark' => $request->get('mark'),
            'model' => $request->get('model'),
            'year' => $request->get('year'),
            'mileage' => $request->get('mileage'),
            'capacity' => $request->get('capacity'),
            'engine_type' => $request->get('engine_type'),
            'transmission_type' => $request->get('transmission_type'),
            'drive_unit' => $request->get('drive_unit'),
            'color' => $request->get('color'),
            'arrested' => $request->get('arrested'),
            'pledged' => $request->get('pledged'),
            'in_kz' => $request->get('in_kz'),
            'crashed' => $request->get('crashed'),
            'right_hand' => $request->get('right_hand'),
            'vin' => $request->get('vin'),
            'comment' => $request->get('comment'),
            'verified' => 0,
            'city' => $request->get('city'),
        ];

        $form = Form::query()->create($data);

        $this->sendSms($phone, $user);
        if ($request->hasFile("images")){
            $path = "/assets/forms";
            foreach ($request->file('images') as $image){
                $image->store('public'. $path);
                $name = $image->hashName();
                $image_name = $path."/".$name;
                FormImage::query()->create([
                    'form_id' => $form->id,
                    'url' => $image_name,
                ]);
            }
        }

        $verify['phone'] = $request->get('phone');
        return redirect()->route('form.verify', compact('verify'))->with('success1', 'Подтвердите телефон номер!');
    }
    private function sendSms($phone, $user)
    {
        $mobizon = new MobizonService();
        $code = rand(999, 9999);
        $mobizon->sendSMS($phone, $code);
        SmsCode::query()->create([
            'phone' => $phone,
            'code' => $code,
            'status' => 'sent',
            'verified' => 0,
            'user_id' => $user->id,
        ]);
    }
    private function getNumber($str){
        return preg_replace('/[^0-9]/', '',$str);
    }

    public function verify(Request $request)
    {
        if (!$request->get('verify'))
            return redirect()->route('form');
        return view('pages.verify');
    }
    public function resend(Request $request)
    {
        $user = User::query()->where('phone', $request->get('phone'))->first();
        $this->sendSms($this->getNumber($request->get('phone')),$user);
        return redirect()->back()->with('info', 'Код отправлено заново');
    }
    public function changeNumber(Request $request)
    {

        $user = User::query()->where('phone', $request->get('old_number'))->first();
        if (strlen($request->get('phone')) != 16)
            return redirect()->back()->with('error', 'Введите номер телефона корректно');

        $user->phone = $request->get('phone');
        $user->save();
        $this->sendSms($this->getNumber($request->get('phone')),$user);
        $verify['phone'] = $request->get('phone');
        return redirect()->route('form.verify', compact('verify'))->with('info', 'Код отправлен на новый номер');
    }
    public function phoneVerify(Request $request)
    {
        $user = User::query()->where('phone', $request->get('phone'))->first();
        $codes = SmsCode::query()->where('user_id', $user->id)
            ->where('code', $request->get('full_code'))
            ->where('verified',0)->first();

        if (!$codes)
            return redirect()->back()->with('error', 'Неправильный код подтверждение.');

        $form = Form::query()->where('user_id', $user->id)
            ->with(['user','images'])
            ->where('verified', 0)
            ->orderBy('created_at', 'DESC')->first();
        $codes->verified = 1;
//        $codes->save();
        $user->phone_verified_at = now();
//        $user->save();
        $images = $form->images;
        $pdf = Pdf::loadView('pdf.form_images', compact('images') );


        $path = "/assets/pdf/";
        $fileName = $form->id. '_'. $form->mark . '_' .$form->model;

        $filePath = $path.''. $fileName .'.pdf';
        $content =  $pdf->download()->getOriginalContent();
        Storage::put('public'.$filePath, $content);


        $form->verified = 1;
//        $form->save();
        $campaigns = Campaign::query();
        $form['file_path'] = $filePath;

        if ($form->arrested)
            $campaigns->where('arrested', $form->arrested);
        if ($form->pledged)
            $campaigns->where('pledged', $form->pledged);
        if ($form->crashed)
            $campaigns->where('crashed', $form->crashed);
        if ($form->right_hand)
            $campaigns->where('right_hand', $form->right_hand);
        if ($form->in_kz)
            $campaigns->where('in_kz', $form->in_kz);

        $campaigns = $campaigns->get();
        foreach ($campaigns as $campaign){
            broadcast(new FormStoreEvent($form, $campaign->user_id))->toOthers();
            if (is_null($campaign->telegram_user_id)){
                $this->set_telegram_user_id($campaign);
            }
            $campaign->notify(new FormCreatedNotification($form));
        }
        return redirect()->back()->with('success', 'правильный код подтверждение.');
    }

    private function set_telegram_user_id(Campaign $campaign)
    {
        $service = new CampaignFormService;
        $telegram_id = $service->get_telegram_id_by_username($campaign->telegram);
        $campaign->update(['telegram_user_id' => $telegram_id]);
    }
}
