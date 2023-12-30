<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return inertia('Authentification/AuthPage1');
    }

    public function app()
    {
        return inertia('Authentification/AuthPage2');
    }

    public function location(Request $request)
    {
        return inertia('Authentification/AuthPage3');
    }
}
