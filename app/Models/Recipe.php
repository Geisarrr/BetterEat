<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $table      = 'recipes';
    protected $primaryKey = 'recipe_id';

    protected $fillable = [
        'name', 'description', 'image_url',
        'calories', 'protein_g', 'fat_g', 'carbs_g', 'sugar_g', 'fiber_g',
        'glycemic_index', 'category',
        'prep_time_minutes', 'ingredients', 'cooking_steps',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Bahan-bahan dari tabel pivot recipe_ingredients → food_nutrition_tkpi
     */
    public function recipeIngredients()
    {
        return $this->hasMany(RecipeIngredient::class, 'recipe_id', 'recipe_id');
    }

    /**
     * Kategori penyakit dari tabel pivot recipe_disease_categories
     */
    public function diseaseCategories()
    {
        return $this->belongsToMany(
            DiseaseCategory::class,
            'recipe_disease_categories',
            'recipe_id',
            'category_id',
            'recipe_id',
            'category_id'
        );
    }

    public function category()
    {
        // Sesuaikan dengan nama model kategori yang ada di sistem
        return $this->belongsTo(DiseaseCategory::class, 'category_id');
    }

    /**
     * User yang menyimpan resep ini (SavedRecipe)
     */
    public function savedByUsers()
    {
        return $this->hasMany(SavedRecipe::class, 'recipe_id', 'recipe_id');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER / ACCESSOR
    |--------------------------------------------------------------------------
    */

    /**
     * Format budget: Rp 25.000
     */
    public function getFormattedBudgetAttribute(): string
    {
        return 'Rp ' . number_format($this->budget_estimate, 0, ',', '.');
    }

    /**
     * Format kalori: "280 kal"
     */
    public function getFormattedCaloriesAttribute(): string
    {
        return number_format($this->calories, 0) . ' kal';
    }

    /**
     * Format waktu masak: "30 Menit" atau null jika tidak ada
     */
    public function getFormattedPrepTimeAttribute(): ?string
    {
        return $this->prep_time_minutes
            ? $this->prep_time_minutes . ' Menit'
            : null;
    }

    /**
     * Kembalikan bahan-bahan sebagai array (dipisah newline)
     */
    public function getIngredientsArrayAttribute(): array
    {
        return array_filter(
            array_map('trim', explode("\n", $this->ingredients))
        );
    }

    /**
     * Kembalikan langkah memasak sebagai array (dipisah newline)
     */
    public function getCookingStepsArrayAttribute(): array
    {
        return array_filter(
            array_map('trim', explode("\n", $this->cooking_steps))
        );
    }

    /**
     * URL gambar (gunakan placeholder jika kosong)
     */
    public function getImageSrcAttribute(): string
    {
        if (!empty($this->image_url)) {
            return asset('storage/' . $this->image_url);
        }

        // Fallback placeholder dengan nama resep sebagai teks
        return 'https://placehold.co/600x400/C5D8A4/3C4C25?text=' . urlencode($this->name);
    }

    /**
     * Warna badge kategori (Tailwind classes)
     * Dipakai di blade: $recipe->category_badge_color
     */
    public function getCategoryBadgeColorAttribute(): string
    {
        return match ($this->category) {
            'Diabetes'      => 'bg-blue-100 text-blue-700',
            'Hipertensi'    => 'bg-red-100 text-red-700',
            'Fitness'       => 'bg-purple-100 text-purple-700',
            'Heart-Healthy' => 'bg-pink-100 text-pink-700',
            'Kolesterol'    => 'bg-orange-100 text-orange-700',
            'Asam Urat'     => 'bg-yellow-100 text-yellow-700',
            'Diet'          => 'bg-teal-100 text-teal-700',
            default         => 'bg-green-100 text-green-700',
        };
    }

    /**
     * Label kategori dalam Bahasa Indonesia
     */
    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'Heart-Healthy' => 'Jantung Sehat',
            'Fitness'       => 'Fitness',
            default         => $this->category,
        };
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES (Opsional — bisa dipakai di controller)
    |--------------------------------------------------------------------------
    */

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeLowCalorie($query, int $max = 300)
    {
        return $query->where('calories', '<=', $max);
    }

    public function scopeAffordable($query, int $maxBudget)
    {
        return $query->where('budget_estimate', '<=', $maxBudget);
    }
}