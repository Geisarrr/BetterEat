<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $table = 'recipes';
    protected $primaryKey = 'recipe_id';

    protected $fillable = [
        'name', 'description', 'image_url', 'calories', 'protein_g', 
        'fat_g', 'carbs_g', 'sugar_g', 'fiber_g', 'glycemic_index', 
        'category', 'budget_estimate', 'prep_time_minutes', 
        'ingredients', 'cooking_steps'
    ];
}