<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_likes', function (Blueprint $table) {
            $table->foreignId('post_id')->references('post_id')->on('posts')->onDelete('cascade');
            $table->foreignId('user_id')->references('user_id')->on('users')->onDelete('cascade');
            
            // Mencegah user menyukai post yang sama lebih dari 1 kali
            $table->primary(['post_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_likes');
    }
};