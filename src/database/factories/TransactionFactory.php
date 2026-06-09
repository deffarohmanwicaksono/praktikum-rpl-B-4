<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\PurchaseLink;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
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
    public function forPurchaseLink( PurchaseLink $link ): static{
        return $this->state ( function () use ($link) {
            $product = $link->chat->product;

            $status = fake()->randomElement([
                'menunggu_pembayaran',
                'menunggu_pembayaran',
                'dibayar',
                'selesai',
                'selesai',
                'gagal',
            ]);

            $endDate = Carbon::parse($link->expired_at);

            if ($endDate->lessThan($link->created_at)) {
                $endDate = Carbon::parse($link->created_at)->addHour();
            }

            $transactionDate = fake()->dateTimeBetween(
                $link->created_at,
                $endDate
            );

            $paidAt = null;
            $completedAt = null;

            $paymentMethod = null;
            $paymentProof = null;

            if ($status === 'menunggu_pembayaran') {
                $paidAt = null;
                $completedAt = null;

                $paymentMethod = null;
                $paymentProof = null;
            }
            elseif ( in_array( $status, ['dibayar', 'selesai', 'gagal'] )) {
                $paidAt = Carbon::parse( $transactionDate )->addMinutes( rand(5, 180) );
                $paymentMethod = fake()->randomElement( $link->payment_methods );
                $proofImages = [
                    'images/payments/bukti_transfer_001.jpg',
                    'images/payments/bukti_transfer_002.jpg',
                    'images/payments/bukti_transfer_003.jpg',
                    'images/payments/bukti_transfer_004.jpg',
                    'images/payments/bukti_transfer_005.jpg',
                ];
                $paymentProof = fake()->randomElement($proofImages);
            }

            if ($status === 'selesai') {
                $completedAt = Carbon::parse( $paidAt )->addMinutes( rand(10, 720) );
            }

            return [
                'purchase_link_id' => $link->id,
                'product_id' => $link->chat->product_id,
                'buyer_id' => $link->chat->buyer_id,
                'quantity' => 1,
                'total_price' => $link->deal_price,
                'status' => $status,
                'payment_method' => $paymentMethod,
                'payment_proof' => $paymentProof,
                'created_at' => $transactionDate,
                'updated_at' => $completedAt ?? $paidAt ?? $transactionDate,
                'paid_at' => $paidAt,
                'completed_at' => $completedAt,
            ];
        });
    }
}
