<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function() {
    Route::get('products/export', App\Http\Controllers\Api\v1\ProductExportController::class)
        ->name('products.export');

    Route::get('orders/export', App\Http\Controllers\Api\v1\OrderExportController::class)
        ->name('orders.export');

    Route::apiResource('products', App\Http\Controllers\Api\v1\ProductController::class);

    Route::apiResource('orders', App\Http\Controllers\Api\v1\OrderController::class);
});

