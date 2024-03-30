<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramFile;
use NotificationChannels\Telegram\TelegramMessage;
class FormCreatedNotification extends Notification
{
    use Queueable;

    private $form;
//    private $telegram_user_id;

    /**
     * Create a new notification instance.
     */
    public function __construct($form)
    {
        //
        $this->form = $form;
//        $this->telegram_user_id = $telegram_user_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable)
    {
        $url = url('/partner/forms');
        $form = $this->form;
        $arrested = $form->arrested ? 'Да' : 'Нет';
        $pledged = $form->pledged ? 'Да' : 'Нет';
        $in_kz = $form->in_kz ? 'Да' : 'Нет';
        $crashed = $form->crashed ? "Аварийное" : "На ходу";
        $right_hand = $form->right_hand ? 'Правый' : 'Левый';

        if (count($form->images) != 0){
            $message = TelegramFile::create()
                ->to($notifiable->telegram_user_id)
//            ->file('https://xcar.kz/storage/assets/forms/9xBc1hxhk0yGjA4sPyco61keU2VYNijSajV98NIY.png' , 'photo')
                ->document('https://xcar.kz/storage' . $form->file_path , $form->mark . ' ' .$form->model .'_.pdf')
                ->content($form->mark . ' ' .$form->model . ' 🚙'
                    .PHP_EOL . $form->year . ' год' .PHP_EOL.'Пробег (км): '. $form->mileage
                    .PHP_EOL . 'Город: ' .$form->city ?? '-'
                    .PHP_EOL . 'АКПП: ' .$form->transmission_type
                    .PHP_EOL . 'Цвет: ' . $form->color
                    .PHP_EOL . 'Привод: ' . $form->drive_unit
                    .PHP_EOL . 'Вид топлива: ' . $form->engine_type
                    .PHP_EOL . 'Объем двигателя (л): ' . $form->capacity
                    .PHP_EOL . 'Состоит в аресте?: ' . $arrested
                    .PHP_EOL . 'Состоит в залоге?:  ' . $pledged
                    .PHP_EOL . 'Растаможен в РК?: ' . $in_kz
                    .PHP_EOL . 'Состояние: ' . $crashed
                    .PHP_EOL . 'Руль: ' . $right_hand
                    .PHP_EOL .$form->comment
                    .PHP_EOL . PHP_EOL. PHP_EOL. 'Имя: ' .$form->user->name
                    .PHP_EOL. 'Имя: ' .$form->user->phone);
        }else{
            $message = TelegramMessage::create()
                ->to($notifiable->telegram_user_id)
//            ->file('https://xcar.kz/storage/assets/forms/9xBc1hxhk0yGjA4sPyco61keU2VYNijSajV98NIY.png' , 'photo')
//                ->document('https://xcar.kz/storage' . $form->file_path , $form->mark . ' ' .$form->model .'_.pdf')
                ->content($form->mark . ' ' .$form->model . ' 🚙'
                    .PHP_EOL . $form->year . ' год' .PHP_EOL.'Пробег (км): '. $form->mileage
                    .PHP_EOL . 'Город: ' .$form->city ?? '-'
                    .PHP_EOL . 'АКПП: ' .$form->transmission_type
                    .PHP_EOL . 'Цвет: ' . $form->color
                    .PHP_EOL . 'Привод: ' . $form->drive_unit
                    .PHP_EOL . 'Вид топлива: ' . $form->engine_type
                    .PHP_EOL . 'Объем двигателя (л): ' . $form->capacity
                    .PHP_EOL . 'Состоит в аресте?: ' . $arrested
                    .PHP_EOL . 'Состоит в залоге?:  ' . $pledged
                    .PHP_EOL . 'Растаможен в РК?: ' . $in_kz
                    .PHP_EOL . 'Состояние: ' . $crashed
                    .PHP_EOL . 'Руль: ' . $right_hand
                    .PHP_EOL .$form->comment
                    .PHP_EOL . PHP_EOL. PHP_EOL. 'Имя: ' .$form->user->name
                    .PHP_EOL. 'Имя: ' .$form->user->phone);
        }

//        foreach ($form->images as $image){
//            $message->file('https://xcar.kz/storage'.$image->url, 'photo');
//        }

        return $message;
    }



    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
