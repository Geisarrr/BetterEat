<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * [READ] Menampilkan halaman daftar semua user (Khusus Admin)
     */
    public function index()
    {
        // latest() agar user yang baru daftar muncul paling atas
        $users = User::latest()->get(); 
        
        // Melempar data ke resources/views/users/index.blade.php
        return view('users.index', compact('users'));
    }

    /**
     * TAMPILAN FORM TAMBAH USER (Oleh Admin)
     */
    public function create()
    {
        // Melempar ke resources/views/users/create.blade.php
        return view('users.create');
    }

    /**
     * [CREATE] Menyimpan data user/admin baru dari form panel admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username'  => 'required|string|unique:users,username',
            'email'     => 'required|string|email|unique:users,email',
            'password'  => 'required|string|min:8',
            'role'      => 'required|in:user,admin', // Tambahan: Biar admin bisa nentuin dia bikin akun 'user' atau 'admin'
        ]);

        User::create([
            'full_name'     => $request->full_name,
            'username'      => $request->username,
            'email'         => $request->email,
            'password_hash' => Hash::make($request->password), // Sesuaikan dengan kolom databasemu
            'role'          => $request->role, 
        ]);

        return redirect()->route('users.index')
                         ->with('success', 'Akun pengguna berhasil ditambahkan!');
    }

    /**
     * [READ] Menampilkan detail spesifik satu user
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        
        return view('users.show', compact('user'));
    }

    /**
     * TAMPILAN FORM EDIT USER (Oleh Admin)
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        
        return view('users.edit', compact('user'));
    }

    /**
     * [UPDATE] Logika untuk memperbarui data user dari panel admin
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            // Pengecualian unique ID agar admin bisa simpan form tanpa error "email sudah dipakai"
            'username'  => 'required|string|unique:users,username,' . $id . ',user_id',
            'email'     => 'required|string|email|unique:users,email,' . $id . ',user_id',
            'password'  => 'nullable|string|min:8', // Opsional, hanya diisi kalau admin mau reset password user
            'role'      => 'required|in:user,admin',
        ]);

        // Siapkan data yang pasti diupdate
        $updateData = [
            'full_name' => $request->full_name,
            'username'  => $request->username,
            'email'     => $request->email,
            'role'      => $request->role,
        ];

        // Update password_hash HANYA jika form password tidak dikosongkan
        if ($request->filled('password')) {
            $updateData['password_hash'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('users.index')
                         ->with('success', 'Data pengguna berhasil diperbarui!');
    }

    /**
     * [DELETE] Menghapus akun user (Banned / Hapus Permanen)
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        return back()->with('success', 'Akun pengguna berhasil dihapus!');
    }
}