<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\Chat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Message::class;

    public function definition(): array
    {
        return [
            //
            'message' => fake()->randomElement([
                'Apa barangnya masih ada?',
                'Permisi kak, mau tanya tentang barangnya.',
                'Masih tersedia?',
                'Boleh nego sedikit?',
                'Kalau COD bisa?',
                'Boleh minta foto asli barangnya?',
                'Barangnya ada minus ga, kak?',
            ]),
        ];
    }
}
