<?php

namespace App\Services\Order;

use App\Models\YKassa;
use App\Services\YKassa\YKassaServices;
use Inertia\Inertia;

class CreateOrderServices extends OrderServices
{
    public function generate(array $data)
    {
        $kassa = new YKassaServices();
        $dataKassa = $kassa->create($data['totalPrice']);

        $this->createOrder($data, $dataKassa->id);
        return Inertia::location($dataKassa->confirmation->confirmation_url);
    }

}
