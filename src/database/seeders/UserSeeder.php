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
    }
}
