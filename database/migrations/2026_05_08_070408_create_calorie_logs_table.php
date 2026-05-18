// create_calorie_logs_table.php
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

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('cascade');

            // Nullable karena input manual tidak memilih dari daftar makanan
            $table->unsignedBigInteger('food_id')->nullable();
            $table->foreign('food_id')
                  ->references('food_id')
                  ->on('food_nutrition_tkpi')
                  ->onDelete('cascade');

            $table->string('meal_name')->nullable();
            $table->string('meal_time')->nullable();

            // Nullable karena input manual tidak perlu berat gram
            $table->decimal('quantity_gram', 8, 2)->nullable();

            $table->decimal('calories',  10, 2)->default(0);
            $table->decimal('protein_g', 10, 2)->default(0);
            $table->decimal('fat_g',     10, 2)->default(0);
            $table->decimal('carbs_g',   10, 2)->default(0);

            $table->timestamp('logged_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calorie_logs');
    }
};