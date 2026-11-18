<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Cek apakah voucher ini valid digunakan untuk total subtotal tertentu.
     */
    public function isValidFor($subtotal, &$errorMessage = null): bool
    {
        if (!$this->is_active) {
            $errorMessage = 'Voucher ini sedang dinonaktifkan oleh toko.';
            return false;
        }

        $today = now()->startOfDay();

        if ($this->start_date && $today->lt($this->start_date)) {
            $errorMessage = 'Voucher belum berlaku (mulai ' . $this->start_date->format('d M Y') . ').';
            return false;
        }

        if ($this->end_date && $today->gt($this->end_date)) {
            $errorMessage = 'Voucher telah kadaluwarsa pada ' . $this->end_date->format('d M Y') . '.';
            return false;
        }

        if ($this->quota !== null && $this->used_count >= $this->quota) {
            $errorMessage = 'Kuota penggunaan voucher ini telah habis.';
            return false;
        }

        if ($subtotal < $this->min_purchase) {
            $errorMessage = 'Minimal belanja untuk voucher ini adalah Rp ' . number_format($this->min_purchase, 0, ',', '.') . '.';
            return false;
        }

        return true;
    }

    /**
     * Hitung nominal potongan diskon yang didapat.
     */
    public function calculateDiscount($subtotal): int
    {
        if ($this->type === 'percentage') {
            $discount = (int) round(($subtotal * $this->reward_amount) / 100);
            if ($this->max_discount !== null && $discount > $this->max_discount) {
                $discount = $this->max_discount;
            }
            return min($discount, $subtotal);
        }

        // Fixed amount
        return min((int) $this->reward_amount, (int) $subtotal);
    }
}
