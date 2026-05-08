<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('disease_categories', function (Blueprint $table) {
            $table->id('category_id'); // Primary Key kustom
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps(); // <-- Baris ini akan otomatis membuat kolom 'created_at' dan 'updated_at'
        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('disease_categories');
    }
};