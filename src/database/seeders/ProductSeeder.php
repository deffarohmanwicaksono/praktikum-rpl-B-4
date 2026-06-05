<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'user_id' => 4,
            'category_id' => 1,
            'name' => 'Headset Gaming RGB',
            'description' => 'Headset gaming dengan pencahayaan RGB yang menarik, memberikan pengalaman audio yang imersif saat bermain game.',
            'price' => 250000,
            'status' => 'dijual'
        ]);
        Product::create([
            'user_id' => 4,
            'category_id' => 1,
            'name' => 'Laptop Lenovo Thinkpad Bekas',
            'description' => 'Laptop bekas yang masih normal digunakan untuk kebutuhan kuliah, mengetik laporan, browsing, dan pemrograman ringan. Baterai masih awet dan seluruh port berfungsi dengan baik.',
            'price' => 3500000,
            'status' => 'dijual'
        ]);
        Product::create([
            'user_id' => 5,
            'category_id' => 2,
            'name' => 'Buku Kalkulus Stewart',
            'description' => 'Buku kalkulus edisi terbaru dengan kondisi sekitar 90%. Halaman lengkap, tidak ada yang hilang, hanya terdapat sedikit coretan stabilo pada beberapa bagian.',
            'price' => 80000,
            'status' => 'dijual'
        ]);
        Product::create([
            'user_id' => 21,
            'category_id' => 3,
            'name' => 'Meja Belajar Lipat',
            'description' => 'Meja belajar lipat yang praktis untuk anak kos. Konstruksi masih kokoh dan nyaman digunakan untuk belajar, mengerjakan tugas, maupun menggunakan laptop.',
            'price' => 150000,
            'status' => 'menunggu_verifikasi'
        ]);
        Product::create([
            'user_id' => 22,
            'category_id' => 1,
            'name' => 'Smartphone Samsung A12',
            'description' => 'Smartphone bekas dengan kondisi fisik sekitar 85%. Kamera, layar, dan baterai masih berfungsi normal untuk penggunaan sehari-hari.',
            'price' => 1200000,
            'status' => 'dijual'
        ]);

        Product::create([
            'user_id' => 23,
            'category_id' => 1,
            'name' => 'Printer Canon IP2770',
            'description' => 'Printer masih dapat digunakan untuk mencetak dokumen kuliah. Cocok untuk mahasiswa yang sering mencetak laporan dan tugas.',
            'price' => 450000,
            'status' => 'menunggu_verifikasi'
        ]);

        Product::create([
            'user_id' => 24,
            'category_id' => 1,
            'name' => 'Tablet Samsung Tab A',
            'description' => 'Tablet bekas yang nyaman digunakan untuk membaca e-book, mencatat materi kuliah, dan menonton video pembelajaran.',
            'price' => 1800000,
            'status' => 'ditolak'
        ]);

        Product::create([
            'user_id' => 25,
            'category_id' => 2,
            'name' => 'Buku Struktur Data Java',
            'description' => 'Buku referensi struktur data menggunakan bahasa Java. Sangat cocok untuk mahasiswa informatika yang sedang mempelajari algoritma dan pemrograman.',
            'price' => 95000,
            'status' => 'dijual'
        ]);

        Product::create([
            'user_id' => 26,
            'category_id' => 2,
            'name' => 'Kalkulator Casio FX-991EX',
            'description' => 'Kalkulator scientific yang umum digunakan pada mata kuliah matematika, fisika, dan teknik. Kondisi masih sangat baik.',
            'price' => 250000,
            'status' => 'sold_out'
        ]);

        Product::create([
            'user_id' => 27,
            'category_id' => 2,
            'name' => 'Paket Alat Tulis Kuliah',
            'description' => 'Paket berisi binder, pulpen, pensil mekanik, dan stabilo yang masih layak digunakan untuk kebutuhan kuliah sehari-hari.',
            'price' => 50000,
            'status' => 'dijual'
        ]);

        Product::create([
            'user_id' => 28,
            'category_id' => 3,
            'name' => 'Kipas Angin Miyako',
            'description' => 'Kipas angin ukuran sedang yang masih berfungsi normal. Cocok digunakan untuk kamar kos saat cuaca panas.',
            'price' => 175000,
            'status' => 'dijual'
        ]);

        Product::create([
            'user_id' => 29,
            'category_id' => 3,
            'name' => 'Rice Cooker Cosmos',
            'description' => 'Rice cooker kapasitas kecil yang cocok untuk mahasiswa kos. Fungsi memasak dan menghangatkan nasi masih berjalan baik.',
            'price' => 220000,
            'status' => 'dijual'
        ]);

        Product::create([
            'user_id' => 30,
            'category_id' => 3,
            'name' => 'Rak Plastik 4 Susun',
            'description' => 'Rak penyimpanan serbaguna untuk menyimpan buku, pakaian, atau perlengkapan kos. Kondisi masih kokoh.',
            'price' => 120000,
            'status' => 'sold_out'
        ]);

        Product::create([
            'user_id' => 31,
            'category_id' => 3,
            'name' => 'Setrika Philips',
            'description' => 'Setrika listrik yang masih dapat digunakan dengan baik. Cocok untuk kebutuhan mahasiswa yang tinggal di kos.',
            'price' => 100000,
            'status' => 'ditolak'
        ]);

        Product::create([
            'user_id' => 21,
            'category_id' => 4,
            'name' => 'Almamater UNS',
            'description' => 'Almamater ukuran L dengan kondisi masih sangat baik. Cocok digunakan untuk kegiatan kampus maupun sehari-hari.',
            'price' => 120000,
            'status' => 'dijual'
        ]);

        Product::create([
            'user_id' => 22,
            'category_id' => 4,
            'name' => 'Hoodie Hitam Polos',
            'description' => 'Hoodie berbahan nyaman dan hangat untuk digunakan saat kuliah maupun bepergian.',
            'price' => 80000,
            'status' => 'dijual'
        ]);

        Product::create([
            'user_id' => 23,
            'category_id' => 4,
            'name' => 'Tas Ransel Eiger',
            'description' => 'Tas ransel dengan kapasitas besar yang dapat digunakan untuk membawa laptop dan perlengkapan kuliah.',
            'price' => 250000,
            'status' => 'sold_out'
        ]);

        Product::create([
            'user_id' => 24,
            'category_id' => 4,
            'name' => 'Sepatu Converse Bekas',
            'description' => 'Sepatu ukuran 42 dengan kondisi masih nyaman digunakan. Sol dan jahitan masih kuat.',
            'price' => 300000,
            'status' => 'dijual'
        ]);

        Product::create([
            'user_id' => 25,
            'category_id' => 4,
            'name' => 'Topi UNS',
            'description' => 'Topi dengan logo UNS yang masih dalam kondisi baik dan layak digunakan untuk aktivitas sehari-hari.',
            'price' => 50000,
            'status' => 'menunggu_verifikasi'
        ]);

        Product::create([
            'user_id' => 26,
            'category_id' => 5,
            'name' => 'Raket Badminton Yonex',
            'description' => 'Raket badminton original dengan kondisi sangat baik. Cocok untuk latihan maupun pertandingan.',
            'price' => 350000,
            'status' => 'dijual'
        ]);

        Product::create([
            'user_id' => 27,
            'category_id' => 5,
            'name' => 'Dumbbell 5 Kg',
            'description' => 'Sepasang dumbbell yang cocok digunakan untuk olahraga ringan dan menjaga kebugaran di kos.',
            'price' => 180000,
            'status' => 'dijual'
        ]);

        Product::create([
            'user_id' => 28,
            'category_id' => 5,
            'name' => 'Bola Futsal Specs',
            'description' => 'Bola futsal dengan kondisi masih baik dan tekanan udara stabil untuk digunakan bermain rutin.',
            'price' => 120000,
            'status' => 'sold_out'
        ]);

        Product::create([
            'user_id' => 29,
            'category_id' => 6,
            'name' => 'Board Game Monopoly',
            'description' => 'Board game lengkap dengan seluruh komponen. Cocok dimainkan bersama teman-teman di kos.',
            'price' => 180000,
            'status' => 'dijual'
        ]);

        Product::create([
            'user_id' => 30,
            'category_id' => 6,
            'name' => 'Action Figure Naruto',
            'description' => 'Action figure karakter Naruto dengan detail yang masih bagus dan layak dikoleksi.',
            'price' => 220000,
            'status' => 'menunggu_verifikasi'
        ]);

        Product::create([
            'user_id' => 31,
            'category_id' => 6,
            'name' => 'Gitar Akustik Yamaha',
            'description' => 'Gitar akustik yang masih nyaman dimainkan dan cocok untuk pemula maupun hobi bermusik.',
            'price' => 650000,
            'status' => 'dijual'
        ]);

        Product::create([
            'user_id' => 21,
            'category_id' => 7,
            'name' => 'Hair Dryer Philips',
            'description' => 'Hair dryer yang masih berfungsi dengan baik dan aman digunakan untuk kebutuhan sehari-hari.',
            'price' => 130000,
            'status' => 'dijual'
        ]);

        Product::create([
            'user_id' => 22,
            'category_id' => 7,
            'name' => 'Catokan Rambut Nova',
            'description' => 'Catokan rambut portable dengan kondisi baik dan suhu pemanasan masih normal.',
            'price' => 85000,
            'status' => 'sold_out'
        ]);

        Product::create([
            'user_id' => 23,
            'category_id' => 8,
            'name' => 'Lampu Belajar LED',
            'description' => 'Lampu belajar dengan tingkat kecerahan yang dapat diatur. Sangat cocok untuk belajar pada malam hari.',
            'price' => 65000,
            'status' => 'dijual'
        ]);
        Product::create([
            'user_id' => 26,
            'category_id' => 1,
            'name' => 'Mouse Wireless Logitech',
            'description' => 'Mouse wireless yang nyaman digunakan untuk mengerjakan tugas dan belajar dalam waktu lama. Kondisi masih sangat baik.',
            'price' => 50000,
            'status' => 'menunggu_verifikasi'
        ]);
        Product::create([
            'user_id' => 25,
            'category_id' => 3,
            'name' => 'Kursi Belajar Ergonomis',
            'description' => 'Kursi belajar yang nyaman digunakan untuk mengerjakan tugas dan belajar dalam waktu lama. Kondisi masih sangat baik.',
            'price' => 275000,
            'status' => 'menunggu_verifikasi'
        ]);
    }
}
