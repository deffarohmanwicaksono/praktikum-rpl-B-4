<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVerification;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductVerificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminIds = [1, 6, 7, 8];
        $products = Product::all();

        foreach ($products as $product) {
            if ($product->status === 'menunggu_verifikasi') {
                continue;
            }

            $verificationStatus = $product->status === 'ditolak' ? 'ditolak' : 'disetujui';

            $verificationDate = fake()->dateTimeBetween(
                $product->created_at->copy()->addMinutes(5),
                $product->created_at->copy()->addHours(24)
            );

            ProductVerification::create([
                'product_id' => $product->id,
                'admin_id' => fake()->randomElement( $adminIds ),
                'status' => $verificationStatus,

                'reason' => $verificationStatus === 'ditolak'
                    ? fake()->randomElement([
                        'Foto produk tidak sesuai ketentuan marketplace.',
                        'Deskripsi produk tidak mencerminkan kondisi barang.',
                        'Produk terindikasi duplikat dari listing lain.',
                        'Informasi produk tidak lengkap.',
                    ])
                    : null,

                'created_at' => $verificationDate,
                'updated_at' => $verificationDate,
            ]);
        }
    }
}
