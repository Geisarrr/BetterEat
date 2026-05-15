<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'full_name' => 'Admin BetterEat',
            'username' => 'adminutama',
            'email' => 'admin@bettereat.com',
            'password_hash' => bcrypt('password123'), // Jangan lupa di-bcrypt
            'role' => 'admin',
        ]);
    }
}
