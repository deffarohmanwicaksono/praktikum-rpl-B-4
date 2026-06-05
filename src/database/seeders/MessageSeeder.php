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
            // CHAT 1
            [
                'chat_id' => 1,
                'sender_id' => 2,
                'message' => 'Halo kak, headsetnya masih tersedia?'
            ],
            [
                'chat_id' => 1,
                'sender_id' => 4,
                'message' => 'Masih tersedia.'
            ],

            // CHAT 2
            [
                'chat_id' => 2,
                'sender_id' => 3,
                'message' => 'Laptopnya masih ada?'
            ],

            // CHAT 3
            [
                'chat_id' => 3,
                'sender_id' => 9,
                'message' => 'Halo kak, headset gamingnya masih ready?'
            ],
            [
                'chat_id' => 3,
                'sender_id' => 4,
                'message' => 'Masih ready ya.'
            ],

            // CHAT 4
            [
                'chat_id' => 4,
                'sender_id' => 2,
                'message' => 'Buku kalkulusnya masih tersedia?'
            ],
            [
                'chat_id' => 4,
                'sender_id' => 5,
                'message' => 'Masih tersedia.'
            ],

            // CHAT 5
            [
                'chat_id' => 5,
                'sender_id' => 12,
                'message' => 'Kondisi bukunya masih bagus kak?'
            ],
            [
                'chat_id' => 5,
                'sender_id' => 5,
                'message' => 'Masih bagus, hanya ada sedikit stabilo.'
            ],

            // CHAT 6
            [
                'chat_id' => 6,
                'sender_id' => 20,
                'message' => 'Boleh nego untuk buku kalkulusnya?'
            ],
            [
                'chat_id' => 6,
                'sender_id' => 5,
                'message' => 'Boleh, silakan ditawar.'
            ],

            // CHAT 7
            [
                'chat_id' => 7,
                'sender_id' => 2,
                'message' => 'Almamater UNS ukuran apa ya?'
            ],
            [
                'chat_id' => 7,
                'sender_id' => 21,
                'message' => 'Ukuran L.'
            ],

            // CHAT 8
            [
                'chat_id' => 8,
                'sender_id' => 13,
                'message' => 'Hair dryer masih berfungsi normal?'
            ],
            [
                'chat_id' => 8,
                'sender_id' => 21,
                'message' => 'Masih normal dan jarang dipakai.'
            ],

            // CHAT 9
            [
                'chat_id' => 9,
                'sender_id' => 3,
                'message' => 'Samsung A12 masih tersedia?'
            ],
            [
                'chat_id' => 9,
                'sender_id' => 22,
                'message' => 'Masih tersedia.'
            ],

            // CHAT 10
            [
                'chat_id' => 10,
                'sender_id' => 2,
                'message' => 'Hoodienya ukuran berapa?'
            ],
            [
                'chat_id' => 10,
                'sender_id' => 22,
                'message' => 'Ukuran XL.'
            ],

            // CHAT 11
            [
                'chat_id' => 11,
                'sender_id' => 3,
                'message' => 'Lampu belajar masih bisa diatur tingkat cahayanya?'
            ],
            [
                'chat_id' => 11,
                'sender_id' => 23,
                'message' => 'Bisa, semua mode masih berfungsi.'
            ],

            // CHAT 12
            [
                'chat_id' => 12,
                'sender_id' => 14,
                'message' => 'Sepatunya masih nyaman dipakai?'
            ],
            [
                'chat_id' => 12,
                'sender_id' => 24,
                'message' => 'Masih nyaman dan solnya masih bagus.'
            ],

            // CHAT 13
            [
                'chat_id' => 13,
                'sender_id' => 2,
                'message' => 'Buku struktur datanya edisi berapa?'
            ],
            [
                'chat_id' => 13,
                'sender_id' => 25,
                'message' => 'Edisi terbaru untuk pembelajaran Java.'
            ],

            // CHAT 14
            [
                'chat_id' => 14,
                'sender_id' => 4,
                'message' => 'Raket Yonex masih tersedia?'
            ],
            [
                'chat_id' => 14,
                'sender_id' => 26,
                'message' => 'Masih tersedia.'
            ],

            // CHAT 15
            [
                'chat_id' => 15,
                'sender_id' => 13,
                'message' => 'Kalkulator Casio masih ada kak?'
            ],
            [
                'chat_id' => 15,
                'sender_id' => 26,
                'message' => 'Maaf, sudah terjual.'
            ],

            // CHAT 16
            [
                'chat_id' => 16,
                'sender_id' => 15,
                'message' => 'Dumbbell masih lengkap sepasang?'
            ],
            [
                'chat_id' => 16,
                'sender_id' => 27,
                'message' => 'Iya, lengkap sepasang.'
            ],

            // CHAT 17
            [
                'chat_id' => 17,
                'sender_id' => 5,
                'message' => 'Kipas anginnya masih normal semua?'
            ],
            [
                'chat_id' => 17,
                'sender_id' => 28,
                'message' => 'Masih normal dan bersih.'
            ],

            // CHAT 18
            [
                'chat_id' => 18,
                'sender_id' => 2,
                'message' => 'Board game Monopoly masih lengkap?'
            ],
            [
                'chat_id' => 18,
                'sender_id' => 29,
                'message' => 'Lengkap, semua kartu dan pion masih ada.'
            ],

            // CHAT 19
            [
                'chat_id' => 19,
                'sender_id' => 16,
                'message' => 'Rice cooker masih berfungsi dengan baik?'
            ],
            [
                'chat_id' => 19,
                'sender_id' => 29,
                'message' => 'Masih berfungsi normal.'
            ],

            // CHAT 20
            [
                'chat_id' => 20,
                'sender_id' => 3,
                'message' => 'Gitar akustiknya masih tersedia?'
            ],
            [
                'chat_id' => 20,
                'sender_id' => 31,
                'message' => 'Masih tersedia dan senarnya baru diganti.'
            ],
        ]);
    }
}
