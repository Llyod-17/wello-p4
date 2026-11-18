<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin Toko (Seller Center)
        $admin = User::updateOrCreate(
            ['email' => 'admin@toko.com'],
            [
                'name' => 'Admin Official Store',
                'phone' => '081234567890',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // 2. Akun Customer Uji 1
        $customer1 = User::updateOrCreate(
            ['email' => 'budi@example.com'],
            [
                'name' => 'Budi Santoso',
                'phone' => '081298765432',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );

        // 3. Akun Customer Uji 2
        $customer2 = User::updateOrCreate(
            ['email' => 'siti@example.com'],
            [
                'name' => 'Siti Aminah',
                'phone' => '085712345678',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );

        // User lama 'test@example.com' set ke role customer jika ada
        User::where('email', 'test@example.com')->update(['role' => 'customer', 'phone' => '089911223344']);

        // 4. Seeder Produk (Min 4 Kategori, 9 Produk, Stok & Harga Realistis)
        $productsData = [
            // Kategori: Sayuran Segar
            [
                'name' => 'Bayam Hijau Organik (ikat)',
                'category' => 'Sayuran Segar',
                'price' => 7500,
                'stock' => 25,
                'description' => 'Bayam hijau segar langsung petik dari kebun organik lereng gunung, kaya zat besi.',
                'image' => null,
            ],
            [
                'name' => 'Wortel Brastagi Manis (1 kg)',
                'category' => 'Sayuran Segar',
                'price' => 18000,
                'stock' => 30,
                'description' => 'Wortel manis renyah kualitas super asal Brastagi, cocok untuk sup dan jus.',
                'image' => null,
            ],
            [
                'name' => 'Brokoli Hijau Segar (500 gr)',
                'category' => 'Sayuran Segar',
                'price' => 22000,
                'stock' => 15,
                'description' => 'Brokoli padat bebas pestisida kimiawi, segar dan kaya antioksidan.',
                'image' => null,
            ],

            // Kategori: Buah Segar
            [
                'name' => 'Apel Fuji Super Manis (1 kg)',
                'category' => 'Buah Segar',
                'price' => 38000,
                'stock' => 20,
                'description' => 'Apel fuji merah ranum dengan rasa manis berair dan tekstur garing sempurna.',
                'image' => null,
            ],
            [
                'name' => 'Alpukat Mentega Super (1 kg)',
                'category' => 'Buah Segar',
                'price' => 32000,
                'stock' => 18,
                'description' => 'Alpukat mentega daging tebal legit tanpa serat pahit, garansi matang sempurna.',
                'image' => '1792986448_alpukat_mentega.jpg',
            ],
            [
                'name' => 'Jeruk Medan Manis Segar (1 kg)',
                'category' => 'Buah Segar',
                'price' => 26000,
                'stock' => 25,
                'description' => 'Jeruk peras manis segar sarat vitamin C untuk daya tahan tubuh keluarga.',
                'image' => null,
            ],

            // Kategori: Bumbu Dapur
            [
                'name' => 'Bawang Merah Brebes Pilihan (500 gr)',
                'category' => 'Bumbu Dapur',
                'price' => 24000,
                'stock' => 40,
                'description' => 'Bawang merah kering khas Brebes beraroma wangi tajam dan gurih alami.',
                'image' => null,
            ],
            [
                'name' => 'Cabai Rawit Merah Domba (250 gr)',
                'category' => 'Bumbu Dapur',
                'price' => 19000,
                'stock' => 35,
                'description' => 'Cabai rawit merah segar super pedas pilihan, bersih tanpa tangkai busuk.',
                'image' => null,
            ],

            // Kategori: Minuman & Olahan
            [
                'name' => 'Susu Murni Pasteurisasi (1 Liter)',
                'category' => 'Minuman & Olahan',
                'price' => 21000,
                'stock' => 12,
                'description' => 'Susu sapi murni segar tanpa bahan pengawet, diproses pasteurisasi higienis.',
                'image' => null,
            ],
            [
                'name' => 'Madu Hutan Murni Alami (350 ml)',
                'category' => 'Minuman & Olahan',
                'price' => 65000,
                'stock' => 8,
                'description' => 'Madu hutan liar alami tanpa campuran gula, berkhasiat menjaga stamina.',
                'image' => null,
            ],
        ];

        foreach ($productsData as $data) {
            Product::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }

        // Hapus dummy produk 'alvin' jika ada
        Product::where('name', 'alvin')->delete();

        // 5. Seeder Transaksi Awal untuk Pengujian Seller Center & Riwayat Pembeli
        $prodApel = Product::where('name', 'LIKE', '%Apel%')->first();
        $prodAlpukat = Product::where('name', 'LIKE', '%Alpukat%')->first();
        $prodWortel = Product::where('name', 'LIKE', '%Wortel%')->first();

        if ($prodApel && $customer1) {
            Transaction::updateOrCreate(
                ['invoice_code' => 'INV-2026-1001'],
                [
                    'user_id' => $customer1->id,
                    'product_id' => $prodApel->id,
                    'product_name' => $prodApel->name,
                    'customer_name' => $customer1->name,
                    'customer_phone' => $customer1->phone,
                    'customer_address' => 'Jl. Merdeka No. 10, Jakarta Pusat',
                    'courier' => 'J&T Express',
                    'tracking_number' => 'JT982347101ID',
                    'quantity' => 2,
                    'shipping_cost' => 20000,
                    'total_amount' => ($prodApel->price * 2) + 20000,
                    'status' => 'Shipped',
                ]
            );
        }

        if ($prodAlpukat && $customer1) {
            Transaction::updateOrCreate(
                ['invoice_code' => 'INV-2026-1002'],
                [
                    'user_id' => $customer1->id,
                    'product_id' => $prodAlpukat->id,
                    'product_name' => $prodAlpukat->name,
                    'customer_name' => $customer1->name,
                    'customer_phone' => $customer1->phone,
                    'customer_address' => 'Jl. Merdeka No. 10, Jakarta Pusat',
                    'courier' => 'JNE Regular',
                    'tracking_number' => null,
                    'quantity' => 1,
                    'shipping_cost' => 15000,
                    'total_amount' => ($prodAlpukat->price * 1) + 15000,
                    'status' => 'Paid',
                ]
            );
        }

        if ($prodWortel && $customer2) {
            Transaction::updateOrCreate(
                ['invoice_code' => 'INV-2026-1003'],
                [
                    'user_id' => $customer2->id,
                    'product_id' => $prodWortel->id,
                    'product_name' => $prodWortel->name,
                    'customer_name' => $customer2->name,
                    'customer_phone' => $customer2->phone,
                    'customer_address' => 'Jl. Diponegoro No. 45, Bandung',
                    'courier' => 'SiCepat BEST',
                    'tracking_number' => null,
                    'quantity' => 3,
                    'shipping_cost' => 25000,
                    'total_amount' => ($prodWortel->price * 3) + 25000,
                    'status' => 'Pending',
                ]
            );
        }

        // 6. Inovasi Fitur 1: Seeder Contoh Voucher Diskon
        Voucher::updateOrCreate(
            ['code' => 'WELLOHEMAT'],
            [
                'name' => 'Promo Wello Diskon 15%',
                'type' => 'percentage',
                'reward_amount' => 15, // 15%
                'max_discount' => 30000, // maks 30rb
                'min_purchase' => 30000,
                'quota' => 50,
                'used_count' => 0,
                'start_date' => now()->subDay(),
                'end_date' => now()->addMonths(2),
                'is_active' => true,
            ]
        );

        Voucher::updateOrCreate(
            ['code' => 'SEGAR10K'],
            [
                'name' => 'Kupon Potongan Langsung Rp 10.000',
                'type' => 'fixed',
                'reward_amount' => 10000, // Rp 10.000
                'max_discount' => null,
                'min_purchase' => 25000,
                'quota' => 100,
                'used_count' => 0,
                'start_date' => now()->subDay(),
                'end_date' => now()->addMonths(1),
                'is_active' => true,
            ]
        );
    }
}
