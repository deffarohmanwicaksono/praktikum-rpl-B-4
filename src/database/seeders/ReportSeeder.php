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
                'product_id' => 3,
                'reason' => 'Deskripsi barang tidak sesuai.',
                'status' => 'menunggu'
            ],
            [
                'user_id' => 3,
                'product_id' => 1,
                'reason' => 'Diduga menggunakan foto milik orang lain.',
                'status' => 'ditindaklanjuti'
            ]
        ]);
    }
}
