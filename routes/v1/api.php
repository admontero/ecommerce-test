<?php

use Illuminate\Support\Facades\Route;

Route::get('products', [App\Http\Controllers\Api\v1\ProductController::class, 'index'])->name('products.index');
Route::get('products/{product}', [App\Http\Controllers\Api\v1\ProductController::class, 'show'])->name('products.show');
