<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id('profile_id');
            // Menghubungkan user_id ke tabel users
            $table->foreignId('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->text('health_condition')->nullable();
            $table->integer('daily_calorie_target')->nullable();
            $table->integer('age')->nullable();
            $table->decimal('weight_kg', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};