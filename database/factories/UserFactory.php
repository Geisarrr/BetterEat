<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Password yang digunakan oleh factory.
     */
    protected static ?string $password;

    /**
     * Definisikan data palsu untuk model User.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name'     => fake()->name(),
            'username'      => fake()->unique()->userName(), 
            'email'         => fake()->unique()->safeEmail(),
            'password_hash' => static::$password ??= Hash::make('password123'),
            'role'          => 'user', // Disamakan dengan enum di migration (huruf kecil)
            'profile_photo' => null,   // Sesuai skema kamu yang nullable
        ];
    }
}