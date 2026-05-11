<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\CalorieLog;
use Illuminate\Http\Request;

class CalorieLogController extends Controller
{
    public function index(Request $request)
    {
        // [READ] Menampilkan log kalori, difilter berdasarkan user_id jika ada
        $userId = $request->query('user_id');

        $query = CalorieLog::with(['food']);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        // Urutkan dari yang paling baru dimakan
        $logs = $query->orderBy('logged_at', 'desc')->get();

        return response()->json([
            'message'    => 'Riwayat kalori berhasil diambil',
            'total_logs' => $logs->count(),
            'data'       => $logs
        ]);
    }

    public function store(Request $request)
    {
        // [CREATE] Menambahkan log baru
        $request->validate([
            'user_id'       => 'required|exists:users,user_id', 
            'food_id'       => 'required|exists:food_nutrition_tkpi,food_id',
            'quantity_gram' => 'required|numeric|min:0.1',
            'logged_at'     => 'nullable|date',
        ]);

        $food = DB::table('food_nutrition_tkpi')->where('food_id', $request->food_id)->first();
        $multiplier = $request->quantity_gram / 100;

        $logData = [
            'user_id'       => $request->user_id,
            'food_id'       => $request->food_id,
            'quantity_gram' => $request->quantity_gram,
            'logged_at'     => $request->logged_at ?? now(),
            'calories'      => $food->calories_per_100g * $multiplier,
            'protein_g'     => $food->protein_g * $multiplier,
            'fat_g'         => $food->fat_g * $multiplier,
            'carbs_g'       => $food->carbs_g * $multiplier,
        ];

        $log = CalorieLog::create($logData);

        return response()->json([
            'message' => 'Catatan kalori dan nutrisi berhasil dihitung & ditambahkan!',
            'data'    => $log
        ], 201);
    }

    public function show(string $id)
    {
        // [READ] Menampilkan satu catatan spesifik
        $log = CalorieLog::with(['user:user_id,full_name', 'food'])->findOrFail($id);
        return response()->json($log);
    }

    public function update(Request $request, string $id)
    {
        // [UPDATE] Mengubah catatan dan MENGHITUNG ULANG NUTRISI jika beratnya diganti
        $log = CalorieLog::findOrFail($id);

        $request->validate([
            'food_id'       => 'sometimes|required|exists:food_nutrition_tkpi,food_id',
            'quantity_gram' => 'sometimes|required|numeric|min:0.1',
            'logged_at'     => 'sometimes|required|date',
        ]);

        // Cek apakah user mengubah jenis makanan atau berat gram-nya
        $needsRecalculation = $request->has('food_id') || $request->has('quantity_gram');

        // Siapkan data yang akan di-update
        $updateData = $request->only(['food_id', 'quantity_gram', 'logged_at']);

        if ($needsRecalculation) {
            // Gunakan data baru dari request, atau pakai data lama jika tidak diubah
            $foodId = $request->food_id ?? $log->food_id;
            $quantity = $request->quantity_gram ?? $log->quantity_gram;

            $food = DB::table('food_nutrition_tkpi')->where('food_id', $foodId)->first();
            $multiplier = $quantity / 100;

            // Hitung ulang gizinya
            $updateData['calories']  = $food->calories_per_100g * $multiplier;
            $updateData['protein_g'] = $food->protein_g * $multiplier;
            $updateData['fat_g']     = $food->fat_g * $multiplier;
            $updateData['carbs_g']   = $food->carbs_g * $multiplier;
        }

        $log->update($updateData);

        return response()->json([
            'message' => 'Catatan kalori berhasil diperbarui dan dihitung ulang!',
            'data'    => $log
        ]);
    }

    public function destroy(string $id)
    {
        // [DELETE] Menghapus catatan kalori
        $log = CalorieLog::findOrFail($id);
        $log->delete();

        return response()->json(['message' => 'Catatan kalori berhasil dihapus!']);
    }

    // --- FITUR BARU: REKAP HARIAN ---
    public function summary(Request $request)
    {
        // [READ] Menampilkan rekap total gizi harian user
        $userId = $request->query('user_id');
        
        // Ambil tanggal dari parameter, kalau kosong otomatis pakai tanggal hari ini
        $date = $request->query('date', now()->toDateString()); 

        if (!$userId) {
            return response()->json(['message' => 'User ID diperlukan'], 400);
        }

        // Query menjumlahkan semua kolom gizi di hari tersebut
        $totals = CalorieLog::where('user_id', $userId)
                    ->whereDate('logged_at', $date)
                    ->selectRaw('
                        SUM(calories) as total_calories,
                        SUM(protein_g) as total_protein,
                        SUM(fat_g) as total_fat,
                        SUM(carbs_g) as total_carbs
                    ')
                    ->first();

        // Ambil daftar log makanannya sebagai rincian
        $logs = CalorieLog::with(['food'])
                    ->where('user_id', $userId)
                    ->whereDate('logged_at', $date)
                    ->orderBy('logged_at', 'desc')
                    ->get();

        return response()->json([
            'message' => "Ringkasan gizi untuk tanggal {$date}",
            'date'    => $date,
            'summary' => [
                'total_calories' => $totals->total_calories ?? 0,
                'total_protein'  => $totals->total_protein ?? 0,
                'total_fat'      => $totals->total_fat ?? 0,
                'total_carbs'    => $totals->total_carbs ?? 0,
            ],
            'detail_logs' => $logs
        ]);
    }
}