<?php

namespace Database\Factories;

use App\Models\ProductVerification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductVerification>
 */
class ProductVerificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ProductVerification::class;
    
    public function definition(): array
    {
        return [
            'status' => fake()->randomElement([
                'disetujui',
                'ditolak',
            ]),

            'reason' => fake()->optional()->sentence(),
        ];
    }
}
