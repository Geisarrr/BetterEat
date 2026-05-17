<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('food_nutrition_tkpi', function (Blueprint $table) {
            $table->id('food_id');

            $table->string('food_name');

            $table->decimal('calories_per_100g', 8, 2);

            $table->decimal('protein_g', 8, 2);

            $table->decimal('fat_g', 8, 2);

            $table->decimal('carbs_g', 8, 2);

            $table->decimal('sugar_g', 8, 2)->default(0);

            $table->decimal('fiber_g', 8, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('food_nutrition_tkpi');
    }
};