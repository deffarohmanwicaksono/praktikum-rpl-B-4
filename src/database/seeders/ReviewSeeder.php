<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Review::insert([
            [
                'transaction_id' => 1,
                'rating' => 5,
                'comment' => 'Barang sesuai deskripsi.'
            ],
            [
                'transaction_id' => 2,
                'rating' => 4,
                'comment' => 'Pengiriman cepat.'
            ]
        ]);
    }
}
