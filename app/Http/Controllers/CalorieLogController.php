<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Wajib dipanggil untuk Session
use App\Models\CalorieLog;
use Illuminate\Http\Request;

class CalorieLogController extends Controller
{
    /**
     * [READ] Menampilkan riwayat kalori milik user yang sedang login
     */
    public function index(Request $request)
    {
        // Langsung ambil ID dari user yang sedang login di browser
        $userId = Auth::id();

        $logs = CalorieLog::with(['food'])
            ->where('user_id', $userId)
            ->orderBy('logged_at', 'desc')
            ->get();

        // Lempar data ke file resources/views/calorie-logs/index.blade.php
        return view('calorie_logs.index', compact('logs'));
    }

    /**
     * [CREATE] Menambahkan catatan kalori baru dari form
     */
    public function store(Request $request)
    {
        $request->validate([
            // user_id dihapus dari validasi form karena kita ambil langsung dari Auth (lebih aman)
            'food_id'       => 'required|exists:food_nutrition_tkpi,food_id',
            'quantity_gram' => 'required|numeric|min:0.1',
            'logged_at'     => 'nullable|date',
        ]);

        $food = DB::table('food_nutrition_tkpi')->where('food_id', $request->food_id)->first();
        $multiplier = $request->quantity_gram / 100;

        $logData = [
            'user_id'       => Auth::id(), // Ambil ID otomatis
            'food_id'       => $request->food_id,
            'quantity_gram' => $request->quantity_gram,
            'logged_at'     => $request->logged_at ?? now(),
            'calories'      => $food->calories_per_100g * $multiplier,
            'protein_g'     => $food->protein_g * $multiplier,
            'fat_g'         => $food->fat_g * $multiplier,
            'carbs_g'       => $food->carbs_g * $multiplier,
        ];

        CalorieLog::create($logData);

        // Kembalikan user ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Catatan makanan berhasil ditambahkan ke jurnalmu!');
    }

    /**
     * [READ] (Opsional) Menampilkan halaman edit untuk satu log tertentu
     */
    public function edit(string $id)
    {
        $log = CalorieLog::with('food')->findOrFail($id);

        // Keamanan: Cek apakah log ini benar-benar milik user yang sedang login
        if ($log->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Ini bukan catatan Anda.');
        }

        // Lempar ke file resources/views/calorie_logs/edit.blade.php
        return view('calorie_logs.edit', compact('log'));
    }

    /**
     * [UPDATE] Menyimpan perubahan dari form edit
     */
    public function update(Request $request, string $id)
    {
        $log = CalorieLog::findOrFail($id);

        // Keamanan ekstra
        if ($log->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'food_id'       => 'sometimes|required|exists:food_nutrition_tkpi,food_id',
            'quantity_gram' => 'sometimes|required|numeric|min:0.1',
            'logged_at'     => 'sometimes|required|date',
        ]);

        $needsRecalculation = $request->has('food_id') || $request->has('quantity_gram');
        $updateData = $request->only(['food_id', 'quantity_gram', 'logged_at']);

        if ($needsRecalculation) {
            $foodId = $request->food_id ?? $log->food_id;
            $quantity = $request->quantity_gram ?? $log->quantity_gram;

            $food = DB::table('food_nutrition_tkpi')->where('food_id', $foodId)->first();
            $multiplier = $quantity / 100;

            $updateData['calories']  = $food->calories_per_100g * $multiplier;
            $updateData['protein_g'] = $food->protein_g * $multiplier;
            $updateData['fat_g']     = $food->fat_g * $multiplier;
            $updateData['carbs_g']   = $food->carbs_g * $multiplier;
        }

        $log->update($updateData);

        // Redirect ke halaman index setelah selesai update
        return redirect()->route('calorie_logs.index')->with('success', 'Catatan kalori berhasil diperbarui!');
    }

    /**
     * [DELETE] Menghapus catatan kalori lewat tombol hapus
     */
    public function destroy(string $id)
    {
        $log = CalorieLog::findOrFail($id);

        // Keamanan ekstra
        if ($log->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $log->delete();

        return back()->with('success', 'Catatan kalori berhasil dihapus!');
    }

    /**
     * --- FITUR BARU: REKAP HARIAN ---
     * Sangat cocok ditaruh di Dashboard user!
     */
    public function summary(Request $request)
    {
        $userId = Auth::id(); // Langsung ambil dari session
        $date = $request->query('date', now()->toDateString()); 

        $totals = CalorieLog::where('user_id', $userId)
                    ->whereDate('logged_at', $date)
                    ->selectRaw('
                        SUM(calories) as total_calories,
                        SUM(protein_g) as total_protein,
                        SUM(fat_g) as total_fat,
                        SUM(carbs_g) as total_carbs
                    ')
                    ->first();

        $logs = CalorieLog::with(['food'])
                    ->where('user_id', $userId)
                    ->whereDate('logged_at', $date)
                    ->orderBy('logged_at', 'desc')
                    ->get();

        // Lempar data summary ini ke view (misal ke dashboard utama)
        return view('calorie_logs.summary', compact('date', 'totals', 'logs'));
    }
}