<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('products', App\Http\Controllers\Api\v1\ProductController::class);
Route::apiResource('orders', App\Http\Controllers\Api\v1\OrderController::class);


