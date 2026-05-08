<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::all();
        return response()->json($recipes);
    }

    public function create()
    {
        // Form HTML untuk tambah resep
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'image_url'       => 'nullable|string',
            'calories'        => 'required|numeric',
            'budget_estimate' => 'required|numeric',
            'cooking_steps'   => 'required|string',
        ]);

        $recipe = Recipe::create($request->all());

        return response()->json([
            'message' => 'Resep masakan berhasil ditambahkan!',
            'data'    => $recipe
        ]);
    }

    public function show(string $id)
    {
        $recipe = Recipe::findOrFail($id);
        return response()->json($recipe);
    }

    public function edit(string $id)
    {
        // Form HTML untuk edit resep
    }

    public function update(Request $request, string $id)
    {
        $recipe = Recipe::findOrFail($id);

        $request->validate([
            'name'            => 'sometimes|required|string|max:255',
            'description'     => 'nullable|string',
            'image_url'       => 'nullable|string',
            'calories'        => 'sometimes|required|numeric',
            'budget_estimate' => 'sometimes|required|numeric',
            'cooking_steps'   => 'sometimes|required|string',
        ]);

        $recipe->update($request->all());

        return response()->json([
            'message' => 'Resep masakan berhasil diupdate!',
            'data'    => $recipe
        ]);
    }

    public function destroy(string $id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();
        
        return response()->json(['message' => 'Resep berhasil dihapus!']);
    }
}