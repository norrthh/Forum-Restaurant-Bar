<?php

namespace App\Http\Controllers\Order;

use App\Facades\Telegram;
use App\Http\Controllers\Controller;
use App\Services\Order\CreateOrderServices;
use App\Services\Order\OrderServices;
use App\Services\YKassa\YKassaHookServices;
use App\Services\YKassa\YKassaServices;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request, CreateOrderServices $services)
    {
//        return $request->all();
        return $services->generate($request->all());
    }

    public function cash(Request $request, OrderServices $services, YKassaServices $kassaServices)
    {
        $data = $services->createOrder($request->all(), 'cash');
        return Telegram::sendMessage(
            implode("\n", $kassaServices->filterTG($data->id, $data->typeApp, $data->numberApp, $data->phone, $data->foods, 0)),
            env('TELEGRAM_CHAT_ID'),
        );
    }

    public function getPay(Request $request, YKassaHookServices $services)
    {
        $services->hook($request->all());
    }
}
