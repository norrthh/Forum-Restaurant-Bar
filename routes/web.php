<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\File\FileUploadController;
use App\Http\Controllers\Order\OrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

Route::get('/', [AuthController::class, 'index'])->name('index');
Route::get('/app', [AuthController::class, 'app'])->name('app');
Route::get('/location', [AuthController::class, 'location'])->name('location');
Route::get('/menu', [DashboardController::class, 'menu'])->name('menu');
Route::get('/order', [DashboardController::class, 'order'])->name('order');
Route::get('/formalization', [OrderController::class, 'form'])->name('order.form');
Route::get('/notification', [DashboardController::class, 'notification'])->name('notification');
Route::get('/support', [DashboardController::class, 'support'])->name('support');
Route::get('/adminpanel/87cdd38beeeb3a16337bef333e1c8d63', [AdminController::class, 'admin']);
Route::post('upload', [FileUploadController::class, 'upload']);

Route::post('/salebot-proxy', function (Request $request) {
    $apiKey = ''; // Укажите ваш API ключ здесь
    $salebotUrl = "https://chatter.salebot.pro/api/{$apiKey}/whatsapp_callback";

    $phone = $request->input('phone');

    $response = Http::post($salebotUrl, [
        'phone' => $phone,
    ]);

    // Установка заголовков CORS
    return response($response->body())
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With');
});
