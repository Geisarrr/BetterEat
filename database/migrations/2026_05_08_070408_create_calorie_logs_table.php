<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calorie_logs', function (Blueprint $table) {
            $table->id('log_id');
            $table->foreignId('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreignId('food_id')->references('food_id')->on('food_id')->on('food_nutrition_tkpi')->onDelete('cascade');
            
            // Kolom input berat makanan
            $table->decimal('quantity_gram', 8, 2);

            // --- KOLOM BARU UNTUK MENAMPUNG HASIL HITUNGAN ---
            $table->decimal('calories', 10, 2)->default(0);
            $table->decimal('protein_g', 10, 2)->default(0);
            $table->decimal('fat_g', 10, 2)->default(0);
            $table->decimal('carbs_g', 10, 2)->default(0);
            // ------------------------------------------------

            $table->timestamp('logged_at')->useCurrent();
            $table->timestamps(); // Menambahkan created_at & updated_at standar Laravel
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calorie_logs');
    }
};