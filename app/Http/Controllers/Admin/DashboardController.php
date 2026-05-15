<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function recipes()
    {
        return view('admin.recipes');
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
}
