<?php

namespace App\Services;

use NotificationChannels\Telegram\TelegramUpdates;

class CampaignFormService
{

    public function get_telegram_id_by_username($username)
    {
        $updates = TelegramUpdates::create()

            ->options([
                'timeout' => 0,
            ])
            ->get();

        if($updates['ok']) {
            // Chat ID //481903116
//            $chatId = ;
            foreach ($updates['result'] as $update){
                if ($update['message']['chat']['username'] == $username)
                    return $update['message']['chat']['id'];
            }
        }
        return null;
    }
}
