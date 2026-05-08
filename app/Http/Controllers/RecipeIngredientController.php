<?php

namespace App\Http\Controllers;

use App\Models\RecipeIngredient;
use Illuminate\Http\Request;

class RecipeIngredientController extends Controller
{
    public function index()
    {
        // [READ] Menampilkan semua bahan beserta data resep dan detail makanannya
        $ingredients = RecipeIngredient::with(['recipe', 'food'])->get();
        return response()->json($ingredients);
    }

    public function create()
    {
        // Form HTML
    }

    public function store(Request $request)
    {
        // [CREATE] Menyimpan bahan makanan ke dalam resep tertentu
        $request->validate([
            'recipe_id'     => 'required|exists:recipes,recipe_id',
            'food_id'       => 'required|exists:food_nutrition_tkpi,food_id',
            'quantity_gram' => 'required|numeric|min:0',
        ]);

        $ingredient = RecipeIngredient::create($request->all());

        return response()->json([
            'message' => 'Bahan makanan berhasil ditambahkan ke resep!',
            'data'    => $ingredient
        ]);
    }

    public function show(string $id)
    {
        // [READ] Menampilkan detail satu relasi bahan beserta data resep dan makanannya
        $ingredient = RecipeIngredient::with(['recipe', 'food'])->findOrFail($id);
        return response()->json($ingredient);
    }

    public function edit(string $id)
    {
        // Form HTML
    }

    public function update(Request $request, string $id)
    {
        // [UPDATE] Memperbarui relasi bahan (misal mengubah takaran gram)
        $ingredient = RecipeIngredient::findOrFail($id);

        $request->validate([
            'recipe_id'     => 'sometimes|required|exists:recipes,recipe_id',
            'food_id'       => 'sometimes|required|exists:food_nutrition_tkpi,food_id',
            'quantity_gram' => 'sometimes|required|numeric|min:0',
        ]);

        $ingredient->update($request->all());

        return response()->json([
            'message' => 'Detail bahan makanan berhasil diupdate!',
            'data'    => $ingredient
        ]);
    }

    public function destroy(string $id)
    {
        // [DELETE] Menghapus bahan dari resep
        $ingredient = RecipeIngredient::findOrFail($id);
        $ingredient->delete();

        return response()->json(['message' => 'Bahan makanan berhasil dihapus dari resep!']);
    }
}