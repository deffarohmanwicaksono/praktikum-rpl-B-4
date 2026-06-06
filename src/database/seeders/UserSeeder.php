<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Admin
        User::factory()->create([
            'name' => 'Admin SeMart',
            'email' => 'admin@student.uns.ac.id',
            'role' => 'admin',
            'phone_number' => '081987654321',
            'password' => Hash::make('password_admin'),
            'created_at' => '2020-01-01 08:00:00',
        ]);

        // User
        User::factory()->create([
            'name' => 'Nurul Janati',
            'email' => 'nurul@student.uns.ac.id',
            'role' => 'buyer',
            'phone_number' => '081987654322',
            'password' => Hash::make('password123'),
            'created_at' => '2025-01-05 09:15:00',
        ]);

        User::factory()->create([
            'name' => 'Syifa Qurrota',
            'email' => 'syifa@student.uns.ac.id',
            'role' => 'buyer',
            'phone_number' => '081987654324',
            'password' => Hash::make('password123'),
            'created_at' => '2025-01-08 10:20:00',
        ]);

        User::factory()->create([
            'name' => 'Deffa Rohman',
            'email' => 'deffa@student.uns.ac.id',
            'role' => 'seller',
            'phone_number' => '081987654325',
            'password' => Hash::make('password123'),
            'created_at' => '2025-01-12 13:10:00',
        ]);

        User::factory()->create([
            'name' => 'Kemal Amangylyjow',
            'email' => 'kemal@student.uns.ac.id',
            'role' => 'seller',
            'phone_number' => '081987654326',
            'password' => Hash::make('password123'),
            'created_at' => '2025-01-15 15:30:00',
        ]);

        // Admin
        User::factory()->create([
            'name' => 'Admin1',
            'email' => 'admin1@student.uns.ac.id',
            'role' => 'admin',
            'phone_number' => '081987654327',
            'password' => Hash::make('password_admin'),
            'created_at' => '2020-01-15 15:30:00',
        ]);

        User::factory()->create([
            'name' => 'Admin2',
            'email' => 'admin2@student.uns.ac.id',
            'role' => 'admin',
            'phone_number' => '081987654328',
            'password' => Hash::make('password_admin'),
            'created_at' => '2020-01-15 15:00:00',
        ]);

        User::factory()->create([
            'name' => 'Admin3',
            'email' => 'admin3@student.uns.ac.id',
            'role' => 'admin',
            'phone_number' => '081987654329',
            'password' => Hash::make('password_admin'),
            'created_at' => '2020-01-27 15:00:00',
        ]);

        // User
        User::factory()->create([
            'name' => 'Aulia Pratama',
            'email' => 'auliapratama@uns.ac.id',
            'role' => 'buyer',
            'phone_number' => '081987654330',
            'password' => Hash::make('password123'),
            'created_at' => '2026-02-27 15:00:00',
        ]);

        User::factory()->create([
            'name' => 'Rizky Saputra',
            'email' => 'rizkysaputra@uns.ac.id',
            'role' => 'buyer',
            'phone_number' => '081987654331',
            'password' => Hash::make('password123'),
            'created_at' => '2025-02-27 15:00:00',
        ]);

        User::factory()->create([
            'name' => 'Dinda Maharani',
            'email' => 'dindamaharani@uns.ac.id',
            'role' => 'buyer',
            'phone_number' => '081987654332',
            'password' => Hash::make('password123'),
            'created_at' => '2025-02-27 12:00:00',
        ]);

        User::factory()->create([
            'name' => 'Fajar Nugroho',
            'email' => 'fajarnugroho@uns.ac.id',
            'role' => 'buyer',
            'phone_number' => '081987654333',
            'password' => Hash::make('password123'),
            'created_at' => '2025-02-27 12:00:00',
        ]);

        User::factory()->create([
            'name' => 'Putri Lestari',
            'email' => 'putrilestari@uns.ac.id',
            'role' => 'buyer',
            'phone_number' => '081987654334',
            'password' => Hash::make('password123'),
            'created_at' => '2025-02-27 12:30:00',
        ]);

        User::factory()->create([
            'name' => 'Galih Ramadhan',
            'email' => 'galihramadhan@uns.ac.id',
            'role' => 'buyer',
            'phone_number' => '081987654335',
            'password' => Hash::make('password123'),
            'created_at' => '2023-02-10 12:30:00',
        ]);

        User::factory()->create([
            'name' => 'Nabila Safitri',
            'email' => 'nabilasafitri@uns.ac.id',
            'role' => 'buyer',
            'phone_number' => '081987654336',
            'password' => Hash::make('password123'),
            'created_at' => '2025-08-27 14:00:00',
        ]);

        User::factory()->create([
            'name' => 'Yoga Prakoso',
            'email' => 'yogaprakoso@uns.ac.id',
            'role' => 'buyer',
            'phone_number' => '081987654337',
            'password' => Hash::make('password123'),
            'created_at' => '2025-08-17 14:00:00',
        ]);

        User::factory()->create([
            'name' => 'Tiara Oktaviani',
            'email' => 'tiaraoktaviani@uns.ac.id',
            'role' => 'buyer',
            'phone_number' => '081987654338',
            'password' => Hash::make('password123'),
            'created_at' => '2025-08-17 09:00:00',
        ]);

        User::factory()->create([
            'name' => 'Bagas Mahendra',
            'email' => 'bagasmahendra@uns.ac.id',
            'role' => 'buyer',
            'phone_number' => '081987654339',
            'password' => Hash::make('password123'),
            'created_at' => '2025-10-17 09:00:00',
        ]);

        User::factory()->create([
            'name' => 'Salsa Permata',
            'email' => 'salsapermata@uns.ac.id',
            'role' => 'buyer',
            'phone_number' => '081987654340',
            'password' => Hash::make('password123'),
            'created_at' => '2025-11-17 10:00:00',
        ]);

        User::factory()->create([
            'name' => 'Arif Setiawan',
            'email' => 'arifsetiawan@uns.ac.id',
            'role' => 'buyer',
            'phone_number' => '081987654341',
            'password' => Hash::make('password123'),
            'created_at' => '2025-11-09 10:00:00',
        ]);

        User::factory()->create([
            'name' => 'Intan Puspita',
            'email' => 'intanpuspita@uns.ac.id',
            'role' => 'seller',
            'phone_number' => '081987654342',
            'password' => Hash::make('password123'),
            'created_at' => '2025-12-09 10:00:00',
        ]);

        User::factory()->create([
            'name' => 'Reza Kurniawan',
            'email' => 'rezakurniawan@uns.ac.id',
            'role' => 'seller',
            'phone_number' => '081987654343',
            'password' => Hash::make('password123'),
            'created_at' => '2025-12-09 10:30:00',
        ]);

        User::factory()->create([
            'name' => 'Vina Amelia',
            'email' => 'vinaamelia@uns.ac.id',
            'role' => 'seller',
            'phone_number' => '081987654344',
            'password' => Hash::make('password123'),
            'created_at' => '2025-12-29 10:30:00',
        ]);

        User::factory()->create([
            'name' => 'Dimas Wicaksono',
            'email' => 'dimaswicaksono@uns.ac.id',
            'role' => 'seller',
            'phone_number' => '081987654345',
            'password' => Hash::make('password123'),
            'created_at' => '2025-12-21 10:30:00',
        ]);

        User::factory()->create([
            'name' => 'Siti Rahma',
            'email' => 'sitirahma@uns.ac.id',
            'role' => 'seller',
            'phone_number' => '081987654346',
            'password' => Hash::make('password123'),
            'created_at' => '2025-07-21 10:30:00',
        ]);

        User::factory()->create([
            'name' => 'Rafi Akbar',
            'email' => 'rafiakbar@uns.ac.id',
            'role' => 'seller',
            'phone_number' => '081987654347',
            'password' => Hash::make('password123'),
            'created_at' => '2025-07-21 10:30:00',
        ]);

        User::factory()->create([
            'name' => 'Nadia Putri',
            'email' => 'nadiaputri@uns.ac.id',
            'role' => 'seller',
            'phone_number' => '081987654348',
            'password' => Hash::make('password123'),
            'created_at' => '2025-07-21 10:30:00',
        ]);

        User::factory()->create([
            'name' => 'Andika Prabowo',
            'email' => 'andikaprabowo@uns.ac.id',
            'role' => 'seller',
            'phone_number' => '081987654349',
            'password' => Hash::make('password123'),
            'created_at' => '2025-07-21 10:30:00',
        ]);

        User::factory()->create([
            'name' => 'Maya Kusuma',
            'email' => 'mayakusuma@uns.ac.id',
            'role' => 'seller',
            'phone_number' => '081987654350',
            'password' => Hash::make('password123'),
            'created_at' => '2025-07-21 10:30:00',
        ]);

        User::factory()->create([
            'name' => 'Bintang Aditya',
            'email' => 'bintangaditya@uns.ac.id',
            'role' => 'seller',
            'phone_number' => '081987654351',
            'password' => Hash::make('password123'),
            'created_at' => '2023-02-10 12:30:00',
        ]);

        User::factory()->create([
            'name' => 'Citra Larasati',
            'email' => 'citralarasati@uns.ac.id',
            'role' => 'seller',
            'phone_number' => '081987654352',
            'password' => Hash::make('password123'),
            'created_at' => '2023-05-10 12:30:00',
        ]);
    }
}
