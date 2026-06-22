<?php

namespace Database\Seeders;

use App\Models\PurchaseLink;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchaseLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataPurchaseLinks = [
            [
                'chat_id' => 1,  // Buyer 2 - Seller 4
                'token' => 'SEMART-LINK-001',
                'deal_price' => 200000,
                'is_used' => false
            ],
            [
                'chat_id' => 2,  // Buyer 3 - Seller 4
                'token' => 'SEMART-LINK-002',
                'deal_price' => 3500000,
                'is_used' => true
            ],
            [
                'chat_id' => 4, // Buyer 2 - Seller 5
                'token' => 'SEMART-LINK-003',
                'deal_price' => 75000,
                'is_used' => true
            ],

            [
                'chat_id' => 5, // Buyer 12 - Seller 5
                'token' => 'SEMART-LINK-004',
                'deal_price' => 78000,
                'is_used' => true
            ],

            [
                'chat_id' => 6, // Buyer 20 - Seller 5
                'token' => 'SEMART-LINK-005',
                'deal_price' => 80000,
                'is_used' => false
            ],

            [
                'chat_id' => 7, // Buyer 2 - Seller 21
                'token' => 'SEMART-LINK-006',
                'deal_price' => 110000,
                'is_used' => false
            ],

            [
                'chat_id' => 9,  // Buyer 3 - Seller 22
                'token' => 'SEMART-LINK-007',
                'deal_price' => 1150000,
                'is_used' => true
            ],

            [
                'chat_id' => 10,  // Buyer 2 - Seller 22
                'token' => 'SEMART-LINK-008',
                'deal_price' => 75000,
                'is_used' => false
            ],

            [
                'chat_id' => 11, // Buyer 3 - Seller 23
                'token' => 'SEMART-LINK-009',
                'deal_price' => 60000,
                'is_used' => true
            ],

            [
                'chat_id' => 13,  // Buyer 2 - Seller 25
                'token' => 'SEMART-LINK-010',
                'deal_price' => 90000,
                'is_used' => true
            ],

            [
                'chat_id' => 14, // Buyer 4 - Seller 26
                'token' => 'SEMART-LINK-011',
                'deal_price' => 325000,
                'is_used' => true
            ],

            [
                'chat_id' => 18,  // Buyer 2 - Seller 29
                'token' => 'SEMART-LINK-012',
                'deal_price' => 170000,
                'is_used' => false
            ],

            [
                'chat_id' => 20, // Buyer 3 - Seller 31
                'token' => 'SEMART-LINK-013',
                'deal_price' => 620000,
                'is_used' => true
            ],
        ];

        foreach ($dataPurchaseLinks as $link) {
            $chat = Chat::findOrFail( $link['chat_id']);
            $lastMessage = $chat->messages()->latest('created_at')->first();
            $linkDate = $lastMessage->created_at->copy()->addSeconds(rand(30, 600));
            $sellerMethods = $chat->seller->paymentAccounts
                ->map(function ($account) {

                    return [
                        'id' => $account->id,
                        'label' => $account->payment_method,
                        'number' => $account->account_number,
                        'owner' => $account->account_name,

                        'type' => in_array(
                            $account->payment_method,
                            ['Dana', 'ShopeePay']
                        ) ? 'ewallet' : 'bank',

                        'icon' => in_array(
                            $account->payment_method,
                            ['Dana', 'ShopeePay']
                        ) ? 'wallet2' : 'bank2',
                    ];
                })
                ->values()->toArray();

            $purchaseLink = PurchaseLink::create([
                ...$link,

                'payment_methods' => $sellerMethods,
                'created_at' => $linkDate,
                'updated_at' => $linkDate,
                'expired_at' => $linkDate->copy()->addMinutes(rand(15, 1440)),
            ]);
            Message::create([
                'chat_id'   => $chat->id,
                'sender_id' => $chat->seller_id,
                'message'   => '[PURCHASE_LINK:' . $purchaseLink->token . ']',
                'created_at'=> $linkDate,
                'updated_at'=> $linkDate,
            ]);
        }

        // Factory untuk generate purchase link 
        $eligibleChats = Chat::whereHas(
            'product',
            fn ($q) => $q->where('status', 'dijual')
        )->doesntHave('purchaseLinks')->get();
        foreach ($eligibleChats as $chat) {
            if (fake()->boolean(60)) {
                $purchaseLink = PurchaseLink::factory()->forChat($chat)->create();

                Message::create([
                    'chat_id'   => $chat->id,
                    'sender_id' => $chat->seller_id,
                    'message'   => '[PURCHASE_LINK:' . $purchaseLink->token . ']',
                    'created_at'=> $purchaseLink->created_at,
                    'updated_at'=> $purchaseLink->created_at,
                ]);
            }
        }
    }
}
