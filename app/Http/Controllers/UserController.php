<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // [READ] Menampilkan semua data user
        $users = User::all();
        return response()->json($users);
    }

    public function create()
    {
        // Menampilkan form tambah user (hanya dipakai jika menggunakan Blade/HTML)
    }

    public function store(Request $request)
    {
        // [CREATE] Menyimpan data user baru ke database
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username'  => 'required|string|unique:users',
            'email'     => 'required|string|email|unique:users',
            'password'  => 'required|string|min:8',
        ]);

        $user = User::create([
            'full_name' => $request->full_name,
            'username'  => $request->username,
            'email'     => $request->email,
            'password'  => Hash::make($request->password), 
            'role'      => 'user', 
        ]);

        return response()->json(['message' => 'User berhasil dibuat!', 'data' => $user]);
    }

    public function show(string $id)
    {
        // [READ] Menampilkan detail spesifik satu user
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function edit(string $id)
    {
        // Menampilkan form edit user (hanya dipakai jika menggunakan Blade/HTML)
    }

    public function update(Request $request, string $id)
    {
        // [UPDATE] Logika untuk memperbarui data user
        $user = User::findOrFail($id);

        // Validasi data yang masuk
        // Catatan: 'user_id' ditambahkan di rule unique agar sistem tahu kolom Primary Key-nya apa
        $request->validate([
            'full_name' => 'sometimes|required|string|max:255',
            'username'  => 'sometimes|required|string|unique:users,username,' . $id . ',user_id',
            'email'     => 'sometimes|required|string|email|unique:users,email,' . $id . ',user_id',
            'password'  => 'sometimes|nullable|string|min:8', // Password opsional saat update
        ]);

        // Update data jika ada perubahan yang dikirim
        if ($request->has('full_name')) $user->full_name = $request->full_name;
        if ($request->has('username')) $user->username = $request->username;
        if ($request->has('email')) $user->email = $request->email;
        
        // Update password hanya jika user mengisi kolom password baru
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json(['message' => 'User berhasil diupdate!', 'data' => $user]);
    }

    public function destroy(string $id)
    {
        // [DELETE] Menghapus user
        $user = User::findOrFail($id);
        $user->delete();
        
        return response()->json(['message' => 'User berhasil dihapus!']);
    }
}