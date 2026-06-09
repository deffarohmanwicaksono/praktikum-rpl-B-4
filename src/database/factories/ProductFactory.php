<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement([
            'dijual',
            'dijual',
            'dijual',
            'dijual',
            'sold_out',
            'menunggu_verifikasi',
            'ditolak',
        ]);

        return [
            'description' => fake()->paragraph(),
            'price' => fake()->numberBetween(
                10000,
                1000000
            ),
            'stock' => $status === 'sold_out' ?0 :1,
            'condition' => fake()->randomElement([
                'bekas_seperti_baru',
                'bekas_baik',
                'bekas_layak_pakai',
            ]),
            'status' => $status,
        ];
    }

    public function forSeller(User $seller): static
    {
        return $this->state(function () use ($seller) {

            $productDate = fake()->dateTimeBetween(
                $seller->created_at,
                'now'
            );

            return [
                'user_id' => $seller->id,
                'created_at' => $productDate,
                'updated_at' => $productDate,
            ];
        });
    }
}
