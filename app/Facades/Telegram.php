<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static sendMessage(string $text, int $chat_id)
 */
class Telegram extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'Telegram';
    }
}
