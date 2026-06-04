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
            'password' => Hash::make('password_admin'),
        ]);

        // User
        User::factory()->create([
            'name' => 'Nurul Janati',
            'email' => 'nurul@student.uns.ac.id',
            'role' => 'buyer',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Syifa Qurrota',
            'email' => 'syifa@student.uns.ac.id',
            'role' => 'buyer',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Deffa Rohman',
            'email' => 'deffa@student.uns.ac.id',
            'role' => 'seller',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Kemal Amangylyjow',
            'email' => 'kemal@student.uns.ac.id',
            'role' => 'seller',
            'password' => Hash::make('password123'),
        ]);

        // Admin
        User::factory()->create([
            'name' => 'Admin1',
            'email' => 'admin1@student.uns.ac.id',
            'role' => 'admin',
            'password' => Hash::make('password_admin'),
        ]);

        User::factory()->create([
            'name' => 'Admin2',
            'email' => 'admin2@student.uns.ac.id',
            'role' => 'admin',
            'password' => Hash::make('password_admin'),
        ]);

        User::factory()->create([
            'name' => 'Admin3',
            'email' => 'admin3@student.uns.ac.id',
            'role' => 'admin',
            'password' => Hash::make('password_admin'),
        ]);

        // User
        User::factory()->create([
            'name' => 'Aulia Pratama',
            'email' => 'auliapratama@uns.ac.id',
            'role' => 'buyer',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Rizky Saputra',
            'email' => 'rizkysaputra@uns.ac.id',
            'role' => 'buyer',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Dinda Maharani',
            'email' => 'dindamaharani@uns.ac.id',
            'role' => 'buyer',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Fajar Nugroho',
            'email' => 'fajarnugroho@uns.ac.id',
            'role' => 'buyer',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Putri Lestari',
            'email' => 'putrilestari@uns.ac.id',
            'role' => 'buyer',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Galih Ramadhan',
            'email' => 'galihramadhan@uns.ac.id',
            'role' => 'buyer',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Nabila Safitri',
            'email' => 'nabilasafitri@uns.ac.id',
            'role' => 'buyer',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Yoga Prakoso',
            'email' => 'yogaprakoso@uns.ac.id',
            'role' => 'buyer',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Tiara Oktaviani',
            'email' => 'tiaraoktaviani@uns.ac.id',
            'role' => 'buyer',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Bagas Mahendra',
            'email' => 'bagasmahendra@uns.ac.id',
            'role' => 'buyer',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Salsa Permata',
            'email' => 'salsapermata@uns.ac.id',
            'role' => 'buyer',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Arif Setiawan',
            'email' => 'arifsetiawan@uns.ac.id',
            'role' => 'buyer',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Intan Puspita',
            'email' => 'intanpuspita@uns.ac.id',
            'role' => 'seller',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Reza Kurniawan',
            'email' => 'rezakurniawan@uns.ac.id',
            'role' => 'seller',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Vina Amelia',
            'email' => 'vinaamelia@uns.ac.id',
            'role' => 'seller',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Dimas Wicaksono',
            'email' => 'dimaswicaksono@uns.ac.id',
            'role' => 'seller',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Siti Rahma',
            'email' => 'sitirahma@uns.ac.id',
            'role' => 'seller',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Rafi Akbar',
            'email' => 'rafiakbar@uns.ac.id',
            'role' => 'seller',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Nadia Putri',
            'email' => 'nadiaputri@uns.ac.id',
            'role' => 'seller',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Andika Prabowo',
            'email' => 'andikaprabowo@uns.ac.id',
            'role' => 'seller',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Maya Kusuma',
            'email' => 'mayakusuma@uns.ac.id',
            'role' => 'seller',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Bintang Aditya',
            'email' => 'bintangaditya@uns.ac.id',
            'role' => 'seller',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Citra Larasati',
            'email' => 'citralarasati@uns.ac.id',
            'role' => 'seller',
            'password' => Hash::make('password123'),
        ]);
    }
}
