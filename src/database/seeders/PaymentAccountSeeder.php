<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\PaymentAccount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            'BCA',
            'BRI',
            'BNI',
            'Mandiri',
            'Dana',
            'ShopeePay'
        ];

        $sellers = User::whereJsonContains( 'roles', 'seller' )->get();

        foreach ($sellers as $seller) {
            $sellerProducts = Product::where( 'user_id', $seller->id )->get();

            if ($sellerProducts->isEmpty()) {
                continue;
            }

            $firstProductDate =
                $sellerProducts
                    ->sortBy('created_at')
                    ->first()
                    ->created_at;

            $selectedMethods = collect($methods)
                ->shuffle()
                ->take(rand(1, 4));

            foreach ($selectedMethods as $method) {
                $accountDate = fake()->dateTimeBetween(
                    $firstProductDate,
                    'now'
                );

                PaymentAccount::create([
                    'user_id' => $seller->id,
                    'payment_method' => $method,

                    'account_number' =>
                        in_array($method, ['Dana', 'ShopeePay'])
                            ? $seller->phone_number
                            : fake()->numerify('############'),

                    'account_name' => $seller->name,
                    'created_at' => $accountDate,
                    'updated_at' => $accountDate,
                ]);
            }
        }
    }
}
