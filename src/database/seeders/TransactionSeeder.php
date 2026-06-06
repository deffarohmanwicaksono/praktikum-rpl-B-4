<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaction::insert([
            // Buyer 3 - Seller 4
            // Laptop Lenovo Thinkpad Bekas
            [
                'product_id' => 2,
                'buyer_id' => 3,
                'purchase_link_id' => 2,
                'quantity' => 1,
                'total_price' => 3500000,
                'status' => 'selesai',
                'payment_method' => 'Transfer Bank',
                'payment_proof' => 'payments/bukti_transfer_001.jpg',
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
                'payment_method' => 'QRIS',
                'payment_proof' => 'payments/bukti_qris_001.jpg',
            ],

            // Buyer 12 - Seller 5
            // Buku Kalkulus Stewart
            // Link sudah digunakan sebelum expired
            [
                'product_id' => 3,
                'buyer_id' => 12,
                'purchase_link_id' => 4,
                'quantity' => 1,
                'total_price' => 78000,
                'status' => 'selesai',
                'payment_method' => 'Transfer Bank',
                'payment_proof' => 'payments/bukti_transfer_002.jpg',
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
                'status' => 'gagal',
                'payment_method' => 'E-Wallet',
                'payment_proof' => 'payments/bukti_ewallet_001.jpg',
            ],

            // Buyer 3 - Seller 31
            // Gitar Akustik Yamaha
            [
                'product_id' => 25,
                'buyer_id' => 3,
                'purchase_link_id' => 13,
                'quantity' => 1,
                'total_price' => 620000,
                'status' => 'dibayar',
                'payment_method' => 'Transfer Bank',
                'payment_proof' => 'payments/bukti_transfer_003.jpg',
            ],
        ]);
    }
}
