<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TkpiSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Mengarahkan ke file tkpi_cleaned.json yang ada di folder database/data/
        $jsonPath = database_path('data/tkpi_cleaned.json');

        // 2. Mengecek apakah file JSON-nya tersedia
        if (!File::exists($jsonPath)) {
            $this->command->error("Gagal: File JSON tidak ditemukan di {$jsonPath}");
            return;
        }

        // 3. Membaca dan menerjemahkan isi file JSON
        $json = File::get($jsonPath);
        $foods = json_decode($json, true);

        // 4. Memasukkan data secara berulang ke dalam tabel database
        foreach ($foods as $food) {
            DB::table('food_nutrition_tkpi')->insert([
                'food_name'         => $food['food_name'],
                'calories_per_100g' => $food['calories_per_100g'],
                'protein_g'         => $food['protein_g'],
                'fat_g'             => $food['fat_g'],
                'carbs_g'           => $food['carbs_g'],
                'fiber_g'           => $food['fiber_g'],
            ]);
        }

        // 5. Menampilkan pesan sukses di terminal
        $this->command->info("Mantap! 100 Data TKPI berhasil masuk ke database!");
    }
}