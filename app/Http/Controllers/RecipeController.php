<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\DiseaseCategory;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * [READ] Menampilkan halaman daftar semua resep dengan filter & search
     * Route: GET /recipes  →  recipes.index
     */
    public function index(Request $request)
    {
        $query = Recipe::query();

        // --- FILTER: Search by nama resep ---
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // --- FILTER: Kategori penyakit (tab aktif) ---
        // Nilai yang diterima: 'Semua', 'Diabetes', 'Hipertensi', 'Kolesterol', 'Asam Urat', 'Diet'
        if ($request->filled('category') && $request->category !== 'Semua') {
            $query->where('category', $request->category);
        }

        // --- FILTER: Budget (budget_estimate <= nilai pilihan) ---
        // Nilai yang diterima dari dropdown: '15000', '25000', '50000', '100000'
        if ($request->filled('budget') && $request->budget !== 'Semua Budget') {
            $query->where('budget_estimate', '<=', (int) $request->budget);
        }

        // --- FILTER: Kalori (calories <= nilai pilihan) ---
        // Nilai yang diterima: '200', '400', '600'
        if ($request->filled('kalori') && $request->kalori !== 'Pilih Kalori') {
            $query->where('calories', '<=', (int) $request->kalori);
        }

        // --- FILTER: Bahan utama (search di dalam field ingredients) ---
        if ($request->filled('bahan') && $request->bahan !== 'Semua Bahan') {
            $query->where('ingredients', 'like', '%' . $request->bahan . '%');
        }

        // --- LOAD: Ambil semua resep, paginate 6 per halaman ---
        $recipes = $query->latest()->paginate(6)->withQueryString();

        // --- LOAD: Ambil semua category_id dari disease_categories untuk tab filter ---
        // Gunakan array statis agar tidak perlu query kalau tabel disease_categories belum ada
        $filterCategories = ['Semua', 'Diabetes', 'Hipertensi', 'Kolesterol', 'Asam Urat', 'Diet'];

        // --- Kirim variabel ke view ---
        return view('recipes.index', [
            'recipes'           => $recipes,
            'filterCategories'  => $filterCategories,
            'activeCategory'    => $request->category ?? 'Semua',
            'filters'           => $request->only(['search', 'category', 'budget', 'kalori', 'bahan']),
        ]);
    }

    /**
     * [READ] Filter resep berdasarkan kategori via URL segment
     * Route: GET /recipes/category/{category}  →  recipes.category
     * (Opsional, bisa juga pakai query string dari index())
     */
    public function getByCategory($category)
    {
        $recipes = Recipe::where('category', $category)->latest()->paginate(6);
        $filterCategories = ['Semua', 'Diabetes', 'Hipertensi', 'Kolesterol', 'Asam Urat', 'Diet'];

        return view('recipes.index', [
            'recipes'          => $recipes,
            'filterCategories' => $filterCategories,
            'activeCategory'   => $category,
            'filters'          => ['category' => $category],
        ]);
    }

    /**
     * [READ] Menampilkan detail lengkap satu resep
     * Route: GET /recipes/{id}  →  recipes.show
     */
    public function show(string $id)
    {
        $recipe = Recipe::findOrFail($id);

        // Resep serupa: kategori sama, exclude yang sedang dilihat, max 3
        $relatedRecipes = Recipe::where('category', $recipe->category)
                                ->where('recipe_id', '!=', $recipe->recipe_id)
                                ->limit(3)
                                ->get();

        return view('recipes.show', compact('recipe', 'relatedRecipes'));
    }

    /**
     * [FORM] Tampilan form tambah resep (Admin)
     * Route: GET /recipes/create  →  recipes.create
     */
    public function create()
    {
        $categories = ['Diabetes', 'Hipertensi', 'Fitness', 'Heart-Healthy', 'Kolesterol', 'Asam Urat', 'Diet', 'General'];
        return view('recipes.create', compact('categories'));
    }

    /**
     * [CREATE] Simpan resep baru dari form (Admin)
     * Route: POST /recipes  →  recipes.store
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'description'       => 'nullable|string',
            'image_url'         => 'nullable|string',
            'calories'          => 'required|numeric|min:0',
            'protein_g'         => 'required|numeric|min:0',
            'fat_g'             => 'required|numeric|min:0',
            'carbs_g'           => 'required|numeric|min:0',
            'sugar_g'           => 'required|numeric|min:0',
            'fiber_g'           => 'required|numeric|min:0',
            'glycemic_index'    => 'required|in:Low,Medium,High',
            'category'          => 'required|string',
            'budget_estimate'   => 'required|numeric|min:0',
            'prep_time_minutes' => 'nullable|integer|min:0',
            'ingredients'       => 'required|string',
            'cooking_steps'     => 'required|string',
        ]);

        Recipe::create($validated);

        return redirect()->route('recipes.index')
                         ->with('success', 'Resep berhasil ditambahkan!');
    }

    /**
     * [FORM] Tampilan form edit resep (Admin)
     * Route: GET /recipes/{id}/edit  →  recipes.edit
     */
    public function edit(string $id)
    {
        $recipe     = Recipe::findOrFail($id);
        $categories = ['Diabetes', 'Hipertensi', 'Fitness', 'Heart-Healthy', 'Kolesterol', 'Asam Urat', 'Diet', 'General'];

        return view('recipes.edit', compact('recipe', 'categories'));
    }

    /**
     * [UPDATE] Simpan perubahan resep (Admin)
     * Route: PUT /recipes/{id}  →  recipes.update
     */
    public function update(Request $request, string $id)
    {
        $recipe = Recipe::findOrFail($id);

        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'description'       => 'nullable|string',
            'image_url'         => 'nullable|string',
            'calories'          => 'required|numeric|min:0',
            'protein_g'         => 'required|numeric|min:0',
            'fat_g'             => 'required|numeric|min:0',
            'carbs_g'           => 'required|numeric|min:0',
            'sugar_g'           => 'required|numeric|min:0',
            'fiber_g'           => 'required|numeric|min:0',
            'glycemic_index'    => 'required|in:Low,Medium,High',
            'category'          => 'required|string',
            'budget_estimate'   => 'required|numeric|min:0',
            'prep_time_minutes' => 'nullable|integer|min:0',
            'ingredients'       => 'required|string',
            'cooking_steps'     => 'required|string',
        ]);

        $recipe->update($validated);

        return redirect()->route('recipes.show', $recipe->recipe_id)
                         ->with('success', 'Resep berhasil diperbarui!');
    }

    /**
     * [DELETE] Hapus resep (Admin)
     * Route: DELETE /recipes/{id}  →  recipes.destroy
     */
    public function destroy(string $id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();

        return redirect()->route('recipes.index')
                         ->with('success', 'Resep berhasil dihapus.');
    }
}