<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Notification::insert([
            [
                'user_id' => 4,
                'type' => 'product_approved',
                'content' => 'Produk Laptop Lenovo Thinkpad Bekas telah disetujui admin.',
                'is_read' => false
            ],
            [
                'user_id' => 2,
                'type' => 'purchase_link',
                'content' => 'Seller telah mengirimkan link pembelian.',
                'is_read' => false
            ],
            [
                'user_id' => 1,
                'type' => 'report_created',
                'content' => 'Laporan baru telah dikirim dan menunggu tindak lanjut.',
                'is_read' => true
            ]
        ]);
    }
}
