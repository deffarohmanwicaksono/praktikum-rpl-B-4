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
                'description' => 'Barang elektronik'
            ],
            [
                'name' => 'Buku',
                'description' => 'Buku kuliah dan bacaan'
            ],
            [
                'name' => 'Peralatan Kos',
                'description' => 'Kebutuhan kos'
            ],
            [
                'name' => 'Fashion',
                'description' => 'Pakaian dan aksesoris'
            ],
            [
                'name' => 'Olahraga',
                'description' => 'Peralatan olahraga'
            ],
            [
                'name' => 'Lainnya',
                'description' => 'Kategori lainnya'
            ]
        ]);
    }
}
