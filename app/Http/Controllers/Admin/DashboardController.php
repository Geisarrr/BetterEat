<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Recipe;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    //
    public function index()
    {
        // Mengarahkan ke file resources/views/admin/dashboard.blade.php
        return view('admin.dashboard');
    }

    public function users(Request $request)
    {
        // Membangun query dasar
        $query = User::query();

        // Jika ada input pencarian di kolom search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('full_name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        }

        // Mengambil data dengan pagination (10 data per halaman)
        $users = $query->paginate(10)->withQueryString();

        // Mengirim data ke view
        return view('admin.users', compact('users'));
    }

    public function userDetail(string $id)
    {
        // Mengambil data user berdasarkan user_id, jika tidak ada akan muncul 404
        $user = User::with('profile')->where('user_id', $id)->firstOrFail();
    
        // Menghitung statistik langsung dari database
        $stat_resep_disimpan = DB::table('saved_recipes')->where('user_id', $id)->count();
        $stat_postingan = DB::table('posts')->where('user_id', $id)->count();
        $stat_jurnal = DB::table('calorie_logs')->where('user_id', $id)->count();
    
        return view('admin.user-detail', compact(
            'user', 
            'stat_resep_disimpan', 
            'stat_postingan', 
            'stat_jurnal'
        ));
    }

    public function recipes(Request $request)
    {
        $query = Recipe::query();

        // 1. Logika Search Bar (Berdasarkan Nama Resep)
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 2. Logika Filter Kategori (Berdasarkan kolom 'category')
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Mengambil data dengan pagination (10 data per halaman)
        $recipes = $query->paginate(10)->withQueryString();

        // Mengambil daftar kategori unik langsung dari database untuk Dropdown
        $categories = Recipe::select('category')->distinct()->whereNotNull('category')->pluck('category');

        return view('admin.recipes', compact('recipes', 'categories'));
    }

    public function community()
    {
        return view('admin.community');
    }

    public function tkpi()
    {
        return view('admin.tkpi');
    }

    public function updateRole(Request $request, string $id)
    {
        $request->validate([
            'role' => 'required|in:user,admin,nutritionist', // Sesuaikan enum di database kamu
        ]);

        // Berdasarkan struktur database kamu, primary key-nya adalah user_id
        $user = User::where('user_id', $id)->firstOrFail(); 
        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'Role pengguna berhasil diperbarui!');
    }

    public function destroyUser(string $id)
    {
        $user = \App\Models\User::where('user_id', $id)->firstOrFail();
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function storeRecipe(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'ingredients' => 'required|array',
            'steps' => 'required|array',
        ]);

        try {
            // 2. Handle Upload Gambar
            $imageUrl = null;
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('recipes', 'public');
                $imageUrl = Storage::url($path);
            }

            // 3. Simpan ke Tabel Recipes (Nama kolom disesuaikan dengan phpMyAdmin)
            Recipe::create([
                'name' => $request->name,
                'category' => $request->category,
                'image_url' => $imageUrl,
                'calories' => $request->calories ?? 0,
                'protein_g' => 0,
                // Menggabungkan array input menjadi satu teks utuh dengan pemisah baris (\n)
                'ingredients' => implode("\n", $request->ingredients),
                'cooking_steps' => implode("\n", $request->steps),
            ]);

            return redirect()->route('admin.recipes')->with('success', 'Resep berhasil ditambahkan!');

        } catch (\Exception $e) {
            // Jika masih gagal, paksa Laravel memunculkan errornya agar kita tahu
            dd('Error: ' . $e->getMessage()); 
        }
    }

    public function recipeDetail(string $id)
    {
        // Mengambil data resep berdasarkan recipe_id
        $recipe = Recipe::where('recipe_id', $id)->firstOrFail();
        
        return view('admin.recipe-detail', compact('recipe'));
    }

    public function destroyRecipe(string $id)
    {
        $recipe = Recipe::where('recipe_id', $id)->firstOrFail();
        
        // Opsional: Hapus gambar dari storage jika ada
        if ($recipe->image_url) {
            $imagePath = str_replace('/storage/', '', $recipe->image_url);
            \Illuminate\Support\Facades\Storage::disk('public')->delete($imagePath);
        }
        
        $recipe->delete();

        return redirect()->route('admin.recipes')->with('success', 'Resep berhasil dihapus secara permanen.');
    }

    public function editRecipe(string $id)
    {
        $recipe = \App\Models\Recipe::where('recipe_id', $id)->firstOrFail();
        return view('admin.recipe-edit', compact('recipe'));
    }

    public function updateRecipe(Request $request, string $id)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'ingredients' => 'required|array',
            'steps' => 'required|array',
        ]);

        try {
            $recipe = \App\Models\Recipe::where('recipe_id', $id)->firstOrFail();
            $imageUrl = $recipe->image_url;

            // 2. Handle Upload Gambar Baru (Jika ada)
            if ($request->hasFile('image')) {
                // Hapus gambar lama dari storage jika ada
                if ($recipe->image_url) {
                    $oldPath = str_replace('/storage/', '', $recipe->image_url);
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
                }
                
                // Simpan gambar baru
                $path = $request->file('image')->store('recipes', 'public');
                $imageUrl = \Illuminate\Support\Facades\Storage::url($path);
            }

            // 3. Update ke Database
            $recipe->update([
                'name' => $request->name,
                'category' => $request->category,
                'image_url' => $imageUrl,
                'calories' => $request->calories ?? 0,
                'ingredients' => implode("\n", $request->ingredients),
                'cooking_steps' => implode("\n", $request->steps),
            ]);

            // Redirect kembali ke halaman detail resep
            return redirect()->route('admin.recipes.detail', $recipe->recipe_id)->with('success', 'Resep berhasil diperbarui!');

        } catch (\Exception $e) {
            dd('Error Update: ' . $e->getMessage()); 
        }
    }
}
