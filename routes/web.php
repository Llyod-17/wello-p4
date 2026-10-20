<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::get("/", [ProductController::class, 'index']);

Route::get('/detail/{id}', [ProductController::class, 'show']);

Route::get('/checkout', function () {
    return view('checkout');
});

Route::get('/test-500', function () {
    abort(500);
});

Route::get('/berhasil', function () {
    return view('berhasil');
});

Route::get('/404', function () {
    return view('errors.404');
});

// Test routes for error pages
Route::get('/401', function () {
    return view('errors.401');
});

Route::get('/403', function () {
    return view('errors.403');
});

Route::get('/500', function () {
    return view('errors.500');
});

Route::get('/503', function () {
    return view('errors.503');
});
