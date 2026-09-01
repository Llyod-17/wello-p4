<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('katalog');
});

Route::get('/detail', function () {
    return view('detail');
});

Route::get('/checkout', function () {
    return view('checkout');
});

Route::get('/berhasil', function () {
    return view('berhasil');
});