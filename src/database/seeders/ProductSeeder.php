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
        Product::insert([
            [
                'user_id' => 3,
                'category_id' => 1,
                'name' => 'Laptop Lenovo Thinkpad Bekas',
                'description' => 'Masih normal untuk kuliah',
                'price' => 3500000,
                'status' => 'dijual'
            ],
            [
                'user_id' => 4,
                'category_id' => 2,
                'name' => 'Buku Kalkulus Stewart',
                'description' => 'Kondisi 90%',
                'price' => 80000,
                'status' => 'dijual'
            ],
            [
                'user_id' => 3,
                'category_id' => 3,
                'name' => 'Meja Belajar Lipat',
                'description' => 'Cocok untuk anak kos',
                'price' => 150000,
                'status' => 'menunggu_verifikasi'
            ]
        ]);
    }
}
