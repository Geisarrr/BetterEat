<?php

namespace App\Http\Controllers;

use App\Models\SavedRecipe;
use Illuminate\Http\Request;

class SavedRecipeController extends Controller
{
    public function index()
    {
        // [READ] Menampilkan semua data resep yang disimpan beserta detail user & resepnya
        $savedRecipes = SavedRecipe::with(['user', 'recipe'])->get();
        return response()->json($savedRecipes);
    }

    public function create()
    {
        // Form HTML
    }

    public function store(Request $request)
    {
        // [CREATE] Menyimpan resep ke daftar favorit user
        $request->validate([
            'user_id'   => 'required|exists:users,user_id',
            'recipe_id' => 'required|exists:recipes,recipe_id',
        ]);

        // Cek apakah user sudah pernah menyimpan resep ini sebelumnya
        $alreadySaved = SavedRecipe::where('user_id', $request->user_id)
                                   ->where('recipe_id', $request->recipe_id)
                                   ->first();

        if ($alreadySaved) {
            return response()->json(['message' => 'Resep ini sudah ada di daftar simpanan kamu!'], 400);
        }

        $savedRecipe = SavedRecipe::create($request->all());

        return response()->json([
            'message' => 'Resep berhasil disimpan!',
            'data'    => $savedRecipe
        ]);
    }

    public function show(string $id)
    {
        // [READ] Menampilkan detail spesifik satu data simpanan
        $savedRecipe = SavedRecipe::with(['user', 'recipe'])->findOrFail($id);
        return response()->json($savedRecipe);
    }

    public function edit(string $id)
    {
        // Form HTML
    }

    public function update(Request $request, string $id)
    {
        // [UPDATE] Secara logika bisnis, fitur bookmark jarang di-update. 
        // Namun fungsi ini tetap disiapkan sesuai standar CRUD.
        $savedRecipe = SavedRecipe::findOrFail($id);

        $request->validate([
            'user_id'   => 'sometimes|required|exists:users,user_id',
            'recipe_id' => 'sometimes|required|exists:recipes,recipe_id',
        ]);

        $savedRecipe->update($request->all());

        return response()->json([
            'message' => 'Data simpanan berhasil diperbarui!',
            'data'    => $savedRecipe
        ]);
    }

    public function destroy(string $id)
    {
        // [DELETE] Menghapus resep dari daftar simpanan (Unsave)
        $savedRecipe = SavedRecipe::findOrFail($id);
        $savedRecipe->delete();

        return response()->json(['message' => 'Resep berhasil dihapus dari daftar simpanan!']);
    }
}