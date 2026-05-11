<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Kategori: Diabetes (Fokus: Low Sugar, High Fiber, Low GI)
        Recipe::create([
            'name' => 'Salad Quinoa & Tempe Kukus',
            'description' => 'Karbohidrat kompleks yang aman untuk menjaga stabilitas gula darah.',
            'image_url' => 'recipes/quinoa_salad.jpg',
            'calories' => 280,
            'protein_g' => 15.0,
            'fat_g' => 9.0,
            'carbs_g' => 35.0,
            'sugar_g' => 2.0, // Sangat rendah gula
            'fiber_g' => 10.0, // Tinggi serat
            'glycemic_index' => 'Low',
            'category' => 'Diabetes',
            'budget_estimate' => 25000,
            'prep_time_minutes' => 15,
            'ingredients' => "100g Quinoa matang\n50g Tempe kukus potong dadu\nSayuran hijau (selada/bayam)\n1 sdt Minyak zaitun",
            'cooking_steps' => "1. Campurkan quinoa dan tempe ke dalam wadah.\n2. Tambahkan sayuran segar.\n3. Siram dengan minyak zaitun dan sedikit perasan lemon.\n4. Sajikan dingin atau hangat."
        ]);

        // 2. Kategori: Fitness (Fokus: High Protein, Medium GI)
        Recipe::create([
            'name' => 'Dada Ayam Panggang Jahe (Gym-Bro Edition)',
            'description' => 'Menu wajib untuk pembangunan otot tanpa lemak jenuh berlebih.',
            'image_url' => 'recipes/chicken_gym.jpg',
            'calories' => 350,
            'protein_g' => 45.0, // Protein tinggi
            'fat_g' => 5.0,
            'carbs_g' => 10.0,
            'sugar_g' => 1.0,
            'fiber_g' => 2.0,
            'glycemic_index' => 'Low',
            'category' => 'Fitness',
            'budget_estimate' => 20000,
            'prep_time_minutes' => 20,
            'ingredients' => "200g Dada ayam fillet\n2 siung Bawang putih geprek\n1 ruas Jahe\nLada hitam secukupnya",
            'cooking_steps' => "1. Marinasi ayam dengan bawang putih, jahe, dan lada selama 10 menit.\n2. Panggang di teflon tanpa minyak hingga matang sempurna.\n3. Iris tipis agar mudah dikonsumsi."
        ]);

        // 3. Kategori: Heart-Healthy / Darah Tinggi (Fokus: Low Sodium/Salt, Healthy Fat)
        Recipe::create([
            'name' => 'Pepes Ikan Kembung Rempah',
            'description' => 'Kaya akan Omega-3 untuk kesehatan jantung tanpa tambahan garam berlebih.',
            'image_url' => 'recipes/pepes_ikan.jpg',
            'calories' => 220,
            'protein_g' => 24.0,
            'fat_g' => 12.0,
            'carbs_g' => 5.0,
            'sugar_g' => 0.5,
            'fiber_g' => 1.5,
            'glycemic_index' => 'Low',
            'category' => 'Heart-Healthy',
            'budget_estimate' => 15000,
            'prep_time_minutes' => 30,
            'ingredients' => "1 ekor Ikan kembung segar\nBumbu kuning (kunyit, lengkuas, kemiri)\nDaun kemangi\nDaun pisang untuk membungkus",
            'cooking_steps' => "1. Bersihkan ikan, lumuri dengan bumbu halus bumbu kuning.\n2. Tambahkan daun kemangi agar wangi.\n3. Bungkus dengan daun pisang.\n4. Kukus selama 20-25 menit hingga bumbu meresap."
        ]);
    }
}