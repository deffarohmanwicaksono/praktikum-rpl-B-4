<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataReport = ([
            [
                'user_id' => 2,
                'product_id' => 5, // Smartphone Samsung A12
                'reason' => 'Foto produk diduga hasil AI dan tidak menunjukkan kondisi barang yang sebenarnya.',
                'status' => 'ditolak',
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
                'user_id' => 12,
                'product_id' => 31, // Power Bank Xiaomi
                'reason' => 'Produk diduga merupakan barang replika atau tidak mencantumkan informasi keaslian produk.',
                'status' => 'menunggu',
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
                'status' => 'ditolak',
            ],
            [
                'user_id' => 16,
                'product_id' => 40, // Ukulele Concert
                'reason' => 'Foto produk mengandung watermark toko lain sehingga kepemilikan barang diragukan.',
                'status' => 'menunggu',
            ],
        ]);

        foreach ($dataReport as $report) {
            $product = Product::findOrFail( $report['product_id']);

            $reportDate = fake()->dateTimeBetween(
                $product->created_at->addHours(1),
                now()
            );

            Report::create([
                ...$report,
                'created_at' => $reportDate,
                'updated_at' => $reportDate,
            ]);
        }

        // Factory
        $eligibleProducts = Product::where('status', 'dijual')
            ->whereDoesntHave('transactions')
            ->doesntHave('reports')
            ->get();
        
        foreach ($eligibleProducts->random(2) as $product) {
            $reportDate = fake()->dateTimeBetween(
                $product->created_at->addHours(1),
                now()
            );

            Report::factory()->create([
                'user_id' => User::where('id', '!=', $product->user_id)
                    ->whereJsonContains('roles', 'buyer')
                    ->inRandomOrder()
                    ->first()
                    ->id,
                'product_id' => $product->id,
                'status' => 'ditindaklanjuti',
                'created_at' => $reportDate,
                'updated_at' => $reportDate,
            ]);
        }
    }
}
