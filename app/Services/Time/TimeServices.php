<?php

namespace App\Services\Time;

class TimeServices
{
    public function time(): int
    {
        return (intval(date('H')) <= 22 && intval(date('H')) >= 8) ? 1 : 2;
    }
}
