<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Membuat User testing (Penting buat ngetes Login API nanti)
        User::factory()->create([
            'full_name' => 'Test User',
            'username'  => 'testuser',
            'email'     => 'test@example.com',
            'role'      => 'user',
        ]);
        
        // 2. Memanggil Seeder lainnya
        $this->call([
            TkpiSeeder::class,   // Data gizi dasar (100 data)
            RecipeSeeder::class, // Resep Diabetes, Fitness, & Jantung (Data rekomendasi)
        ]);
    }
}