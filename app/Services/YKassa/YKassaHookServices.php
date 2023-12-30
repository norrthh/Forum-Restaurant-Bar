<?php

namespace App\Services\YKassa;

use App\Facades\Telegram;
use App\Models\YKassa;

class YKassaHookServices extends YKassaServices
{
    public function hook(array $data)
    {
        if ($data['event'] == 'payment.succeeded') {
            $kassa = YKassa::query()->where([['sign', $data['object']['id']], ['status', 0]])->first();

            if ($kassa) {
                YKassa::query()
                    ->where('sign', $data['object']['id'])
                    ->update(['status' => 1]);


                Telegram::sendMessage(
                    implode("\n", $this->filterTG($kassa->id, $kassa->typeApp, $kassa->numberApp, $kassa->phone, $kassa->foods)),
                    env('TELEGRAM_CHAT_ID'));
            }
        }
    }

}
