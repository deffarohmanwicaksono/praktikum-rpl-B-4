<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Message::insert([
            [
                'chat_id' => 1,
                'sender_id' => 2,
                'message' => 'Halo kak, laptopnya masih tersedia?'
            ],
            [
                'chat_id' => 1,
                'sender_id' => 4,
                'message' => 'Masih tersedia.'
            ],
            [
                'chat_id' => 2,
                'sender_id' => 3,
                'message' => 'Buku kalkulus masih ada?'
            ]
        ]);
    }
}
