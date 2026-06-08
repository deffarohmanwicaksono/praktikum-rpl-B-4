<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $joinedAt = fake()->dateTimeBetween(
            '-24 months',
            '-18 months'
        );

        $username = Str::lower(
        Str::slug(
            fake()->unique()->firstName() .
            fake()->lastName(),
            ''
        )
    );

        return [
            'name' => fake()->name(),
            'email' => $username . '@student.uns.ac.id',
            'email_verified_at' => $joinedAt,
            'phone_number' => '08' . fake()->numerify('##########'),
            'roles' => fake()->randomElement([
                ['buyer'],
                ['buyer'],
                ['buyer'],
                ['buyer', 'seller'],
            ]),
            'password' => Hash::make('password123'),
            'remember_token' => Str::random(10),
            'created_at' => $joinedAt,
            'updated_at' => $joinedAt,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function seller(): static
    {
        return $this->state(fn () => [
            'roles' => ['buyer', 'seller'],
        ]);
    }

    public function buyer(): static
    {
        return $this->state(fn () => [
            'roles' => ['buyer'],
        ]);
    }
}
