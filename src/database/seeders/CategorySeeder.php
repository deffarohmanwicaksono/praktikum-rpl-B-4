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
                'name' => 'Elektronik dan Gadget',
                'description' => 'Laptop, smartphone, tablet, printer, headset, speaker, dan perangkat elektronik lainnya.'
            ],
            [
                'name' => 'Buku dan Alat Tulis',
                'description' => 'Buku fiksi, buku non-fiksi, kalkulator, alat tulis, dan perlengkapan kuliah lainnya.'
            ],
            [
                'name' => 'Perlengkapan Kos',
                'description' => 'Barang kebutuhan sehari-hari, seperti peralatan dapur, peralatan mandi, dan perlengkapan tidur.'
            ],
            [
                'name' => 'Fashion',
                'description' => 'Pakaian, aksesoris, atribut kampus'
            ],
            [
                'name' => 'Olahraga',
                'description' => 'Raket, bola, sepatu olahraga, dumbbell, dan perlengkapan olahraga lainnya.'
            ],
            [
                'name' => 'Hobi & Koleksi',
                'description' => 'Action figure, board game, kartu koleksi, alat musik, dan barang hobi lainnya.'
            ],
            [
                'name' => 'Perawatan & Kecantikan',
                'description' => 'Hair dryer, catokan, organizer kosmetik, skincare,dan perlengkapan perawatan pribadi lainnya.'
            ],
            [
                'name' => 'Lainnya',
                'description' => 'Barang kategori lainnya'
            ]
        ]);
    }
}
