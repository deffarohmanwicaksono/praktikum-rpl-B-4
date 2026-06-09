<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            ProductImageSeeder::class,
            PaymentAccountSeeder::class,
            ChatSeeder::class,
            MessageSeeder::class,
            PurchaseLinkSeeder::class,
            TransactionSeeder::class,
            ReviewSeeder::class,
            WishlistSeeder::class,
            ReportSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
