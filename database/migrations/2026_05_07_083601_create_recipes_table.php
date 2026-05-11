<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id('recipe_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            
            // --- KOLOM GIZI (Macro & Micro) ---
            $table->decimal('calories', 8, 2)->default(0);
            $table->decimal('protein_g', 8, 2)->default(0);
            $table->decimal('fat_g', 8, 2)->default(0);
            $table->decimal('carbs_g', 8, 2)->default(0);
            $table->decimal('sugar_g', 8, 2)->default(0); // Krusial untuk Diabetes
            $table->decimal('fiber_g', 8, 2)->default(0); // Bagus untuk pencernaan & gula darah
            
            // --- SISTEM TAGGING & KESEHATAN ---
            // 'Low', 'Medium', 'High' untuk panduan penderita diabetes
            $table->enum('glycemic_index', ['Low', 'Medium', 'High'])->default('Low'); 
            // Kategori utama: 'Diabetes', 'Hypertension', 'Fitness', 'General'
            $table->string('category')->default('General'); 

            // --- DETAIL MASAKAN & BUDGET ---
            $table->decimal('budget_estimate', 10, 2)->default(0);
            $table->integer('prep_time_minutes')->nullable();
            $table->text('ingredients'); 
            $table->text('cooking_steps'); 
            
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};