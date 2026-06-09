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
        $adminDate = '2020-01-01 08:00:00';
        
        // Admin
        User::create([
            'name' => 'Admin SeMart',
            'email' => 'admin@student.uns.ac.id',
            'roles' => ['admin'],
            'phone_number' => '081987654321',
            'password' => Hash::make('password_admin'),
            'created_at' => $adminDate,
            'updated_at' => $adminDate,
            'email_verified_at' => $adminDate,
        ]);

        // User
        User::factory()->create([
            'name' => 'Nurul Janati',
            'email' => 'nurul@student.uns.ac.id',
            'roles' => ['buyer', 'seller'],
            'phone_number' => '081987654322',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Syifa Qurrota',
            'email' => 'syifa@student.uns.ac.id',
            'roles' => ['buyer', 'seller'],
            'phone_number' => '081987654324',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Deffa Rohman',
            'email' => 'deffa@student.uns.ac.id',
            'roles' => ['buyer', 'seller'],
            'phone_number' => '081987654325',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Kemal Amangylyjow',
            'email' => 'kemal@student.uns.ac.id',
            'roles' => ['buyer', 'seller'],
            'phone_number' => '081987654326',
            'password' => Hash::make('password123'),
        ]);

        // Admin
        User::create([
            'name' => 'Admin1',
            'email' => 'admin1@student.uns.ac.id',
            'roles' => ['admin'],
            'phone_number' => '081987654327',
            'password' => Hash::make('password_admin'),
            'created_at' => $adminDate,
            'updated_at' => $adminDate,
            'email_verified_at' => $adminDate,
        ]);

        User::create([
            'name' => 'Admin2',
            'email' => 'admin2@student.uns.ac.id',
            'roles' => ['admin'],
            'phone_number' => '081987654328',
            'password' => Hash::make('password_admin'),
            'created_at' => $adminDate,
            'updated_at' => $adminDate,
            'email_verified_at' => $adminDate,
        ]);

        User::create([
            'name' => 'Admin3',
            'email' => 'admin3@student.uns.ac.id',
            'roles' => ['admin'],
            'phone_number' => '081987654329',
            'password' => Hash::make('password_admin'),
            'created_at' => $adminDate,
            'updated_at' => $adminDate,
            'email_verified_at' => $adminDate,
        ]);

        // User
        User::factory()->create([
            'name' => 'Aulia Pratama',
            'email' => 'auliapratama@student.uns.ac.id',
            'roles' => ['buyer'],
            'phone_number' => '081987654330',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Rizky Saputra',
            'email' => 'rizkysaputra@student.uns.ac.id',
            'roles' => ['buyer'],
            'phone_number' => '081987654331',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Dinda Maharani',
            'email' => 'dindamaharani@student.uns.ac.id',
            'roles' => ['buyer'],
            'phone_number' => '081987654332',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Fajar Nugroho',
            'email' => 'fajarnugroho@student.uns.ac.id',
            'roles' => ['buyer'],
            'phone_number' => '081987654333',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Putri Lestari',
            'email' => 'putrilestari@student.uns.ac.id',
            'roles' => ['buyer'],
            'phone_number' => '081987654334',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Galih Ramadhan',
            'email' => 'galihramadhan@student.uns.ac.id',
            'roles' => ['buyer'],
            'phone_number' => '081987654335',
            'password' => Hash::make('password123'),
            'created_at' => '2023-02-10 12:30:00',
        ]);

        User::factory()->create([
            'name' => 'Nabila Safitri',
            'email' => 'nabilasafitri@student.uns.ac.id',
            'roles' => ['buyer'],
            'phone_number' => '081987654336',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Yoga Prakoso',
            'email' => 'yogaprakoso@student.uns.ac.id',
            'roles' => ['buyer'],
            'phone_number' => '081987654337',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Tiara Oktaviani',
            'email' => 'tiaraoktaviani@student.uns.ac.id',
            'roles' => ['buyer'],
            'phone_number' => '081987654338',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Bagas Mahendra',
            'email' => 'bagasmahendra@student.uns.ac.id',
            'roles' => ['buyer'],
            'phone_number' => '081987654339',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Salsa Permata',
            'email' => 'salsapermata@student.uns.ac.id',
            'roles' => ['buyer'],
            'phone_number' => '081987654340',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Arif Setiawan',
            'email' => 'arifsetiawan@student.uns.ac.id',
            'roles' => ['buyer'],
            'phone_number' => '081987654341',
            'password' => Hash::make('password123'),
            'created_at' => '2025-11-09 10:00:00',
        ]);

        User::factory()->create([
            'name' => 'Intan Puspita',
            'email' => 'intanpuspita@student.uns.ac.id',
            'roles' => ['buyer', 'seller'],
            'phone_number' => '081987654342',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Reza Kurniawan',
            'email' => 'rezakurniawan@student.uns.ac.id',
            'roles' => ['buyer', 'seller'],
            'phone_number' => '081987654343',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Vina Amelia',
            'email' => 'vinaamelia@student.uns.ac.id',
            'roles' => ['buyer', 'seller'],
            'phone_number' => '081987654344',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Dimas Wicaksono',
            'email' => 'dimaswicaksono@student.uns.ac.id',
            'roles' => ['buyer', 'seller'],
            'phone_number' => '081987654345',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Siti Rahma',
            'email' => 'sitirahma@student.uns.ac.id',
            'roles' => ['buyer', 'seller'],
            'phone_number' => '081987654346',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Rafi Akbar',
            'email' => 'rafiakbar@student.uns.ac.id',
            'roles' => ['buyer', 'seller'],
            'phone_number' => '081987654347',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Nadia Putri',
            'email' => 'nadiaputri@student.uns.ac.id',
            'roles' => ['buyer', 'seller'],
            'phone_number' => '081987654348',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Andika Prabowo',
            'email' => 'andikaprabowo@student.uns.ac.id',
            'roles' => ['buyer', 'seller'],
            'phone_number' => '081987654349',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Maya Kusuma',
            'email' => 'mayakusuma@student.uns.ac.id',
            'roles' => ['buyer', 'seller'],
            'phone_number' => '081987654350',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Bintang Aditya',
            'email' => 'bintangaditya@student.uns.ac.id',
            'roles' => ['buyer', 'seller'],
            'phone_number' => '081987654351',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Citra Larasati',
            'email' => 'citralarasati@student.uns.ac.id',
            'roles' => ['buyer', 'seller'],
            'phone_number' => '081987654352',
            'password' => Hash::make('password123'),
        ]);

        // Factory
        // User::factory()->buyer()->count(30)->create();
        // User::factory()->seller()->count(10)->create();
    }
}
