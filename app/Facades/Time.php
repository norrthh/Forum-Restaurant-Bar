<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static time()
 */
class Time extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'time';
    }
}
