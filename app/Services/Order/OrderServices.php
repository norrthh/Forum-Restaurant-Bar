<?php

namespace App\Services\Order;

use App\Models\YKassa;

class OrderServices
{
    public function createOrder(array $data, string $sign)
    {
        return YKassa::query()->create([
            'ip_address' => request()->ip(),
            'foods' => json_encode($this->getFoods($data['selectedObjects'])),
            'phone' => $data['phone'],
            'numberApp' => $data['numberApp'],
            'typeApp' => $data['typeApp'],
            'price' => $data['totalPrice'],
            'status' => 0,
            'sign' => $sign
        ]);
    }

    public function getFoods(array $data): array
    {

        $foods = [];
        $currentId = null;
        $currentName = null;

        foreach ($data as $item) {
            if (isset($item["id"])) {
                $currentId = $item["id"];
            }

            if (isset($item["name"])) {
                $currentName = $item["name"];
            }

            if (isset($item['price'])) {
                $currentPrice = $item['price'];
            }

            if (isset($item["clickCount"])) {
                $currentClickCount = $item["clickCount"];

                if ($currentId !== null && $currentName !== null) {
                    $foods[] = [
                        "id" => $currentId,
                        "name" => $currentName,
                        "clickCount" => $currentClickCount,
                        'price' => $currentPrice
                    ];

                    $currentId = null;
                    $currentName = null;
                    $currentClickCount = null;
                }
            }
        }

        return $foods;
    }
}
