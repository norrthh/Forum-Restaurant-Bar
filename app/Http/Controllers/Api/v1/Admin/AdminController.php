<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Facades\Time;
use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'count' => Food::query()->where('timeView', $request->integer('type'))->orderBy('position', 'asc')->count(),
            'foods' => Food::query()->where('timeView', $request->integer('type'))->orderBy('position', 'asc')->get(),
        ]);
    }

    public function filter(Request $request)
    {
        return response()->json(
            ($request->integer('freeze') === 0)
                ? Food::query()->where([['timeView', $request->integer('timeView')]])->orderBy('position', 'asc')->get()
                : Food::query()->where([['timeView', $request->integer('timeView')], ['freeze', $request->integer('freeze')]])->orderBy('position', 'asc')->get()
        );
    }
}
