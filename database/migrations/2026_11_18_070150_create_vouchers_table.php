<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name', 150);
            $table->enum('type', ['percentage', 'fixed'])->default('fixed'); // 'percentage' (%) atau 'fixed' (Rp)
            $table->integer('reward_amount'); // misal: 10 untuk 10%, 15000 untuk Rp 15.000
            $table->integer('max_discount')->nullable(); // Maksimal diskon (opsional untuk percentage)
            $table->integer('min_purchase')->default(0); // Syarat minimal belanja (Rp)
            $table->integer('quota')->nullable(); // Kuota batas penggunaan voucher
            $table->integer('used_count')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
