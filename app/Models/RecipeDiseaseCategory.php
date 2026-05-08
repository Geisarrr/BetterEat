<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeDiseaseCategory extends Model
{
    use HasFactory;

    protected $table = 'recipe_disease_categories';

    // Matikan auto-increment karena tidak ada kolom 'id' tunggal
    public $incrementing = false;
    
    // Matikan timestamps karena tidak ada created_at / updated_at
    public $timestamps = false;

    protected $fillable = [
        'recipe_id',
        'category_id',
    ];

    /**
     * Relasi ke tabel Recipes
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id', 'recipe_id');
    }

    /**
     * Relasi ke tabel Disease Categories
     */
    public function category()
    {
        return $this->belongsTo(DiseaseCategory::class, 'category_id', 'category_id');
    }
}