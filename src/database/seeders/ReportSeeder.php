<?php

namespace Database\Seeders;

use App\Models\Report;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Report::insert([
            [
                'user_id' => 2,
                'product_id' => 5, // Smartphone Samsung A12
                'reason' => 'Foto produk diduga hasil AI dan tidak menunjukkan kondisi barang yang sebenarnya.',
                'status' => 'menunggu',
            ],
            [
                'user_id' => 3,
                'product_id' => 8, // Buku Struktur Data Java
                'reason' => 'Produk terindikasi menggunakan foto yang diambil dari internet tanpa menunjukkan barang asli yang dijual.',
                'status' => 'ditindaklanjuti',
            ],
            [
                'user_id' => 4,
                'product_id' => 11, // Kipas Angin Miyako
                'reason' => 'Deskripsi produk mengandung informasi yang diduga menyesatkan mengenai kondisi barang.',
                'status' => 'ditolak',
            ],
            [
                'user_id' => 2,
                'product_id' => 23, // Board Game Monopoly
                'reason' => 'Barang terlihat tidak layak pakai.',
                'status' => 'ditolak',
            ],
            [
                'user_id' => 3,
                'product_id' => 26, // Hair Dryer Philips
                'reason' => 'Foto produk tidak sesuai dengan kategori barang yang dijual.',
                'status' => 'ditolak',
            ],
            [
                'user_id' => 12,
                'product_id' => 31, // Power Bank Xiaomi
                'reason' => 'Produk diduga merupakan barang replika atau tidak mencantumkan informasi keaslian produk.',
                'status' => 'ditindaklanjuti',
            ],
            [
                'user_id' => 13,
                'product_id' => 32, // Keyboard Mechanical Fantech
                'reason' => 'Seller mengunggah foto yang sama pada beberapa produk berbeda sehingga diduga spam listing.',
                'status' => 'menunggu',
            ],
            [
                'user_id' => 14,
                'product_id' => 35, // Dispenser Air Mini
                'reason' => 'Produk diduga tidak layak pakai berdasarkan kondisi yang terlihat pada foto.',
                'status' => 'menunggu',
            ],
            [
                'user_id' => 15,
                'product_id' => 39, // Organizer Kosmetik
                'reason' => 'Foto produk diindikasi merupakan hasil edit atau manipulasi.',
                'status' => 'ditindaklanjuti',
            ],
            [
                'user_id' => 16,
                'product_id' => 40, // Ukulele Concert
                'reason' => 'Foto produk mengandung watermark toko lain sehingga kepemilikan barang diragukan.',
                'status' => 'menunggu',
            ],
        ]);
    }
}
