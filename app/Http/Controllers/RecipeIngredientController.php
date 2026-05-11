<?php

namespace App\Http\Controllers;

use App\Models\RecipeIngredient;
use App\Models\Recipe; // Wajib ditambahkan untuk form dropdown
use App\Models\FoodNutritionTkpi; // Wajib ditambahkan untuk form dropdown
use Illuminate\Http\Request;

class RecipeIngredientController extends Controller
{
    /**
     * [READ] Menampilkan semua data relasi bahan makanan
     */
    public function index()
    {
        $ingredients = RecipeIngredient::with(['recipe', 'food'])->get();
        
        // Melempar data ke resources/views/recipe_ingredients/index.blade.php
        return view('recipe_ingredients.index', compact('ingredients'));
    }

    /**
     * TAMPILAN FORM TAMBAH BAHAN KE RESEP
     */
    public function create()
    {
        // Mengambil semua data resep dan makanan TKPI agar FE bisa membuat dropdown
        $recipes = Recipe::all();
        $foods = FoodNutritionTkpi::all();
        
        return view('recipe_ingredients.create', compact('recipes', 'foods'));
    }

    /**
     * [CREATE] Menyimpan bahan makanan ke dalam resep
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipe_id'     => 'required|exists:recipes,recipe_id',
            'food_id'       => 'required|exists:food_nutrition_tkpi,food_id',
            'quantity_gram' => 'required|numeric|min:0.1', // Diubah ke 0.1 agar lebih logis untuk berat
        ]);

        RecipeIngredient::create($request->all());

        // Menggunakan back() agar admin tetap berada di halaman form yang sama
        // Sangat berguna kalau admin mau input banyak bahan sekaligus untuk satu resep
        return back()->with('success', 'Bahan makanan berhasil ditambahkan ke resep!');
    }

    /**
     * [READ] Menampilkan detail satu relasi bahan
     */
    public function show(string $id)
    {
        $ingredient = RecipeIngredient::with(['recipe', 'food'])->findOrFail($id);
        
        return view('recipe_ingredients.show', compact('ingredient'));
    }

    /**
     * TAMPILAN FORM EDIT BAHAN
     */
    public function edit(string $id)
    {
        $ingredient = RecipeIngredient::findOrFail($id);
        $recipes = Recipe::all();
        $foods = FoodNutritionTkpi::all();
        
        return view('recipe_ingredients.edit', compact('ingredient', 'recipes', 'foods'));
    }

    /**
     * [UPDATE] Memperbarui relasi bahan (misal mengubah takaran gram)
     */
    public function update(Request $request, string $id)
    {
        $ingredient = RecipeIngredient::findOrFail($id);

        $request->validate([
            'recipe_id'     => 'required|exists:recipes,recipe_id',
            'food_id'       => 'required|exists:food_nutrition_tkpi,food_id',
            'quantity_gram' => 'required|numeric|min:0.1',
        ]);

        $ingredient->update($request->all());

        // Setelah selesai mengedit, arahkan admin kembali ke daftar bahan
        return redirect()->route('recipe_ingredients.index')
                         ->with('success', 'Detail takaran bahan makanan berhasil diupdate!');
    }

    /**
     * [DELETE] Menghapus bahan dari resep
     */
    public function destroy(string $id)
    {
        $ingredient = RecipeIngredient::findOrFail($id);
        $ingredient->delete();

        // Tetap di halaman yang sama setelah menghapus
        return back()->with('success', 'Bahan makanan berhasil dihapus dari resep!');
    }
}