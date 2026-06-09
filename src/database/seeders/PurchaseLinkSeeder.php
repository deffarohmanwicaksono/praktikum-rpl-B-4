<?php

namespace Database\Seeders;

use App\Models\PurchaseLink;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchaseLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PurchaseLink::insert([
            [
                'chat_id' => 1,
                'token' => 'SEMART-LINK-001',
                'deal_price' => 3400000,
                'expired_at' => now()->addDays(3),
                'is_used' => false
            ],
            [
                'chat_id' => 2,
                'token' => 'SEMART-LINK-002',
                'deal_price' => 75000,
                'expired_at' => now()->addDays(2),
                'is_used' => false
            ]
        ]);
    }
}
