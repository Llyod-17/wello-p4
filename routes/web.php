<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::get("/", [ProductController::class, 'index']);

Route::get('/detail/{id}', [ProductController::class, 'show']);

Route::get('/checkout/{id}', [ProductController::class, 'checkout']);
Route::post('/checkout/proses', [ProductController::class, 'storeTransaction']);
Route::get('/berhasil/{id}', [ProductController::class, 'success']);

Route::get('/test-500', function () {
    abort(500);
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
