<?php

namespace App\Http\Controllers;

use App\Models\RecipeDiseaseCategory;
use Illuminate\Http\Request;

class RecipeDiseaseCategoryController extends Controller
{
    public function index()
    {
        // [READ] Menampilkan semua data relasi beserta detail resep dan kategorinya
        $relations = RecipeDiseaseCategory::with(['recipe', 'category'])->get();
        return response()->json($relations);
    }

    public function create()
    {
        // Form HTML
    }

    public function store(Request $request)
    {
        // [CREATE] Menghubungkan Resep dengan Kategori Penyakit
        $request->validate([
            'recipe_id'   => 'required|exists:recipes,recipe_id',
            'category_id' => 'required|exists:disease_categories,category_id',
        ]);

        // Mencegah duplikasi data manual
        $exists = RecipeDiseaseCategory::where('recipe_id', $request->recipe_id)
                                       ->where('category_id', $request->category_id)
                                       ->first();

        if ($exists) {
            return response()->json(['message' => 'Relasi ini sudah ada!'], 400);
        }

        $relation = RecipeDiseaseCategory::create($request->all());

        return response()->json([
            'message' => 'Resep berhasil dihubungkan dengan kategori!',
            'data'    => $relation
        ]);
    }

    public function show(Request $request)
    {
        // [READ] Kita tidak menggunakan string $id, melainkan mencari berdasarkan dua parameter
        $request->validate([
            'recipe_id'   => 'required|integer',
            'category_id' => 'required|integer',
        ]);

        $relation = RecipeDiseaseCategory::with(['recipe', 'category'])
                        ->where('recipe_id', $request->recipe_id)
                        ->where('category_id', $request->category_id)
                        ->firstOrFail();

        return response()->json($relation);
    }

    public function edit(string $id)
    {
        // Form HTML
    }

    public function update(Request $request, string $id)
    {
        // [UPDATE] Pada tabel pivot, update biasanya jarang digunakan. 
        // Praktik terbaik adalah menghapus (destroy) relasi lama dan membuat (store) yang baru.
        return response()->json(['message' => 'Gunakan metode delete dan create untuk mengubah relasi pivot.'], 405);
    }

    public function destroy(Request $request)
    {
        // [DELETE] Menghapus relasi berdasarkan kombinasi kedua ID
        $request->validate([
            'recipe_id'   => 'required|integer',
            'category_id' => 'required|integer',
        ]);

        $deleted = RecipeDiseaseCategory::where('recipe_id', $request->recipe_id)
                                        ->where('category_id', $request->category_id)
                                        ->delete();

        if ($deleted) {
            return response()->json(['message' => 'Relasi berhasil dihapus!']);
        }

        return response()->json(['message' => 'Data relasi tidak ditemukan!'], 404);
    }
}