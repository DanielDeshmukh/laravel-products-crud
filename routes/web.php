<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/hello', [HelloController::class, 'index']);

Route::resource('products', ProductController::class)->except('show');


