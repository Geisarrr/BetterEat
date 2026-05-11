<?php

namespace App\Http\Controllers;

use App\Models\SavedRecipe;
use App\Models\Recipe; // Tambahkan ini untuk validasi resep
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Wajib untuk keamanan sesi

class SavedRecipeController extends Controller
{
    /**
     * [READ] Menampilkan halaman daftar koleksi resep milik user yang sedang login
     */
    public function index()
    {
        // Ambil ID user dari sesi login
        $userId = Auth::id();

        // Ambil data simpanan HANYA milik user tersebut, beserta detail resepnya
        $savedRecipes = SavedRecipe::with('recipe')
                                   ->where('user_id', $userId)
                                   ->latest()
                                   ->get();

        // Lempar ke resources/views/saved_recipes/index.blade.php
        return view('saved_recipes.index', compact('savedRecipes'));
    }

    /**
     * [ACTION] Toggle Save / Unsave
     * Fungsi ini menggantikan create, store, edit, update, dan destroy.
     * Cukup 1 fungsi untuk 2 aksi (Simpan / Hapus Simpanan).
     */
    public function toggle($recipeId)
    {
        // 1. Pastikan resep yang mau disimpan itu beneran ada di database
        $recipe = Recipe::findOrFail($recipeId);
        
        // 2. Ambil ID user yang lagi login
        $userId = Auth::id();

        // 3. Cek apakah resep ini sudah ada di daftar simpanan user
        $existingSave = SavedRecipe::where('user_id', $userId)
                                   ->where('recipe_id', $recipeId)
                                   ->first();

        if ($existingSave) {
            // [UNSAVE] Jika sudah ada, berarti user klik tombol untuk menghapus bookmark
            $existingSave->delete();
            
            return back()->with('success', 'Resep dihapus dari koleksi simpananmu.');
        } else {
            // [SAVE] Jika belum ada, simpan resep tersebut
            SavedRecipe::create([
                'user_id'   => $userId,
                'recipe_id' => $recipeId,
            ]);
            
            return back()->with('success', 'Mantap! Resep berhasil disimpan ke koleksimu.');
        }
    }
}