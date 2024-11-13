<?php

use Illuminate\Support\Facades\Route;

Route::get('products', [App\Http\Controllers\Api\v1\ProductController::class, 'index'])->name('products.index');
Route::post('products', [App\Http\Controllers\Api\v1\ProductController::class, 'store'])->name('products.store');
Route::get('products/{product}', [App\Http\Controllers\Api\v1\ProductController::class, 'show'])->name('products.show');
