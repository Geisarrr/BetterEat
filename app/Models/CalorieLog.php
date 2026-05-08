<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalorieLog extends Model
{
    use HasFactory;

    protected $table = 'calorie_logs';
    protected $primaryKey = 'log_id';

    // Matikan timestamps bawaan Laravel karena menggunakan logged_at
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'food_id',
        'quantity_gram',
        'logged_at', // Bisa diisi manual atau dibiarkan agar otomatis pakai waktu server
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