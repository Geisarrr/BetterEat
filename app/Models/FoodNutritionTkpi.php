<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodNutritionTkpi extends Model
{
    use HasFactory;

    protected $table = 'food_nutrition_tkpi';
    protected $primaryKey = 'food_id';

    protected $fillable = [
        'food_name',
        'calories_per_100g',
        'protein_g',
        'fat_g',
        'carbs_g',
        'fiber_g',
    ];
}