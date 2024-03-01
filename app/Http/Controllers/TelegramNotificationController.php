<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use NotificationChannels\Telegram\TelegramUpdates;

class TelegramNotificationController extends Controller
{
    //7130422920:AAF74IirT7yjHjSo7DHuQlM_INX097ezntM
    public function test()
    {
        $updates = TelegramUpdates::create()
            // (Optional). Get's the latest update. NOTE: All previous updates will be forgotten using this method.
            // ->latest()

            // (Optional). Limit to 2 updates (By default, updates starting with the earliest unconfirmed update are returned).
            ->limit(2)

            // (Optional). Add more params to the request.
            ->options([
                'timeout' => 0,
            ])
            ->get();

        if($updates['ok']) {
            // Chat ID //481903116
//            $chatId = ;
            foreach ($updates['result'] as $update){
                if ($update['message']['chat']['username'] == 'Dream_hiker')
                    echo $update['message']['chat']['id'];
            }
            dd('asda');
//            return $chatId;
        }
        return $updates;
    }
}
