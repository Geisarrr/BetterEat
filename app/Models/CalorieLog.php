<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FoodNutritionTkpi; // ← Tambah ini

class CalorieLog extends Model
{
    use HasFactory;

    protected $table = 'calorie_logs';
    protected $primaryKey = 'log_id';

    protected $fillable = [
        'user_id',
        'meal_name',
        'meal_time',
        'food_id',
        'quantity_gram',
        'calories',
        'protein_g',
        'fat_g',
        'carbs_g',
        'logged_at',
    ];

    protected $casts = [
        'logged_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function food()
    {
        return $this->belongsTo(FoodNutritionTkpi::class, 'food_id', 'food_id'); // ← Sekarang terbaca
    }
}