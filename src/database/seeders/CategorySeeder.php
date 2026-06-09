<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Elektronik',
                'description' => 'Laptop, smartphone, tablet, printer, headset, speaker, dan perangkat elektronik lainnya.'
            ],
            [
                'name' => 'Buku',
                'description' => 'Buku fiksi, buku non-fiksi, kalkulator, alat tulis, dan perlengkapan kuliah lainnya.'
            ],
            [
                'name' => 'Peralatan Kos',
                'description' => 'Barang kebutuhan sehari-hari, seperti peralatan dapur, peralatan mandi, dan perlengkapan tidur.'
            ],
            [
                'name' => 'Pakaian',
                'description' => 'Pakaian, aksesoris, atribut kampus'
            ],
            [
                'name' => 'Olahraga',
                'description' => 'Raket, bola, sepatu olahraga, dumbbell, dan perlengkapan olahraga lainnya.'
            ],
            [
                'name' => 'Hobi',
                'description' => 'Action figure, board game, kartu koleksi, alat musik, dan barang hobi lainnya.'
            ],
            [
                'name' => 'Kecantikan',
                'description' => 'Hair dryer, catokan, organizer kosmetik, skincare,dan perlengkapan perawatan pribadi lainnya.'
            ],
            [
                'name' => 'Lainnya',
                'description' => 'Barang kategori lainnya'
            ]
        ]);
    }
}
