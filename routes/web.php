<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::get("/", [ProductController::class, 'index']);

Route::get('/detail/{id}', [ProductController::class, 'show']);

Route::get('/checkout', function () {
    return view('checkout');
});

Route::get('/berhasil', function () {
    return view('berhasil');
});

Route::get('/404', function () {
    return view('errors.404');
});
