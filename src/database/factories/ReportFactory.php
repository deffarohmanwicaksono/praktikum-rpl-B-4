<?php

namespace Database\Factories;

use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Report::class;

    public function definition(): array
    {
        return [
            'reason' => fake()->randomElement([
                'Foto produk diduga tidak menunjukkan kondisi barang sebenarnya.',
                'Deskripsi produk dianggap kurang sesuai dengan kondisi barang.',
                'Produk diduga menggunakan foto dari internet.',
                'Foto produk tidak relevan dengan barang yang dijual.',
                'Terdapat indikasi spam listing pada produk ini.',
                'Informasi kondisi barang dianggap tidak lengkap.',
                'Produk diduga tidak sesuai kategori.',
                'Foto produk mengandung watermark pihak lain.',
            ]),

            'status' => fake()->randomElement([
                'menunggu',
                'menunggu',
                'ditolak',
                'ditindaklanjuti',
            ]),
        ];
    }
}
