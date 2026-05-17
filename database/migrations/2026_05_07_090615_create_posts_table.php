<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id('post_id');
            // Relasi ke User yang memposting
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            
            // Relasi ke Kategori (Diabetes, Hipertensi, Fitness, dll)
            // Saran: Nanti nama tabel 'disease_categories' bisa diganti jadi 'health_categories' agar lebih inklusif
            $table->foreignId('category_id')->constrained('disease_categories', 'category_id')->onDelete('cascade');
            
            $table->string('title');
            $table->text('content');
            
            $table->boolean('is_moderated')->default(false);
            
            // Menggunakan timestamps() standar Laravel (created_at & updated_at)
            $table->timestamps();

            if (!Schema::hasColumn('posts', 'image_url')) {
                $table->string('image_url')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'image_url')) {
                $table->dropColumn('image_url');
            }
        });
    }
};