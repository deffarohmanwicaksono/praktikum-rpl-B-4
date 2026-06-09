<?php

namespace Database\Seeders;

use App\Models\Wishlist;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WishlistSeeder extends Seeder
{

    public function run(): void
    {
        $dataWishlist = ([
            // User 2
            [
                'user_id' => 2,
                'product_id' => 1
            ],
            [
                'user_id' => 2,
                'product_id' => 2
            ],
            [
                'user_id' => 2,
                'product_id' => 12
            ],
            [
                'user_id' => 2,
                'product_id' => 20
            ],

            // User 3
            [
                'user_id' => 3,
                'product_id' => 1
            ],
            [
                'user_id' => 3,
                'product_id' => 8
            ],
            [
                'user_id' => 3,
                'product_id' => 15
            ],
            [
                'user_id' => 3,
                'product_id' => 25
            ],

            // User 4
            [
                'user_id' => 4,
                'product_id' => 3
            ],
            [
                'user_id' => 4,
                'product_id' => 7
            ],
            [
                'user_id' => 4,
                'product_id' => 18
            ],
            [
                'user_id' => 4,
                'product_id' => 29
            ],

            // User 5
            [
                'user_id' => 5,
                'product_id' => 4
            ],
            [
                'user_id' => 5,
                'product_id' => 10
            ],
            [
                'user_id' => 5,
                'product_id' => 21
            ],
            [
                'user_id' => 5,
                'product_id' => 30
            ],

            // User 20
            [
                'user_id' => 20,
                'product_id' => 1
            ],
            [
                'user_id' => 20,
                'product_id' => 10
            ],
            [
                'user_id' => 20,
                'product_id' => 29
            ],
            [
                'user_id' => 20,
                'product_id' => 30
            ],

            // User 21
            [
                'user_id' => 21,
                'product_id' => 1
            ],
            [
                'user_id' => 21,
                'product_id' => 10
            ],
            [
                'user_id' => 21,
                'product_id' => 29
            ],
            [
                'user_id' => 21,
                'product_id' => 30
            ],

            // User 30
            [
                'user_id' => 30,
                'product_id' => 2
            ],
            [
                'user_id' => 30,
                'product_id' => 12
            ],
            [
                'user_id' => 30,
                'product_id' => 19
            ],
            [
                'user_id' => 30,
                'product_id' => 27
            ],

            // User 31
            [
                'user_id' => 31,
                'product_id' => 2
            ],
            [
                'user_id' => 31,
                'product_id' => 12
            ],
            [
                'user_id' => 31,
                'product_id' => 19
            ],
            [
                'user_id' => 31,
                'product_id' => 27
            ],
        ]);

        foreach ($dataWishlist as $wishlist) {
            $product = Product::findOrFail($wishlist['product_id']);

            $startDate = $product->created_at->gt(now()) ? now() : $product->created_at;

            $wishlistDate = fake()->dateTimeBetween($startDate, now());

            Wishlist::create([
                ...$wishlist,
                'created_at' => $wishlistDate,
                'updated_at' => $wishlistDate,
            ]);
        }
    }
}
