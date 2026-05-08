<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipe_ingredients', function (Blueprint $table) {
            $table->id('ingredient_id');
            $table->foreignId('recipe_id')->references('recipe_id')->on('recipes')->onDelete('cascade');
            $table->foreignId('food_id')->references('food_id')->on('food_nutrition_tkpi')->onDelete('cascade');
            $table->decimal('quantity_gram', 8, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipe_ingredients');
    }
};