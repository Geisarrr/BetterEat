<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $table = 'recipes';
    protected $primaryKey = 'recipe_id';
    
    // Matikan fitur updated_at karena di migration hanya ada created_at
    const UPDATED_AT = null;

    protected $fillable = [
        'name',
        'description',
        'image_url',
        'calories',
        'budget_estimate',
        'cooking_steps',
    ];
}