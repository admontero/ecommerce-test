<?php

use Illuminate\Support\Facades\Route;

Route::get('products', [App\Http\Controllers\Api\v1\ProductController::class, 'index']);
