<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'rating' => fake()->numberBetween(3, 5),

            'comment' => fake()->randomElement([
                'Barang sesuai deskripsi dan masih berfungsi dengan baik.',
                'Seller responsif dan proses transaksi berjalan lancar.',
                'Kondisi barang sesuai foto, sangat puas dengan pembelian ini.',
                'Pengiriman cepat dan komunikasi dengan seller sangat baik.',
                'Harga sesuai dengan kondisi barang yang diterima.',
                'Barang diterima dalam kondisi baik dan lengkap.',
                'Transaksi aman dan seller sangat membantu saat proses pembelian.',
                'Produk masih layak pakai dan sesuai ekspektasi.',
                'Seller fast respon, sangat ramah, dan mudah diajak nego.',
            ]),
        ];
    }
}
