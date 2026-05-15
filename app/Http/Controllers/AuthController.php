<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile; // Tambahkan ini agar bisa membuat profil otomatis
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register'); 
    }

    /**
     * FUNGSI REGISTER
     */
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username'  => 'required|string|max:255|unique:users,username',
            'email'     => 'required|string|email|max:255|unique:users,email',
            'password'  => 'required|string|min:8|confirmed', 
        ]);

        // 1. Simpan data user ke tabel 'users'
        $user = User::create([
            'full_name'     => $request->full_name,
            'username'      => $request->username,
            'email'         => $request->email,
            'password_hash' => Hash::make($request->password), 
            'role'          => 'user',
            'profile_photo' => null, 
        ]);

        // 2. KUNCI: Buatkan profil kosong otomatis di tabel 'user_profiles'
        // Ini biar Auth::user()->profile di Dashboard nggak error null
        UserProfile::create([
            'user_id' => $user->user_id, // Primary key user kamu
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')
                ->with('success', 'Registrasi berhasil! Selamat datang di BetterEat.');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * FUNGSI LOGIN
     */
    public function login(Request $request)
    {
        $loginInput = $request->input('email');
        
        // Logika pintar: Cek apakah yang diinput email atau username
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $loginInput,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Langsung arahkan ke dashboard (melupakan pepes ikan)
            if (Auth::user()->role === 'admin') {
                // Jika admin, lempar ke dashboard admin
                return redirect()->route('admin.dashboard'); 
            } else {
                // Jika user biasa, lempar ke dashboard user
                return redirect()->route('dashboard')
                            ->with('success', 'Login berhasil! Siap pantau nutrisi hari ini?');
            }
            
        }

        return back()->withErrors([
            'email' => 'Email/Username atau Password salah!',
        ])->onlyInput('email');
    }

    /**
     * FUNGSI LOGOUT
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke Landing Page
        return redirect()->route('home')->with('success', 'Logout berhasil. Jaga pola makanmu ya!');
    }
}