<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function index()
    {
        // [READ] Menampilkan semua profil beserta relasi data user-nya
        $profiles = UserProfile::with('user')->get();
        return response()->json($profiles);
    }

    public function create()
    {
        // Form HTML
    }

    public function store(Request $request)
    {
        // [CREATE] Menyimpan profil baru
        $request->validate([
            // Wajib diisi dan ID tersebut HARUS ada di tabel users
            'user_id'              => 'required|exists:users,user_id', 
            'health_condition'     => 'nullable|string',
            'daily_calorie_target' => 'required|integer',
            'age'                  => 'required|integer',
            'weight_kg'            => 'required|numeric',
        ]);

        $profile = UserProfile::create($request->all());

        return response()->json([
            'message' => 'Profil pengguna berhasil ditambahkan!',
            'data'    => $profile
        ]);
    }

    public function show(string $id)
    {
        // [READ] Menampilkan detail satu profil beserta relasi data user-nya
        $profile = UserProfile::with('user')->findOrFail($id);
        return response()->json($profile);
    }

    public function edit(string $id)
    {
        // Form HTML
    }

    public function update(Request $request, string $id)
    {
        // [UPDATE] Memperbarui profil
        $profile = UserProfile::findOrFail($id);

        $request->validate([
            'user_id'              => 'sometimes|required|exists:users,user_id',
            'health_condition'     => 'nullable|string',
            'daily_calorie_target' => 'sometimes|required|integer',
            'age'                  => 'sometimes|required|integer',
            'weight_kg'            => 'sometimes|required|numeric',
        ]);

        $profile->update($request->all());

        return response()->json([
            'message' => 'Profil pengguna berhasil diupdate!',
            'data'    => $profile
        ]);
    }

    public function destroy(string $id)
    {
        // [DELETE] Menghapus profil
        $profile = UserProfile::findOrFail($id);
        $profile->delete();

        return response()->json(['message' => 'Profil pengguna berhasil dihapus!']);
    }
}