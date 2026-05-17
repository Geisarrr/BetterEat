<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Recipe;
use App\Models\FoodNutritionTkpi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    //
    public function index()
    {
        // Statistik dasar
        $totalUsers = \App\Models\User::count();
        $totalRecipes = \App\Models\Recipe::count();
        $totalPosts = \App\Models\Post::count();
        $totalTkpi = \App\Models\FoodNutritionTkpi::count();

        // Menghitung User Aktif (yang ada di tabel sessions dalam 7 hari terakhir)
        // last_activity biasanya disimpan dalam format unix timestamp
        $oneWeekAgo = now()->subDays(7)->timestamp;
        $activeUsersCount = \DB::table('sessions')
            ->where('last_activity', '>=', $oneWeekAgo)
            ->count();

        $reportedPosts = \App\Models\Post::where('is_moderated', 1)->count();
        $latestRecipes = \App\Models\Recipe::orderBy('created_at', 'desc')->take(3)->get();

        $days = [];
        $sessionCounts = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $days[] = $date->format('D'); // Contoh: Sen, Sel, Rab

            // Hitung jumlah session pada hari tersebut
            $startOfDay = $date->copy()->startOfDay()->timestamp;
            $endOfDay = $date->copy()->endOfDay()->timestamp;

            $count = \DB::table('sessions')
                ->whereBetween('last_activity', [$startOfDay, $endOfDay])
                ->count();
            
            $sessionCounts[] = $count;
        }

        return view('admin.dashboard', compact(
            'totalUsers', 'totalRecipes', 'totalPosts', 'totalTkpi', 
            'reportedPosts', 'latestRecipes', 'activeUsersCount',
            'days', 'sessionCounts' // Data untuk grafik
        ));
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

    public function community(Request $request)
    {
        // Menggunakan eager loading (with) agar query lebih ringan saat menarik data user
        $query = \App\Models\Post::with('user');
        $categories = \App\Models\DiseaseCategory::all();

        // 1. Filter Pencarian (Judul Postingan atau Nama Penulis)
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                // Membaca relasi ke tabel users untuk mencari nama
                ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                    $userQuery->where('full_name', 'like', '%' . $searchTerm . '%');
                });
            });
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // 2. Filter Status Moderasi
        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'aman') {
                $query->where('is_moderated', 0); // Asumsi 0 = aman/belum dimoderasi
            } elseif ($request->status == 'dilaporkan') {
                $query->where('is_moderated', 1); // Asumsi 1 = sedang/sudah dimoderasi (dilaporkan)
            }
        }

        // Urutkan dari yang terbaru dan Pagination
        $posts = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.community', compact('posts', 'categories'));
    }

    public function tkpi(Request $request)
    {
        $query = FoodNutritionTkpi::query();

        // Logika Search Bar berdasarkan nama makanan/bahan
        if ($request->has('search') && $request->search != '') {
            $query->where('food_name', 'like', '%' . $request->search . '%');
        }

        // Mengambil data dengan pagination (10 data per halaman)
        $foods = $query->paginate(10)->withQueryString();

        return view('admin.tkpi', compact('foods'));
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

    // 1. Menampilkan Form Create dengan Data TKPI
    public function createRecipe()
    {
        $foods = \App\Models\FoodNutritionTkpi::orderBy('food_name', 'asc')->get();
        return view('admin.recipe-create', compact('foods'));
    }

    // 2. Proses Simpan & Auto-Calculate
    public function storeRecipe(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'ingredient_ids' => 'required|array',
            'quantities' => 'required|array',
            'steps' => 'required|array',
        ]);

        try {
            // Handle Gambar
            $imageUrl = null;
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('recipes', 'public');
                $imageUrl = \Illuminate\Support\Facades\Storage::url($path);
            }

            // Variabel penampung kalkulator gizi
            $totalCalories = 0;
            $totalProtein = 0;
            $totalFat = 0;
            $totalCarbs = 0;
            $totalSugar = 0;
            $totalFiber = 0;
            $ingredientsTextArray = [];

            // Perhitungan Gizi Otomatis berdasarkan pilihan TKPI dan Gram
            foreach ($request->ingredient_ids as $index => $foodId) {
                $quantity = $request->quantities[$index] ?? 0;
                
                if ($quantity > 0) {
                    $food = \App\Models\FoodNutritionTkpi::find($foodId);
                    if ($food) {
                        $factor = $quantity / 100; // Karena standar TKPI adalah per 100g
                        
                        $totalCalories += ($food->calories_per_100g ?? 0) * $factor;
                        $totalProtein += ($food->protein_g ?? 0) * $factor;
                        $totalFat += ($food->fat_g ?? 0) * $factor;
                        $totalCarbs += ($food->carbs_g ?? 0) * $factor;
                        $totalSugar += ($food->sugar_g ?? 0) * $factor;
                        $totalFiber += ($food->fiber_g ?? 0) * $factor;

                        // Menyusun teks otomatis agar halaman detail tidak rusak
                        $ingredientsTextArray[] = $quantity . "g " . $food->food_name;
                    }
                }
            }

            // Simpan Data Ke Database dengan nilai hasil kalkulasi otomatis
            \App\Models\Recipe::create([
                'name' => $request->name,
                'category' => $request->category,
                'image_url' => $imageUrl,
                'calories' => $totalCalories,
                'protein_g' => $totalProtein,
                'fat_g' => $totalFat,
                'carbs_g' => $totalCarbs,
                'sugar_g' => $totalSugar,
                'fiber_g' => $totalFiber,
                'ingredients' => implode("\n", $ingredientsTextArray),
                'cooking_steps' => implode("\n", $request->steps),
            ]);

            return redirect()->route('admin.recipes')->with('success', 'Resep berhasil dihitung dan ditambahkan!');

        } catch (\Exception $e) {
            dd('Error Store: ' . $e->getMessage());
        }
    }

    // 3. Menampilkan Form Edit dengan Data TKPI
    public function editRecipe(string $id)
    {
        $recipe = \App\Models\Recipe::where('recipe_id', $id)->firstOrFail();
        $foods = \App\Models\FoodNutritionTkpi::orderBy('food_name', 'asc')->get();
        return view('admin.recipe-edit', compact('recipe', 'foods'));
    }

    // 4. Proses Update & Re-Calculate
    public function updateRecipe(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'ingredient_ids' => 'required|array',
            'quantities' => 'required|array',
            'steps' => 'required|array',
        ]);

        try {
            $recipe = \App\Models\Recipe::where('recipe_id', $id)->firstOrFail();
            $imageUrl = $recipe->image_url;

            if ($request->hasFile('image')) {
                if ($recipe->image_url) {
                    $oldPath = str_replace('/storage/', '', $recipe->image_url);
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
                }
                $path = $request->file('image')->store('recipes', 'public');
                $imageUrl = \Illuminate\Support\Facades\Storage::url($path);
            }

            $totalCalories = 0;
            $totalProtein = 0;
            $totalFat = 0;
            $totalCarbs = 0;
            $totalSugar = 0;
            $totalFiber = 0;
            $ingredientsTextArray = [];

            foreach ($request->ingredient_ids as $index => $foodId) {
                $quantity = $request->quantities[$index] ?? 0;
                
                if ($quantity > 0) {
                    $food = \App\Models\FoodNutritionTkpi::find($foodId);
                    if ($food) {
                        $factor = $quantity / 100;
                        
                        $totalCalories += ($food->calories_per_100g ?? 0) * $factor;
                        $totalProtein += ($food->protein_g ?? 0) * $factor;
                        $totalFat += ($food->fat_g ?? 0) * $factor;
                        $totalCarbs += ($food->carbs_g ?? 0) * $factor;
                        $totalSugar += ($food->sugar_g ?? 0) * $factor;
                        $totalFiber += ($food->fiber_g ?? 0) * $factor;

                        $ingredientsTextArray[] = $quantity . "g " . $food->food_name;
                    }
                }
            }

            $recipe->update([
                'name' => $request->name,
                'category' => $request->category,
                'image_url' => $imageUrl,
                'calories' => $totalCalories,
                'protein_g' => $totalProtein,
                'fat_g' => $totalFat,
                'carbs_g' => $totalCarbs,
                'sugar_g' => $totalSugar,
                'fiber_g' => $totalFiber,
                'ingredients' => implode("\n", $ingredientsTextArray),
                'cooking_steps' => implode("\n", $request->steps),
            ]);

            return redirect()->route('admin.recipes.detail', $recipe->recipe_id)->with('success', 'Nutrisi resep berhasil diperbarui!');

        } catch (\Exception $e) {
            dd('Error Update: ' . $e->getMessage());
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

    public function storeTkpi(Request $request)
    {
        // Validasi input
        $request->validate([
            'food_name' => 'required|string|max:255',
            'calories_per_100g' => 'required|numeric|min:0',
            'protein_g' => 'required|numeric|min:0',
            'fat_g' => 'required|numeric|min:0',
            'carbs_g' => 'required|numeric|min:0',
            'sugar_g' => 'required|numeric|min:0',
            'fiber_g' => 'required|numeric|min:0',
        ]);

        try {
            // Simpan ke database
            FoodNutritionTkpi::create([
                'food_name' => $request->food_name,
                'calories_per_100g' => $request->calories_per_100g,
                'protein_g' => $request->protein_g,
                'fat_g' => $request->fat_g,
                'carbs_g' => $request->carbs_g,
                'sugar_g' => $request->sugar_g,
                'fiber_g' => $request->fiber_g,
            ]);

            return redirect()->route('admin.tkpi')->with('success', 'Data pangan berhasil ditambahkan!');

        } catch (\Exception $e) {
            dd('Error: ' . $e->getMessage()); 
        }
    }

    // Menampilkan halaman edit TKPI
    public function editTkpi(string $id)
    {
        $food = \App\Models\FoodNutritionTkpi::where('food_id', $id)->firstOrFail();
        return view('admin.tkpi-edit', compact('food'));
    }

    // Memproses perubahan data TKPI
    public function updateTkpi(Request $request, string $id)
    {
        $request->validate([
            'food_name' => 'required|string|max:255',
            'calories_per_100g' => 'required|numeric|min:0',
            'protein_g' => 'required|numeric|min:0',
            'fat_g' => 'required|numeric|min:0',
            'carbs_g' => 'required|numeric|min:0',
            'sugar_g' => 'required|numeric|min:0',
            'fiber_g' => 'required|numeric|min:0',
        ]);

        try {
            $food = \App\Models\FoodNutritionTkpi::where('food_id', $id)->firstOrFail();
            $food->update([
                'food_name' => $request->food_name,
                'calories_per_100g' => $request->calories_per_100g,
                'protein_g' => $request->protein_g,
                'fat_g' => $request->fat_g,
                'carbs_g' => $request->carbs_g,
                'sugar_g' => $request->sugar_g,
                'fiber_g' => $request->fiber_g,
            ]);

            return redirect()->route('admin.tkpi')->with('success', 'Data pangan berhasil diperbarui!');
        } catch (\Exception $e) {
            dd('Error Update: ' . $e->getMessage());
        }
    }

    // Menghapus data TKPI
    public function deleteTkpi(string $id)
    {
        try {
            $food = \App\Models\FoodNutritionTkpi::where('food_id', $id)->firstOrFail();
            $food->delete();
            return redirect()->route('admin.tkpi')->with('success', 'Data pangan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.tkpi')->with('error', 'Gagal menghapus data. Pastikan bahan ini tidak sedang digunakan di dalam resep.');
        }
    }

    // Fungsi untuk menampilkan halaman Detail
    public function communityDetail(string $id)
    {
        // Ambil data post beserta relasi user, category, dan comments
        $post = \App\Models\Post::with(['user', 'category', 'comments.user'])->where('post_id', $id)->firstOrFail();
        
        return view('admin.community-detail', compact('post'));
    }

    // Fungsi untuk menghapus Postingan
    public function deletePost(string $id)
    {
        try {
            $post = \App\Models\Post::where('post_id', $id)->firstOrFail();
            
            // Hapus gambar dari storage jika ada
            if ($post->image_url) {
                $imagePath = str_replace('/storage/', '', $post->image_url);
                \Illuminate\Support\Facades\Storage::disk('public')->delete($imagePath);
            }
            
            // Hapus postingan (komentar terkait otomatis terhapus jika pakai cascade on delete di DB)
            $post->delete();

            return redirect()->route('admin.community')->with('success', 'Postingan berhasil dihapus beserta fotonya.');
        } catch (\Exception $e) {
            return redirect()->route('admin.community')->with('error', 'Gagal menghapus postingan: ' . $e->getMessage());
        }
    }

    // Menghapus Komentar Spesifik
    public function deleteComment(string $id)
    {
        try {
            // Asumsi primary key tabel comments adalah 'comment_id' sesuai seeder
            $comment = \App\Models\Comment::where('comment_id', $id)->firstOrFail();
            $comment->delete();
            
            return back()->with('success', 'Komentar berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus komentar: ' . $e->getMessage());
        }
    }

    // Fungsi untuk menandai postingan kembali aman
    public function approvePost(string $id)
    {
        try {
            $post = \App\Models\Post::where('post_id', $id)->firstOrFail();
            
            // Ubah status moderasi kembali menjadi 0 (Aman)
            $post->update(['is_moderated' => 0]);
            
            return redirect()->route('admin.community')->with('success', 'Postingan telah ditandai sebagai aman.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }
}
