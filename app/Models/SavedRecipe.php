<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedRecipe extends Model
{
    use HasFactory;

    protected $table = 'saved_recipes';
    protected $primaryKey = 'saved_id';

    // Matikan timestamps karena tidak ada di tabel
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'recipe_id',
    ];

    /**
     * Relasi ke tabel Users (Siapa yang menyimpan resep ini)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relasi ke tabel Recipes (Resep apa yang disimpan)
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id', 'recipe_id');
    }
}