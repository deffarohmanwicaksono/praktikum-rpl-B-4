<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\PaymentAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PaymentAccount>
 */
class PaymentAccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = PaymentAccount::class;

    public function definition(): array
    {
        return [
            'payment_method' => 'Dana',
            'account_number' => '081234567890',
            'account_name' => fake()->name(),
        ];
    }

    public function forSeller(User $seller): static
    {
        return $this->state(function () use ($seller) {

            $method = fake()->randomElement([
                'BCA',
                'BRI',
                'BNI',
                'Mandiri',
                'Dana',
                'ShopeePay'
            ]);

            return [
                'user_id' => $seller->id,
                'payment_method' => $method,
                'account_number' =>
                    in_array($method, ['Dana', 'ShopeePay'])
                        ? $seller->phone_number
                        : fake()->numerify('############'),
                'account_name' => $seller->name,
            ];
        });
}
