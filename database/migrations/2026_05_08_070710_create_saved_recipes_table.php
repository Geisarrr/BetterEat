<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saved_recipes', function (Blueprint $table) {
            $table->id('saved_id');
            $table->foreignId('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreignId('recipe_id')->references('recipe_id')->on('recipes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_recipes');
    }
};