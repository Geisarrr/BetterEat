<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\DiseaseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    /**
     * [READ] Menampilkan halaman daftar semua resep dengan filter & search
     * Route: GET /recipes  →  recipes.index
     */
    public function index(Request $request)
    {
        $query = Recipe::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category') && $request->category !== 'Semua') {
            $query->where('category', $request->category);
        }

        if ($request->filled('budget') && $request->budget !== 'Semua Budget') {
            $query->where('budget_estimate', '<=', (int) $request->budget);
        }

        if ($request->filled('kalori') && $request->kalori !== 'Pilih Kalori') {
            $query->where('calories', '<=', (int) $request->kalori);
        }

        if ($request->filled('bahan') && $request->bahan !== 'Semua Bahan') {
            $query->where('ingredients', 'like', '%' . $request->bahan . '%');
        }

        $recipes = $query->latest()->paginate(6)->withQueryString();

        $filterCategories = ['Semua', 'Diabetes', 'Hipertensi', 'Kolesterol', 'Asam Urat', 'Diet'];

        return view('recipes.index', [
            'recipes'           => $recipes,
            'filterCategories'  => $filterCategories,
            'activeCategory'    => $request->category ?? 'Semua',
            'filters'           => $request->only(['search', 'category', 'budget', 'kalori', 'bahan']),
        ]);
    }

    /**
     * [READ] Filter resep berdasarkan kategori via URL segment
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
     */
    public function show(string $id)
    {
        $recipe = Recipe::findOrFail($id);

        $relatedRecipes = Recipe::where('category', $recipe->category)
                                ->where('recipe_id', '!=', $recipe->recipe_id)
                                ->limit(3)
                                ->get();

        return view('recipes.show', compact('recipe', 'relatedRecipes'));
    }

    /**
     * [FORM] Tampilan form tambah resep (Admin)
     */
    public function create()
    {
        $categories = ['Diabetes', 'Hipertensi', 'Fitness', 'Heart-Healthy', 'Kolesterol', 'Asam Urat', 'Diet', 'General'];
        return view('recipes.create', compact('categories'));
    }

    /**
     * [CREATE] Simpan resep baru dari form (Admin)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'description'       => 'nullable|string',
            // ✅ PERBAIKAN: validasi sebagai file upload, bukan string
            'image'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
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

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Simpan ke storage/app/public/recipes/
            // Path yang tersimpan di DB: "recipes/namafile.jpg"
            $imagePath = $request->file('image')->store('recipes', 'public');
        }

        // Ganti key 'image' dengan 'image_url' yang berisi path hasil upload
        unset($validated['image']);
        $validated['image_url'] = $imagePath;

        Recipe::create($validated);

        return redirect()->route('recipes.index')
                         ->with('success', 'Resep berhasil ditambahkan!');
    }

    /**
     * [FORM] Tampilan form edit resep (Admin)
     */
    public function edit(string $id)
    {
        $recipe     = Recipe::findOrFail($id);
        $categories = ['Diabetes', 'Hipertensi', 'Fitness', 'Heart-Healthy', 'Kolesterol', 'Asam Urat', 'Diet', 'General'];

        return view('recipes.edit', compact('recipe', 'categories'));
    }

    /**
     * [UPDATE] Simpan perubahan resep (Admin)
     */
    public function update(Request $request, string $id)
    {
        $recipe = Recipe::findOrFail($id);

        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'description'       => 'nullable|string',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
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

        if ($request->hasFile('image')) {
            // Hapus foto lama dari storage agar tidak menumpuk
            if ($recipe->image_url) {
                Storage::disk('public')->delete($recipe->image_url);
            }
            // Simpan foto baru
            $validated['image_url'] = $request->file('image')->store('recipes', 'public');
        } else {
            // Tidak ada foto baru → pertahankan foto lama
            $validated['image_url'] = $recipe->image_url;
        }

        // Hapus key 'image' dari validated agar tidak error saat update
        unset($validated['image']);

        $recipe->update($validated);

        return redirect()->route('recipes.show', $recipe->recipe_id)
                         ->with('success', 'Resep berhasil diperbarui!');
    }

    /**
     * [DELETE] Hapus resep beserta fotonya (Admin)
     */
    public function destroy(string $id)
    {
        $recipe = Recipe::findOrFail($id);

        if ($recipe->image_url) {
            Storage::disk('public')->delete($recipe->image_url);
        }

        $recipe->delete();

        return redirect()->route('recipes.index')
                         ->with('success', 'Resep berhasil dihapus.');
    }
}