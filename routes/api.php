<?php

use App\Http\Controllers\Api\v1\Admin\AdminController;
use App\Http\Controllers\Api\v1\Category\CategoryController;
use App\Http\Controllers\Api\v1\Food\FoodController;
use App\Http\Controllers\Order\OrderController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->name('v1.')->group(function (){
    Route::prefix('food')->name('food.')->group(function (){
        Route::get('/', [FoodController::class, 'list'])->name('list');
        Route::get('/filter/', [FoodController::class, 'filter'])->name('filter');
        Route::post('/getCache/', [FoodController::class, 'cache'])->name('cache');
        Route::post('/create/', [FoodController::class, 'store'])->name('store');
        Route::get('/update/', [FoodController::class, 'update'])->name('store');
    });

    Route::prefix('category')->name('category.')->group(function () {
       Route::get('/', [CategoryController::class, 'category'])->name('list');
    });

    Route::prefix('order')->name('order.')->group(function (){
        Route::get('/create', [OrderController::class, 'store'])->name('store');
        Route::post('/create/cash', [OrderController::class, 'cash'])->name('cash');
        Route::post('/getPay', [OrderController::class, 'getPay']);
    });

    Route::prefix('admin')->group(function (){
        Route::post('/', [AdminController::class, 'index']);
        Route::post('/filter', [AdminController::class, 'filter']);

    });
});
