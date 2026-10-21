<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code');        // Nomor Resi/Invoice (Contoh: INV-2026-001)
            $table->integer('product_id');         // ID Barang yang dibeli
            $table->string('product_name');        // Nama Barang saat dibeli
            $table->string('customer_name');       // Nama Lengkap Pembeli
            $table->string('customer_phone');      // Nomor HP/WA Pembeli
            $table->text('customer_address');      // Alamat Pengiriman
            $table->string('courier');             // Kurir (JNE / J&T / SiCepat)
            $table->integer('quantity');           // Jumlah Beli
            $table->integer('shipping_cost');      // Ongkos Kirim
            $table->integer('total_amount');       // Total Bayar (Harga x Qty + Ongkir)
            $table->string('status')->default('Pending'); // Status pesanan awal
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
