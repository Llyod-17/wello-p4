<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('catalog');
    Route::get('/detail/{id}', [ProductController::class, 'show']);
    Route::get('/checkout/{id}', [ProductController::class, 'checkout']);
    Route::post('/checkout/proses', [ProductController::class, 'storeTransaction']);
    Route::get('/berhasil/{id}', [ProductController::class, 'success']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// =========================================================
// JALUR BACK-OFFICE / SELLER CENTER (SISI ADMIN: P8 & P9)
// =========================================================
// Materi P8: Manajemen Pesanan Masuk
Route::middleware(['auth', 'can:access-admin'])->group(function () {
    Route::get('/admin/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
    Route::post('/admin/transactions/{id}/status', [AdminController::class, 'updateStatus']);

    // Materi P9: Manajemen Katalog Produk & Upload Gambar
    Route::get('/admin/products', [AdminController::class, 'products']);
    Route::get('/admin/products/create', [AdminController::class, 'createProduct']);
    Route::post('/admin/products/store', [AdminController::class, 'storeProduct']);

    Route::get('/admin/products/{id}/edit', [ProductController::class, 'edit']);
    Route::post('/admin/products/update/{id}', [ProductController::class, 'updateProduct']);
    Route::post('/admin/products/delete/{id}', [ProductController::class, 'deleteProduct']);
});

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
