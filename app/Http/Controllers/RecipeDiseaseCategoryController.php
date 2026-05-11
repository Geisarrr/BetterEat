<?php

namespace App\Http\Controllers;

use App\Models\RecipeDiseaseCategory;
use Illuminate\Http\Request;

class RecipeDiseaseCategoryController extends Controller
{
    /**
     * [READ] Menampilkan daftar relasi (Opsional, untuk tabel admin)
     */
    public function index()
    {
        $relations = RecipeDiseaseCategory::with(['recipe', 'category'])->get();
        
        // Melempar data ke resources/views/recipe_categories/index.blade.php
        return view('recipe_categories.index', compact('relations'));
    }

    /**
     * [CREATE] Memasang Kategori Penyakit ke Resep (Attach)
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipe_id'   => 'required|exists:recipes,recipe_id',
            'category_id' => 'required|exists:disease_categories,category_id',
        ]);

        // Mencegah duplikasi data manual
        $exists = RecipeDiseaseCategory::where('recipe_id', $request->recipe_id)
                                       ->where('category_id', $request->category_id)
                                       ->first();

        if ($exists) {
            // Gunakan withErrors untuk mengirim pesan gagal ke Blade
            return back()->withErrors(['category_id' => 'Resep ini sudah memiliki kategori tersebut!']);
        }

        RecipeDiseaseCategory::create([
            'recipe_id'   => $request->recipe_id,
            'category_id' => $request->category_id,
        ]);

        // Redirect back agar halaman me-refresh secara instan di tempat admin berada
        return back()->with('success', 'Kategori berhasil ditambahkan ke resep!');
    }

    /**
     * [DELETE] Melepas Relasi Kategori dari Resep (Detach)
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'recipe_id'   => 'required|integer',
            'category_id' => 'required|integer',
        ]);

        $deleted = RecipeDiseaseCategory::where('recipe_id', $request->recipe_id)
                                        ->where('category_id', $request->category_id)
                                        ->delete();

        if ($deleted) {
            return back()->with('success', 'Kategori berhasil dilepas dari resep!');
        }

        return back()->withErrors(['message' => 'Data relasi tidak ditemukan!']);
    }
}