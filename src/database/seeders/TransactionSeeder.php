<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\PurchaseLink;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataTransaction = [
            // Buyer 3 - Seller 4
            // Laptop Lenovo Thinkpad Bekas
            [
                'product_id' => 2,
                'buyer_id' => 3,
                'purchase_link_id' => 2,
                'quantity' => 1,
                'total_price' => 3500000,
                'status' => 'selesai',
                'payment_proof' => 'images/payments/bukti_transfer_001.jpg',
            ],

            // Buyer 2 - Seller 5
            // Buku Kalkulus Stewart
            [
                'product_id' => 3,
                'buyer_id' => 2,
                'purchase_link_id' => 3,
                'quantity' => 1,
                'total_price' => 75000,
                'status' => 'dibayar',
                'payment_proof' => 'images/payments/bukti_transfer_002.jpg',
            ],

            // Buyer 12 - Seller 5
            // Buku Kalkulus Stewart
            [
                'product_id' => 3,
                'buyer_id' => 12,
                'purchase_link_id' => 4,
                'quantity' => 1,
                'total_price' => 78000,
                'status' => 'selesai',
                'payment_proof' => 'images/payments/bukti_transfer_003.jpg',
            ],

            // Buyer 3 - Seller 23
            // Lampu Belajar LED
            [
                'product_id' => 28,
                'buyer_id' => 3,
                'purchase_link_id' => 9,
                'quantity' => 1,
                'total_price' => 60000,
                'status' => 'menunggu_pembayaran',
                'payment_method' => null,
                'payment_proof' => null,
            ],

            // Buyer 4 - Seller 26
            // Raket Badminton Yonex
            // Pembayaran gagal
            [
                'product_id' => 20,
                'buyer_id' => 4,
                'purchase_link_id' => 11,
                'quantity' => 1,
                'total_price' => 325000,
                'status' => 'selesai',
                'payment_proof' => 'images/payments/bukti_transfer_004.jpg',
            ],

            // Buyer 3 - Seller 31
            // Gitar Akustik Yamaha
            [
                'product_id' => 25,
                'buyer_id' => 3,
                'purchase_link_id' => 13,
                'quantity' => 1,
                'total_price' => 620000,
                'status' => 'selesai',
                'payment_proof' => 'images/payments/bukti_transfer_005.jpg',
            ],
        ];

        foreach ($dataTransaction as $transaction) {
            $link = PurchaseLink::findOrFail( $transaction['purchase_link_id'] );
            $transactionDate = fake()->dateTimeBetween(
                $link->created_at,
                min(now(), $link->expired_at)
            );
            $selectedPayment = fake()->randomElement($link->payment_methods);
            $paymentMethod = is_array($selectedPayment) 
                ? $selectedPayment['label'] 
                : $selectedPayment;
                

            $paidAt = null;
            $completedAt = null;

            if ( in_array( $transaction['status'], ['dibayar', 'selesai'] )) {
                $paidAt = fake()->dateTimeBetween(
                    $transactionDate,
                    '+1 day'
                );
            }

            if ( $transaction['status'] === 'selesai') {
                $completedAt = fake()->dateTimeBetween(
                    $paidAt,
                    '+2 day'
                );
            }

            $trx = Transaction::create([
                ...$transaction,

                'payment_method' => $transaction['payment_method'] ?? $paymentMethod,
                'created_at' => $transactionDate,
                'updated_at' =>
                    $completedAt
                    ?? $paidAt
                    ?? $transactionDate,

                'paid_at' => $paidAt,
                'completed_at' => $completedAt,
            ]);

            $trx->update([
                'transaction_code' =>
                    'TRX-' .
                    $trx->created_at->format('Y') .
                    '-' .
                    str_pad($trx->id, 3, '0', STR_PAD_LEFT),
            ]);
        }

        // Factory
        $eligibleLinks = PurchaseLink::where('is_used', true)
            ->doesntHave('transaction')
            ->whereHas('chat.product', function ($q) {
                $q->where('status', 'dijual')
                ->where('stock', '>', 0);
            })
            ->get();

        foreach ($eligibleLinks as $link) {
            $transaction = Transaction::factory()
                ->forPurchaseLink($link)
                ->create();

            $transaction->update([
                'transaction_code' =>
                    'TRX-' .
                    $transaction->created_at->format('Y') .
                    '-' .
                    str_pad($transaction->id, 3, '0', STR_PAD_LEFT),
            ]);

            if ( in_array( $transaction->status, ['dibayar', 'selesai', 'gagal'] ) ) {
                $link->update([ 'is_used' => true ]);
            }
            if ( $transaction->status === 'selesai' ) {
                $product = $transaction->product;
                $product->decrement(
                    'stock',
                    $transaction->quantity
                );
                $product->refresh();

                if ($product->stock <= 0) {
                    $product->update([
                        'status' => 'sold_out'
                    ]);
                }
            }
        }
    }
}
