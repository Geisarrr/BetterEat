<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * [READ] Menampilkan halaman daftar semua resep
     */
    public function index()
    {
        $recipes = Recipe::latest()->get();
        
        // Melempar variabel $recipes ke resources/views/recipes/index.blade.php
        return view('recipes.index', compact('recipes'));
    }

    /**
     * [READ] Menampilkan halaman daftar resep yang sudah difilter berdasarkan kategori
     */
    public function getByCategory($category)
    {
        $recipes = Recipe::where('category', $category)->latest()->get();

        // Kita bisa me-reuse file view index yang sama, tapi datanya sudah terfilter
        return view('recipes.index', compact('recipes', 'category'));
    }

    /**
     * TAMPILAN FORM TAMBAH RESEP
     */
    public function create()
    {
        // Opsional: Bikin array kategori statis buat mempermudah FE bikin dropdown form
        $categories = ['Diabetes', 'Fitness', 'Heart-Healthy', 'General'];
        
        return view('recipes.create', compact('categories'));
    }

    /**
     * [CREATE] Menyimpan resep baru dari form
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'description'       => 'nullable|string',
            'image_url'         => 'nullable|string',
            'calories'          => 'required|numeric',
            'protein_g'         => 'required|numeric',
            'fat_g'             => 'required|numeric',
            'carbs_g'           => 'required|numeric',
            'sugar_g'           => 'required|numeric',
            'fiber_g'           => 'required|numeric',
            'glycemic_index'    => 'required|in:Low,Medium,High',
            'category'          => 'required|string',
            'budget_estimate'   => 'required|numeric',
            'prep_time_minutes' => 'nullable|integer',
            'ingredients'       => 'required|string',
            'cooking_steps'     => 'required|string',
        ]);

        Recipe::create($request->all());

        // Lempar kembali ke halaman daftar resep dengan pesan sukses
        return redirect()->route('recipes.index')
                         ->with('success', 'Resep masakan berhasil ditambahkan ke sistem!');
    }

    /**
     * [READ] Menampilkan detail lengkap satu resep
     */
    public function show(string $id)
    {
        $recipe = Recipe::findOrFail($id);
        
        return view('recipes.show', compact('recipe'));
    }

    /**
     * TAMPILAN FORM EDIT RESEP
     */
    public function edit(string $id)
    {
        $recipe = Recipe::findOrFail($id);
        $categories = ['Diabetes', 'Fitness', 'Heart-Healthy', 'General'];
        
        return view('recipes.edit', compact('recipe', 'categories'));
    }

    /**
     * [UPDATE] Menyimpan perubahan data resep dari form edit
     */
    public function update(Request $request, string $id)
    {
        $recipe = Recipe::findOrFail($id);

        // Di form web (Blade), kita gunakan 'required' biasa karena semua data biasanya dikirim ulang saat submit
        $request->validate([
            'name'              => 'required|string|max:255',
            'description'       => 'nullable|string',
            'image_url'         => 'nullable|string',
            'calories'          => 'required|numeric',
            'protein_g'         => 'required|numeric',
            'fat_g'             => 'required|numeric',
            'carbs_g'           => 'required|numeric',
            'sugar_g'           => 'required|numeric',
            'fiber_g'           => 'required|numeric',
            'glycemic_index'    => 'required|in:Low,Medium,High',
            'category'          => 'required|string',
            'budget_estimate'   => 'required|numeric',
            'prep_time_minutes' => 'nullable|integer',
            'ingredients'       => 'required|string',
            'cooking_steps'     => 'required|string',
        ]);

        $recipe->update($request->all());

        // Arahkan ke halaman detail resep tersebut setelah berhasil update
        return redirect()->route('recipes.show', $recipe->id)
                         ->with('success', 'Resep masakan berhasil diperbarui!');
    }

    /**
     * [DELETE] Menghapus resep
     */
    public function destroy(string $id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();
        
        return redirect()->route('recipes.index')
                         ->with('success', 'Resep masakan berhasil dihapus!');
    }
}