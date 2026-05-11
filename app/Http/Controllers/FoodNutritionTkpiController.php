<?php

namespace App\Http\Controllers;

use App\Models\FoodNutritionTkpi;
use Illuminate\Http\Request;

class FoodNutritionTkpiController extends Controller
{
    /**
     * [READ] Menampilkan halaman daftar semua nutrisi makanan
     */
    public function index()
    {
        $foods = FoodNutritionTkpi::all();
        
        // Lempar data ke resources/views/food_nutrition/index.blade.php
        return view('food_nutrition.index', compact('foods'));
    }

    /**
     * TAMPILAN FORM TAMBAH DATA
     */
    public function create()
    {
        // Lempar ke resources/views/food_nutrition/create.blade.php
        return view('food_nutrition.create');
    }

    /**
     * [CREATE] Menyimpan data nutrisi baru
     */
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

        FoodNutritionTkpi::create($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('food_nutrition.index')
                         ->with('success', 'Data nutrisi makanan berhasil ditambahkan!');
    }

    /**
     * [READ] Menampilkan detail satu makanan
     */
    public function show(string $id)
    {
        $food = FoodNutritionTkpi::findOrFail($id);
        
        // Lempar ke resources/views/food_nutrition/show.blade.php
        return view('food_nutrition.show', compact('food'));
    }

    /**
     * TAMPILAN FORM EDIT DATA
     */
    public function edit(string $id)
    {
        $food = FoodNutritionTkpi::findOrFail($id);
        
        // Lempar ke resources/views/food_nutrition/edit.blade.php
        return view('food_nutrition.edit', compact('food'));
    }

    /**
     * [UPDATE] Menyimpan perubahan data nutrisi
     */
    public function update(Request $request, string $id)
    {
        $food = FoodNutritionTkpi::findOrFail($id);

        $request->validate([
            'food_name'         => 'required|string|max:255',
            'calories_per_100g' => 'required|numeric',
            'protein_g'         => 'required|numeric',
            'fat_g'             => 'required|numeric',
            'carbs_g'           => 'required|numeric',
            'fiber_g'           => 'required|numeric',
        ]);

        $food->update($request->all());

        // Redirect ke halaman index setelah update
        return redirect()->route('food_nutrition.index')
                         ->with('success', 'Data nutrisi makanan berhasil diupdate!');
    }

    /**
     * [DELETE] Menghapus data nutrisi
     */
    public function destroy(string $id)
    {
        $food = FoodNutritionTkpi::findOrFail($id);
        $food->delete();
        
        return back()->with('success', 'Data nutrisi berhasil dihapus!');
    }
}