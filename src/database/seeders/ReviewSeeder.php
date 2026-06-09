<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataReview = ([
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

        foreach ($dataReview as $review) {
            $transaction = Transaction::findOrFail(
                $review['transaction_id']
            );

            $reviewDate = $transaction->completed_at
                ->copy()
                ->addHours(rand(2, 12));

            Review::create([
                ...$review,
                'created_at' => $reviewDate,
                'updated_at' => $reviewDate,
            ]);
        }

        // Factory

        $eligibleTransactions = Transaction::where( 'status', 'selesai')
            ->whereNotNull('completed_at')
            ->doesntHave('review')
            ->get();

        foreach ($eligibleTransactions as $transaction) {
        if (fake()->boolean(90)) {
            $reviewDate = $transaction->completed_at
                ->copy()
                ->addHours(rand(1, 72));

            Review::factory()->create([
                'transaction_id' => $transaction->id,

                'created_at' => $reviewDate,
                'updated_at' => $reviewDate,
            ]);
        }
    }
    }
}
