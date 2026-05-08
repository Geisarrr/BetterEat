<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * 1. FUNGSI REGISTER (DAFTAR AKUN BARU)
     */
    public function register(Request $request)
    {
        // Validasi input dari frontend
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username'  => 'required|string|max:255|unique:users,username',
            'email'     => 'required|string|email|max:255|unique:users,email',
            // 'confirmed' mengharuskan frontend mengirim input 'password_confirmation' yang isinya sama
            'password'  => 'required|string|min:8|confirmed', 
        ]);

        // Simpan data user baru ke database
        $user = User::create([
            'full_name'     => $request->full_name,
            'username'      => $request->username,
            'email'         => $request->email,
            'password_hash' => Hash::make($request->password), // Enkripsi password
            'role'          => 'user', // Set default role sebagai user
        ]);

        // Buat kunci akses (Token API) via Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'      => 'Registrasi berhasil!',
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'         => $user
        ], 201); // 201 adalah status HTTP untuk "Created"
    }

    /**
     * 2. FUNGSI LOGIN (MASUK AKUN)
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Cek kecocokan email dan hash password
        if (!$user || !Hash::check($request->password, $user->password_hash)) {
            return response()->json([
                'message' => 'Email atau Password salah!'
            ], 401); // 401 adalah status HTTP untuk "Unauthorized"
        }

        // Hapus token lama jika ada (opsional, jika ingin 1 akun 1 device aktif)
        // $user->tokens()->delete(); 

        // Buat token baru
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'      => 'Login berhasil!',
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'         => $user
        ]);
    }

    /**
     * 3. FUNGSI LOGOUT (KELUAR AKUN)
     */
    public function logout(Request $request)
    {
        // Hapus token yang sedang digunakan saat request ini terjadi
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil!'
        ]);
    }
}