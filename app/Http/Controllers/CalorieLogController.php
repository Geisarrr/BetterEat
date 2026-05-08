<?php

namespace App\Http\Controllers;

use App\Models\CalorieLog;
use Illuminate\Http\Request;

class CalorieLogController extends Controller
{
    public function index()
    {
        // [READ] Menampilkan semua log kalori beserta data user dan makanannya
        $logs = CalorieLog::with(['user', 'food'])->get();
        return response()->json($logs);
    }

    public function create()
    {
        // Form HTML
    }

    public function store(Request $request)
    {
        // [CREATE] Mencatat asupan kalori baru
        $request->validate([
            'user_id'       => 'required|exists:users,user_id',
            'food_id'       => 'required|exists:food_nutrition_tkpi,food_id',
            'quantity_gram' => 'required|numeric|min:0.1',
            'logged_at'     => 'nullable|date',
        ]);

        $log = CalorieLog::create($request->all());

        return response()->json([
            'message' => 'Catatan kalori berhasil ditambahkan!',
            'data'    => $log
        ]);
    }

    public function show(string $id)
    {
        // [READ] Menampilkan detail spesifik satu catatan log
        $log = CalorieLog::with(['user', 'food'])->findOrFail($id);
        return response()->json($log);
    }

    public function edit(string $id)
    {
        // Form HTML
    }

    public function update(Request $request, string $id)
    {
        // [UPDATE] Mengubah catatan kalori
        $log = CalorieLog::findOrFail($id);

        $request->validate([
            'user_id'       => 'sometimes|required|exists:users,user_id',
            'food_id'       => 'sometimes|required|exists:food_nutrition_tkpi,food_id',
            'quantity_gram' => 'sometimes|required|numeric|min:0.1',
            'logged_at'     => 'sometimes|required|date',
        ]);

        $log->update($request->all());

        return response()->json([
            'message' => 'Catatan kalori berhasil diperbarui!',
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
}