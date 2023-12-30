<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function menu(Request $request)
    {
        return Inertia::render('MenuComponent');
    }

    public function order(Request $request)
    {
        return Inertia::render('OrderComponent', [
            'pay' => ($request->input('pay') === 'true') ? 'pay' : 'false'
        ]);
    }

    public function notification()
    {
        return Inertia::render('NotificationComponent');
    }

    public function support()
    {
        return Inertia::render('SupportComponent', [
            'prev' => url()->previous()
        ]);
    }
}
