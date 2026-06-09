<?php

namespace Database\Seeders;

use App\Models\Chat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Chat::insert([
            [
                'buyer_id' => 2,
                'seller_id' => 4,
                'product_id' => 1,
            ],
            [
                'buyer_id' => 3,
                'seller_id' => 5,
                'product_id' => 2,
            ]
        ]);
    }
}
