<?php

namespace App\Action\Food;

use App\Models\Food;

class FoodStoreAction
{
    public function store($food): void
    {
        Food::query()->create($food);
    }
}
