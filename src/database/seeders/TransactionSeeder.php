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
            [
                'product_id' => 1,
                'buyer_id' => 2,
                'quantity' => 1,
                'total_price' => 3500000,
                'status' => 'selesai'
            ],
            [
                'product_id' => 2,
                'buyer_id' => 3,
                'quantity' => 1,
                'total_price' => 80000,
                'status' => 'dibayar'
            ]
        ]);
    }
}
