<?php

namespace App\Http\Controllers;

use App\Models\CalorieLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalorieLogController extends Controller
{
    /**
     * [READ] Menampilkan halaman jurnal & riwayat makan (Floating Page)
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        // 1. Ambil riwayat makan user khusus hari ini
        $logs = CalorieLog::where('user_id', $userId)
            ->whereDate('logged_at', now()) 
            ->orderBy('logged_at', 'desc')
            ->get();

        // 2. Hitung total konsumsi untuk ditampilkan di ringkasan atas kartu
        $totalKonsumsi = $logs->sum('calories');
        
        // 3. Ambil target kalori dari profil user (default 2000 jika kosong)
        $target = Auth::user()->profile->daily_calorie_target ?? 2000;

        // Kita tidak butuh $foods lagi karena user ketik manual
        return view('calorie_logs.index', compact('logs', 'totalKonsumsi', 'target'));
    }

    /**
     * [CREATE] Menambahkan catatan kalori secara manual
     */
    public function store(Request $request)
    {
        // Validasi input manual: Nama makanan, Kalori, dan Waktu makan
        $request->validate([
            'meal_name' => 'required|string|max:255',
            'calories'  => 'required|integer|min:1',
            'meal_time' => 'required|in:Sarapan,Makan Siang,Makan Malam,Camilan',
            'logged_at' => 'nullable|date',
        ]);

        // Simpan data langsung apa adanya sesuai yang diketik user
        CalorieLog::create([
            'user_id'   => Auth::id(),
            'meal_name' => $request->meal_name,
            'calories'  => $request->calories,
            'meal_time' => $request->meal_time,
            'logged_at' => $request->logged_at ?? now(),
            // Kolom gizi lainnya (protein, fat, carbs) akan bernilai null/0 
            // kecuali kamu ingin menambah inputnya juga di UI.
        ]);

        return redirect()->route('dashboard')
                         ->with('success', 'Menu ' . $request->meal_name . ' berhasil dicatat!');
    }

    /**
     * [DELETE] Menghapus catatan jika ada yang salah input
     */
    public function destroy(string $id)
    {
        $log = CalorieLog::findOrFail($id);

        if ($log->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $log->delete();

        return back()->with('success', 'Catatan makan berhasil dihapus.');
    }

    /**
     * --- FUNGSI PEMBANTU ---
     * Digunakan di dashboard untuk kalkulasi progress bar
     */
    public static function getTodaySummary()
    {
        if (!Auth::check()) return null;

        return CalorieLog::where('user_id', Auth::id())
            ->whereDate('logged_at', now())
            ->selectRaw('SUM(calories) as total_calories')
            ->first();
    }
}