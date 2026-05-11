<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Wajib untuk membaca Session user yang login

class UserProfileController extends Controller
{
    // =========================================================================
    // BAGIAN ADMIN (MENGELOLA SEMUA PROFIL)
    // =========================================================================

    /**
     * [READ] Menampilkan semua profil beserta relasi data user-nya (Untuk Admin)
     */
    public function index()
    {
        $profiles = UserProfile::with('user')->get();
        return view('user_profiles.index', compact('profiles'));
    }

    /**
     * TAMPILAN FORM TAMBAH (Oleh Admin)
     */
    public function create()
    {
        return view('user_profiles.create');
    }

    /**
     * [CREATE] Menyimpan profil baru secara manual (Oleh Admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            // Tambahkan validasi unique agar Admin tidak sengaja bikin 2 profil untuk 1 user
            'user_id'              => 'required|exists:users,user_id|unique:user_profiles,user_id', 
            'health_condition'     => 'nullable|string',
            'daily_calorie_target' => 'required|integer',
            'age'                  => 'required|integer',
            'weight_kg'            => 'required|numeric',
        ]);

        UserProfile::create($request->all());

        return redirect()->route('user_profiles.index')
                         ->with('success', 'Profil pengguna berhasil ditambahkan!');
    }

    /**
     * [READ] Menampilkan detail satu profil
     */
    public function show(string $id)
    {
        $profile = UserProfile::with('user')->findOrFail($id);
        return view('user_profiles.show', compact('profile'));
    }

    /**
     * TAMPILAN FORM EDIT (Oleh Admin)
     */
    public function edit(string $id)
    {
        $profile = UserProfile::findOrFail($id);
        return view('user_profiles.edit', compact('profile'));
    }

    /**
     * [UPDATE] Memperbarui profil secara manual berdasarkan profile_id
     */
    public function update(Request $request, string $id)
    {
        $profile = UserProfile::findOrFail($id);

        $request->validate([
            'user_id'              => 'required|exists:users,user_id|unique:user_profiles,user_id,' . $profile->profile_id . ',profile_id',
            'health_condition'     => 'nullable|string',
            'daily_calorie_target' => 'required|integer',
            'age'                  => 'required|integer',
            'weight_kg'            => 'required|numeric',
        ]);

        $profile->update($request->all());

        return redirect()->route('user_profiles.index')
                         ->with('success', 'Profil pengguna berhasil diupdate!');
    }

    /**
     * [DELETE] Menghapus profil
     */
    public function destroy(string $id)
    {
        $profile = UserProfile::findOrFail($id);
        $profile->delete();

        return back()->with('success', 'Profil pengguna berhasil dihapus!');
    }

    // =========================================================================
    // BAGIAN USER (MENGELOLA PROFIL DIRI SENDIRI)
    // =========================================================================

    /**
     * [READ] Menampilkan halaman form profil milik user itu sendiri
     */
    public function editMyProfile()
    {
        $user = Auth::user(); // Ambil identitas user yang sedang login
        
        // Cari profilnya berdasarkan user_id (Bisa null jika user baru daftar dan belum isi profil)
        $profile = UserProfile::where('user_id', $user->user_id)->first();

        // Lempar ke form Blade khusus halaman Profil User
        return view('user_profiles.my_profile', compact('user', 'profile'));
    }

    /**
     * [UPDATE/CREATE] Menyimpan perubahan form dari halaman my_profile
     */
    public function updateMyProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'health_condition'     => 'nullable|string',
            'daily_calorie_target' => 'required|integer',
            'age'                  => 'required|integer',
            'weight_kg'            => 'required|numeric',
        ]);

        // Gunakan updateOrCreate agar kode lebih efisien
        UserProfile::updateOrCreate(
            ['user_id' => $user->user_id], 
            $request->only(['health_condition', 'daily_calorie_target', 'age', 'weight_kg'])
        );

        // Kembalikan user ke form profilnya sambil bawa pesan sukses
        return back()->with('success', 'Profil kesehatan pribadimu berhasil disimpan!');
    }
}