<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormStoreRequest;
use App\Http\Services\MobizonService;
use App\Models\Form;
use App\Models\FormImage;
use App\Models\SmsCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FormController extends Controller
{
    public function store(FormStoreRequest $request)
    {
        $mobizon = new MobizonService();
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
        ];

        $form = Form::query()->create($data);


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
        $code = rand(999, 9999);
        $mobizon->sendSMS($phone, $code);
        SmsCode::query()->create([
            'phone' => $phone,
            'code' => $code,
            'status' => 'sent',
            'verified' => 0,
            'user_id' => $user->id,
        ]);
        $verify['phone'] = $request->get('phone');
        return redirect()->route('form.verify', compact('verify'))->with('success', 'Подтвердите телефон номер!');
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

    public function phoneVerify(Request $request)
    {
        $user = User::query()->where('phone', $request->get('phone'))->first();
        $codes = SmsCode::query()->where('user_id', $user->id)
            ->where('code', $request->get('full_code'))
            ->where('verified',0)->first();

        if (!$codes)
            return redirect()->back()->with('error', 'Неправильный код подтверждение.');
        dd($user);

        dd($request->all());
    }
}
