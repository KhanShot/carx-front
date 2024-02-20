<?php

namespace App\Http\Services;
use Mobizon\MobizonApi;
class MobizonService
{
    public string $key = 'kz305f20d693b830fe88dcf5f6869d76f30b0e712d1872416f5c628d83d08b7e403dfc';
    private function getApi()
    {
        return new MobizonApi($this->key, 'api.mobizon.kz');
    }
    public function sendSMS($phone, $code){

        $api = $this->getApi();
        if ($api->call('message',
            'sendSMSMessage',
            array(
                'recipient' => $phone,
                'text' => "Код подтверждении: " . $code,
                //Optional, if you don't have registered alphaname, just skip this param and your message will be sent with our free common alphaname.
            ))
        ) {
            $messageId = $api->getData('messageId');
            if ($messageId) {
                if ($api->hasData()) {
                    return [true, $messageId];
//                    foreach ($api->getData() as $messageInfo) {
//                        echo 'Message # ' . $messageInfo->id . " status:\t" . $messageInfo->status . PHP_EOL;
//                    }
                }
            }
        } else {
            $out = (array($api->getCode(), $api->getData(), $api->getMessage()));
            return [false, $out];
//            echo 'An error occurred while sending message: [' . $api->getCode() . '] ' . $api->getMessage() . 'See details below:' . PHP_EOL;
//            var_dump(array($api->getCode(), $api->getData(), $api->getMessage()));
        }
    }

    public function getBalance()
    {
        $api = $this->getApi();

        if ($api->call('User', 'GetOwnBalance') && $api->hasData('balance')) {
            return (float)$api->getData('balance');
        } else {
            return 0;
        }
    }
}
