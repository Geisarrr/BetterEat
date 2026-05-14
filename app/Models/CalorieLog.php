<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalorieLog extends Model
{
    use HasFactory;

    protected $table = 'calorie_logs';
    protected $primaryKey = 'log_id';

    // public $timestamps = false; <--- Dihapus agar Laravel otomatis mengisi created_at & updated_at

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

    /**
     * Relasi ke tabel Users
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relasi ke tabel Food Nutrition TKPI
     */
    public function food()
    {
        return $this->belongsTo(FoodNutritionTkpi::class, 'food_id', 'food_id');
    }
}