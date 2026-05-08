<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeIngredient extends Model
{
    use HasFactory;

    protected $table = 'recipe_ingredients';
    protected $primaryKey = 'ingredient_id';
    
    // Matikan timestamps karena tidak ada di tabel
    public $timestamps = false;

    protected $fillable = [
        'recipe_id',
        'food_id',
        'quantity_gram',
    ];

    /**
     * Relasi ke tabel Recipes (Milik resep yang mana)
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id', 'recipe_id');
    }

    /**
     * Relasi ke tabel Food Nutrition TKPI (Bahan makanannya apa)
     */
    public function food()
    {
        return $this->belongsTo(FoodNutritionTkpi::class, 'food_id', 'food_id');
    }
}