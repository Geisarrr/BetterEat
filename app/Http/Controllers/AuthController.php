<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Tambahkan ini untuk fungsi session login

class AuthController extends Controller
{
    /**
     * TAMPILAN FORM REGISTER
     * Akan memanggil file resources/views/auth/register.blade.php
     */
    public function showRegisterForm()
    {
        return view('auth.register'); 
    }

    /**
     * 1. FUNGSI REGISTER (ACTION)
     */
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username'  => 'required|string|max:255|unique:users,username',
            'email'     => 'required|string|email|max:255|unique:users,email',
            'password'  => 'required|string|min:8|confirmed', 
        ]);

        $user = User::create([
            'full_name'     => $request->full_name,
            'username'      => $request->username,
            'email'         => $request->email,
            'password_hash' => Hash::make($request->password), 
            'role'          => 'user',
            'profile_photo' => null, 
        ]);

        // Otomatis login-kan user menggunakan Session setelah register berhasil
        Auth::login($user);

        // Redirect ke halaman dashboard (atau halaman lain) dengan pesan sukses
        return redirect()->intended('/dashboard')
                         ->with('success', 'Registrasi berhasil! Selamat datang di BetterEat.');
    }

    /**
     * TAMPILAN FORM LOGIN
     * Akan memanggil file resources/views/auth/login.blade.php
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * 2. FUNGSI LOGIN (ACTION)
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Auth::attempt akan mengecek email dan password, lalu membuat Session jika benar
        // Karena di Model User sudah pakai getAuthPassword(), Laravel otomatis baca kolom 'password_hash'
        if (Auth::attempt($credentials)) {
            // Mencegah serangan Session Fixation
            $request->session()->regenerate();

            return redirect()->intended('/dashboard')
                             ->with('success', 'Login berhasil! Siap pantau nutrisi hari ini?');
        }

        // Jika login gagal, kembalikan user ke halaman form login membawa pesan error
        return back()->withErrors([
            'email' => 'Email atau Password salah!',
        ])->onlyInput('email'); // Mempertahankan isi input email biar gak usah ketik ulang
    }

    /**
     * 3. FUNGSI LOGOUT (ACTION)
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Hapus dan reset sesi demi keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logout berhasil. Jaga pola makanmu ya!');
    }
}