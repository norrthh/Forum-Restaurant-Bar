<?php

namespace App\Services\YKassa;

use YooKassa\Client;

class YKassaServices
{
    public function create(int $amount)
    {
        $client = new Client();
        $client->setAuth(env('YANDEX_KASSA_SHOP'), env('YANDEX_KASSA_KEY'));
        $payment = $client->createPayment(
            array(
                'amount' => array(
                    'value' => $amount,
                    'currency' => 'RUB',
                ),
                'confirmation' => array(
                    'type' => 'redirect',
                    'return_url' => route('order') . '?pay=true',
                ),
                'capture' => false,
            ),
            uniqid('', true)
        );


        return $payment;
    }

    public function filterTG(int $id, int $typeApp, int $numberApp, string $phone, string $foods, int $type = 1)
    {
        return [
            '<b>Заказ #' . ($id < 100 ? sprintf('%04d', $id) : (($id < 1000) ? sprintf('%03d', $id) : $id)) . '</b> ' . ($type == 1 ? '<i>(Оплачен)</i>' : '<i>(Наличными)</i>'),
            "Локация | " . ($typeApp == 1 ? 'Памир ' . $numberApp . '/123' : 'Тянь-Шань ' . $numberApp . '/125'),
            "Номер | +".preg_replace('/\D/', '', $phone) ,
            "",
            $this->getFoods($foods)
        ];

    }

    public function getFoods($foods)
    {
        $list = ["<b>Содержимое заказа:</b>"];
        $foods = json_decode($foods);

        foreach ($foods as $food) {
//            $list[] = $food->name . ' (x' . $food->clickCount . ')' . ' - ' . $food->price . 'руб';
            $list[] = $food->clickCount ."x | " . $food->name . " - " . $food->price . "₽";
        }

        return implode("\n", $list);
    }
}
