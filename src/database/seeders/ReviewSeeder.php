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
                'comment' => 'Laptop masih sangat bagus, sesuai deskripsi dan performanya lancar. Seller juga responsif saat diajak diskusi.'
            ],
            [
                'transaction_id' => 3,
                'rating' => 4,
                'comment' => 'Buku dalam kondisi baik dan lengkap. Pengiriman cepat, hanya ada sedikit bekas penggunaan pada sampul.'
            ],
            [
                'transaction_id' => 6,
                'rating' => 5,
                'comment' => 'Gitar sesuai deskripsi, suara masih bagus dan senar dalam kondisi baik. Seller ramah dan proses transaksi berjalan lancar.'
            ],
        ]);
    }
}
