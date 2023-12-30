<?php

namespace App\Services\Telegram;

class TelegramServices
{
    public function sendMessage(string $text, int $chat_id)
    {
        $queryParams = http_build_query([
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'html',
        ]);

        file_get_contents("https://api.telegram.org/bot" . env('TELEGRAM_TOKEN') . "/sendMessage?{$queryParams}");
    }
}
