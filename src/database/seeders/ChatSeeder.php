<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chatData =[
            // Seller 4
            [
                'buyer_id' => 2,
                'seller_id' => 4,
                'product_id' => 1, // Headset Gaming
            ],
            [
                'buyer_id' => 3,
                'seller_id' => 4,
                'product_id' => 2, // Laptop Lenovo Thinkpad Bekas
            ],
            [
                'buyer_id' => 9,
                'seller_id' => 4,
                'product_id' => 1, // Headset Gaming
            ],

            // Seller 5
            [
                'buyer_id' => 2,
                'seller_id' => 5,
                'product_id' => 3, // Buku Kalkulus
            ],
            [
                'buyer_id' => 12,
                'seller_id' => 5,
                'product_id' => 3, // Buku Kalkulus
            ],
            [
                'buyer_id' => 20,
                'seller_id' => 5,
                'product_id' => 3, // Buku Kalkulus
            ],
            // Seller 21
            [
                'buyer_id' => 2,
                'seller_id' => 21,
                'product_id' => 15, // Almamater UNS
            ],
            [
                'buyer_id' => 16,
                'seller_id' => 21,
                'product_id' => 26, // Hair Dryer Philips
            ],

            // Seller 22
            [
                'buyer_id' => 3,
                'seller_id' => 22,
                'product_id' => 5, // Samsung A12
            ],
            [
                'buyer_id' => 2,
                'seller_id' => 22,
                'product_id' => 16, // Hoodie Hitam Polos
            ],

            //Seller 23
            [
                'buyer_id' => 3,
                'seller_id' => 23,
                'product_id' => 28, // Lampu Belajar LED
            ],

            //Seller 24
            [
                'buyer_id' => 14,
                'seller_id' => 24,
                'product_id' => 18, // Sepatu Converse Bekas
            ],

            // Seller 25
            [
                'buyer_id' => 2,
                'seller_id' => 25,
                'product_id' => 8, // Buku Struktur Data
            ],

            // Seller 26
            [
                'buyer_id' => 4,
                'seller_id' => 26,
                'product_id' => 20, // Raket Yonex
            ],
            [
                'buyer_id' => 13,
                'seller_id' => 26,
                'product_id' => 9, // Kalkulator
            ],

            //Seller 27
           [
                'buyer_id' => 15,
                'seller_id' => 27,
                'product_id' => 21, // Dumbbell 5 Kg
            ],

            // Seller 28
            [
                'buyer_id' => 5,
                'seller_id' => 28,
                'product_id' => 11, // Kipas Angin
            ],

            // Seller 29
            [
                'buyer_id' => 2,
                'seller_id' => 29,
                'product_id' => 23, // Monopoly
            ],
            [
                'buyer_id' => 17,
                'seller_id' => 29,
                'product_id' => 12, // Rice Cooker Cosmos
            ],

            // Seller 31
            [
                'buyer_id' => 3,
                'seller_id' => 31,
                'product_id' => 25, // Gitar
            ],
        ];

        foreach ($chatData as $chat){
            $product = Product::findOrFail(
                $chat['product_id']
            );

            Chat::factory()->forProduct($product)->create([
                'buyer_id' => $chat['buyer_id'],
            ]);
        }
        

        // Factory
        $products = Product::all();
        for ($i = 0; $i < 20; $i++) {
            $product = $products->random();
            Chat::factory()->forProduct($product)->create();
        }
    }
}
