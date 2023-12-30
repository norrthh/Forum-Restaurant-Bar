<?php

namespace App\Http\Controllers\Api\v1\Food;

use App\Action\Food\FoodStoreAction;
use App\Facades\Time;
use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function list()
    {
        return Food::query()
            ->where([['timeView', Time::time()], ['freeze', '!=', 1]])
            ->orderBy('position', 'desc')
            ->get();
    }

    public function filter(Request $request)
    {
        return Food::query()
            ->where([['timeView', Time::time()], ['categories_id', $request->integer('type')], ['freeze', '!=', 1]])
            ->orderBy('position', 'desc')
            ->get();
    }

    public function cache(Request $request)
    {
        return Food::query()->whereIn('id', json_decode($request->id))->get();
    }

    public function store(Request $request, FoodStoreAction $action)
    {
        $action->store($request->all());
        return response()->json([
            'message' => 'Вы успешно создали новую позицию еды'
        ]);
    }

    public function update(Request $request)
    {
        Food::query()->where('id', $request->integer('id'))->update($request->data);
        Food::query()->where('id', $request->integer('id'))->update([
            'file' => $request->input('file')
        ]);
    }
}
