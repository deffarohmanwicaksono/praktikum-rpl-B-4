<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Chat>
 */
class ChatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    public function forProduct(Product $product): static
    {
        return $this->state(function () use ($product) {

            $chatDate = fake()->dateTimeBetween(
                $product->created_at,
                'now'
            );

            $buyer = User::where('id', '!=', $product->user_id)
                ->inRandomOrder()
                ->first();

            return [
                'product_id' => $product->id,
                'seller_id' => $product->user_id,
                'buyer_id' => $buyer->id,
                'created_at' => $chatDate,
                'updated_at' => $chatDate,
            ];
        });
    }
}
