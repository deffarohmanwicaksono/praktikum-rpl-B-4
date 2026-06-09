<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\Product;
use App\Models\ProductVerification;
use App\Models\Message;
use App\Models\Transaction;
use App\Models\Report;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Upload Produk Disetujui
        $approvedProducts = Product::where('status', 'dijual')
            ->take(10)
            ->get();

        foreach ($approvedProducts as $product) {
            Notification::create([
                'user_id' => $product->user_id,
                'type' => 'product_approved',
                'content' =>
                    'Produk ' . $product->name . ' telah disetujui admin dan aktif di marketplace.',

                'is_read' => fake()->boolean(60),

                'created_at' =>
                    $product->created_at->copy()->addMinutes(rand(5, 60)),

                'updated_at' =>
                    $product->created_at->copy()->addMinutes(rand(5, 60)),
            ]);
        }

        // Upload Produk Ditolak
        $rejectedVerifications = ProductVerification::with('product')
            ->where('status', 'ditolak')
            ->get();

        foreach ($rejectedVerifications as $verification) {
            $notifTime = $verification->created_at
                ->copy()
                ->addSeconds(rand(5, 60));

            Notification::create([
                'user_id' => $verification->product->user_id,

                'type' => 'product_rejected',

                'content' =>
                    'Produk "' .
                    $verification->product->name .
                    '" ditolak admin. Alasan: ' .
                    $verification->reason,

                'is_read' => false,

                'created_at' => $notifTime,
                'updated_at' => $notifTime,
            ]);
        }

        // Pembayaran Diterima
        $paidTransactions = Transaction::whereNotNull('paid_at')->get();

        foreach ($paidTransactions as $trx) {
            Notification::create([
                'user_id' => $trx->product->user_id,
                'type' => 'payment_received',

                'content' =>
                    'Buyer telah menyelesaikan pembayaran untuk produk ' .
                    $trx->product->name .
                    '.',

                'is_read' => fake()->boolean(50),

                'created_at' => $trx->paid_at->copy()->addSeconds(rand(5, 60)),
                'updated_at' => $trx->paid_at->copy()->addSeconds(rand(5, 60)),
            ]);
        }

        //Transaksi Selesai
        $completedTransactions = Transaction::where('status', 'selesai')
            ->whereNotNull('completed_at')
            ->get();

        foreach ($completedTransactions as $trx) {
            $notifTime =
                $trx->completed_at->copy()
                ->addSeconds(rand(5, 60));

            // buyer
            Notification::create([
                'user_id' => $trx->buyer_id,

                'type' => 'transaction_completed',

                'content' =>
                    'Transaksi untuk produk ' .
                    $trx->product->name .
                    ' telah selesai.',

                'is_read' => fake()->boolean(50),

                'created_at' => $notifTime,
                'updated_at' => $notifTime,
            ]);

            // seller
            Notification::create([
                'user_id' => $trx->product->user_id,

                'type' => 'transaction_completed',

                'content' =>
                    'Transaksi untuk produk ' .
                    $trx->product->name .
                    ' telah selesai.',

                'is_read' => fake()->boolean(50),

                'created_at' => $notifTime,
                'updated_at' => $notifTime,
            ]);
        }

        // Pesan Baru
        $messages = Message::with('chat')->get();

        foreach ($messages as $message) {
            $chat = $message->chat;

            $receiverId =
                $message->sender_id === $chat->buyer_id
                    ? $chat->seller_id
                    : $chat->buyer_id;

            $notificationTime = Carbon::parse(
                $message->created_at
            )->addSeconds(rand(5, 30));

            Notification::create([
                'user_id' => $receiverId,
                'type' => 'new_message',
                'content' =>
                    'Anda menerima pesan baru dari pengguna lain dalam sesi chat.',

                'is_read' => fake()->boolean(50),

                'created_at' => $notificationTime,
                'updated_at' => $notificationTime,
            ]);
        }

        // Report
        $reports = Report::where('status', 'ditindaklanjuti')
            ->get();
        
        foreach ($reports as $report) {
            $notifTime =
                $report->updated_at->copy()
                ->addSeconds(rand(5, 60));

            Notification::create([
                'user_id' => $report->product->user_id,

                'type' => 'warning',

                'content' =>
                    'Produk "' .
                    $report->product->name .
                    '" telah ditindaklanjuti oleh admin karena melanggar aturan marketplace.',

                'is_read' => false,

                'created_at' => $notifTime,
                'updated_at' => $notifTime,
            ]);
        }
    }
}
