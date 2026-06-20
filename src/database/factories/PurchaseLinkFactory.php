<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\Message;
use App\Models\PurchaseLink;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * @extends Factory<PurchaseLink>
 */
class PurchaseLinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = PurchaseLink::class;

    public function definition(): array
    { 
        return [
            'token' => 'SEMART-LINK-' . Str::upper(Str::random(10)),
            'deal_price' => 0,
            'expired_at' => now()->addMinutes(rand(15, 1440)),
            'is_used' => fake()->boolean(40),
        ];
    }

    public function forChat(Chat $chat): static
    {
        return $this->state(function () use ($chat) {

            $product = $chat->product;
            $seller = $product->user;
            $lastMessage = $chat->messages()->latest('created_at')->first();
            $linkDate = Carbon::parse( $lastMessage->created_at)->addSeconds(
                rand(30, 600)
            );

            $discount = fake()->numberBetween(
                0,
                min(50000, $product->price * 0.1)
            );

            $availableMethods = $seller
                ->paymentAccounts
                ->pluck('payment_method')
                ->toArray();

            return [
                'chat_id' => $chat->id,

                'deal_price' => max( 1000, $product->price - $discount ),
                'note' => fake()->optional(0.7)->randomElement([
                    'Silakan transfer maksimal hari ini.',
                    'Barang akan dikirim setelah pembayaran dikonfirmasi.',
                    'Mohon konfirmasi setelah melakukan pembayaran.',
                    'Terima kasih sudah mau bertransaksi dengan saya.',
                    'Barang akan dikirim lewat ekspedisi.',
                ]),

                'payment_methods' => $availableMethods,

                'created_at' => $linkDate,
                'updated_at' => $linkDate,
                'expired_at' => Carbon::parse($linkDate)->addMinutes(rand(15, 1440)),
            ];
        });
    }
}
