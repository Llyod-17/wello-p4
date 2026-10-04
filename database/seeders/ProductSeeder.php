<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            "name" => "Buah Jeruk Segar (kg)",
            "description" => "buah jeruk premium cuma orang kaya yang beli",
            "price" => 200000,
            "image" => null,
        ]);
        Product::create([
            "name" => "Sayur Segar Hijau (kg)",
            "description" => "Sayuran Segar Berhasyat Dan Enak Di Maem",
            "price" => 15000,
            "image" => null,
        ]);
        Product::create([
            "name" => "Sayur Segar Kuning (kg)",
            "description" => "Sayuran Segar Berhasyat Dan Enak Di Maem",
            "price" => 25000,
            "image" => null,
        ]);
        Product::create([
            "name" => "Apple Seger pokoknya (kg)",
            "description" => "applenya orang kaya",
            "price" => 200000,
            "image" => null,
        ]);
        Product::create([
            "name" => "Jus Enak",
            "description" => "Jusnya orang kaya",
            "price" => 250000,
            "image" => null,
        ]);
        Product::create([
            "name" => "Pepaya Segar (kg)",
            "description" => "Buah Pepaya dengan aneka hasyat cuma orang kaya yang beli",
            "price" => 100000,
            "image" => null,
        ]);
    }
}
