<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    // =========================================================================
    // BAGIAN ADMIN (Tetap Dipertahankan)
    // =========================================================================

    public function index()
    {
        $profiles = UserProfile::with('user')->get();
        return view('user_profiles.index', compact('profiles'));
    }

    // ... (Fungsi create, store, show, edit, update, destroy admin lainnya bisa tetap sama)

    // =========================================================================
    // BAGIAN USER (UPDATE TERBARU - DUAL TABLE UPDATE)
    // =========================================================================

    /**
     * TAMPILAN FORM EDIT PROFIL (Untuk User)
     */
    public function editMyProfile()
    {
        $user = Auth::user(); 
        
        // Pastikan kita mengambil profilnya juga
        // Jika belum ada profil, kita kirim objek kosong agar tidak error di Blade
        $profile = $user->profile ?? new UserProfile();

        // Diarahkan ke folder resources/views/profile/edit.blade.php sesuai diskusi
        return view('profile.edit', compact('user', 'profile'));
    }

    /**
     * UPDATE PROFIL & USER (Simpan Perubahan)
     */
    public function updateMyProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'full_name'            => 'required|string|max:255',
            'username'             => 'required|string|max:255|unique:users,username,' . $user->user_id . ',user_id',
            'email'                => 'required|string|email|max:255|unique:users,email,' . $user->user_id . ',user_id',
            'health_condition'     => 'nullable|string|max:255',
            'age'                  => 'required|integer|min:1',
            'weight_kg'            => 'required|numeric|min:1', // Ubah jadi REQUIRED
            'daily_calorie_target' => 'nullable|numeric',
        ]);

        // Update Tabel Users
        $user->update([
            'full_name' => $request->full_name,
            'username'  => $request->username,
            'email'     => $request->email,
        ]);

        // Update Tabel UserProfiles
        $user->profile()->updateOrCreate(
            ['user_id' => $user->user_id],
            [
                'health_condition'     => $request->health_condition,
                'age'                  => $request->age,
                'weight_kg'            => $request->weight_kg, // Sekarang ada isinya
                'daily_calorie_target' => $request->daily_calorie_target,
            ]
        );

        return redirect()->route('dashboard')->with('success', 'Profil berhasil diperbarui!');
    }
}