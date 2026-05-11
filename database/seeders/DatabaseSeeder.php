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
        // Membuat User testing pertama untuk login/trial di Thunder Client
        User::factory()->create([
            'full_name' => 'Test User',
            'username'  => 'testuser',
            'email'     => 'test@example.com',
            'role'      => 'user', // Memastikan sesuai dengan enum ['user', 'admin']
        ]);
        
        // Memanggil Seeder TKPI untuk mengisi 100 data gizi makanan
        $this->call([
            TkpiSeeder::class,
        ]);
    }
}