<?php

namespace App\Http\Controllers;

use App\Models\CalorieLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalorieLogController extends Controller
{
    /**
     * [READ] Menampilkan halaman form tambah menu & riwayat hari ini
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Query pakai logged_at (sesuai kolom di migration)
        $logs = CalorieLog::where('user_id', $userId)
            ->whereDate('logged_at', now())
            ->orderBy('logged_at', 'desc')
            ->get();

        $totalKonsumsi = $logs->sum('calories');
        $target = Auth::user()->profile->daily_calorie_target ?? 2000;

        return view('calorie_logs.index', compact('logs', 'totalKonsumsi', 'target'));
    }

    /**
     * [CREATE] Menyimpan catatan kalori input manual
     */
    public function store(Request $request)
    {
        $request->validate([
            'meal_name' => 'required|string|max:255',
            'calories'  => 'required|integer|min:1',
            'meal_time' => 'required|in:Sarapan,Makan Siang,Makan Malam,Camilan',
            'logged_at' => 'nullable|date',
        ]);

        CalorieLog::create([
            'user_id'       => Auth::id(),
            'meal_name'     => $request->meal_name,
            'calories'      => $request->calories,
            'meal_time'     => $request->meal_time,
            'logged_at'     => $request->logged_at ?? now(),
            'food_id'       => null,
            'quantity_gram' => null,
            'protein_g'     => 0,
            'fat_g'         => 0,
            'carbs_g'       => 0,
        ]);

        return redirect()->route('dashboard')
                         ->with('success', 'Menu ' . $request->meal_name . ' berhasil dicatat!');
    }

    /**
     * [DELETE] Menghapus catatan makan
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
     * Helper untuk kalkulasi dashboard
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