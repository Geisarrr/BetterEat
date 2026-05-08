<?php

namespace App\Http\Controllers;

use App\Models\FoodNutritionTkpi;
use Illuminate\Http\Request;

class FoodNutritionTkpiController extends Controller
{
    public function index()
    {
        $foods = FoodNutritionTkpi::all();
        return response()->json($foods);
    }

    public function create()
    {
        // Form HTML
    }

    public function store(Request $request)
    {
        $request->validate([
            'food_name'         => 'required|string|max:255',
            'calories_per_100g' => 'required|numeric',
            'protein_g'         => 'required|numeric',
            'fat_g'             => 'required|numeric',
            'carbs_g'           => 'required|numeric',
            'fiber_g'           => 'required|numeric',
        ]);

        $food = FoodNutritionTkpi::create($request->all());

        return response()->json([
            'message' => 'Data nutrisi makanan berhasil ditambahkan!',
            'data'    => $food
        ]);
    }

    public function show(string $id)
    {
        $food = FoodNutritionTkpi::findOrFail($id);
        return response()->json($food);
    }

    public function edit(string $id)
    {
        // Form edit HTML
    }

    public function update(Request $request, string $id)
    {
        $food = FoodNutritionTkpi::findOrFail($id);

        $request->validate([
            'food_name'         => 'sometimes|required|string|max:255',
            'calories_per_100g' => 'sometimes|required|numeric',
            'protein_g'         => 'sometimes|required|numeric',
            'fat_g'             => 'sometimes|required|numeric',
            'carbs_g'           => 'sometimes|required|numeric',
            'fiber_g'           => 'sometimes|required|numeric',
        ]);

        $food->update($request->all());

        return response()->json([
            'message' => 'Data nutrisi makanan berhasil diupdate!',
            'data'    => $food
        ]);
    }

    public function destroy(string $id)
    {
        $food = FoodNutritionTkpi::findOrFail($id);
        $food->delete();
        
        return response()->json(['message' => 'Data nutrisi berhasil dihapus!']);
    }
}