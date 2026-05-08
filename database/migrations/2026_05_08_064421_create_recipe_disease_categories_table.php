<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipe_disease_categories', function (Blueprint $table) {
            $table->foreignId('recipe_id')->references('recipe_id')->on('recipes')->onDelete('cascade');
            $table->foreignId('category_id')->references('category_id')->on('disease_categories')->onDelete('cascade');
            
            $table->primary(['recipe_id', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipe_disease_categories');
    }
};