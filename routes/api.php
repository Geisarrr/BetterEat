<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalorieLogController;

// --- API ROUTES UNTUK CALORIE LOGS ---

// 0. [READ] Melihat rekap total gizi harian (GET)
// WAJIB ditaruh di atas /{id} agar tidak terjadi konflik rute
// Cara akses: http://127.0.0.1:8000/api/calorie-logs/summary/daily?user_id=1
Route::get('/calorie-logs/summary/daily', [CalorieLogController::class, 'summary']);

// 1. [READ] Melihat semua riwayat makan (GET)
// Cara akses: http://127.0.0.1:8000/api/calorie-logs?user_id=1
Route::get('/calorie-logs', [CalorieLogController::class, 'index']);

// 2. [CREATE] Menambah catatan kalori baru (POST)
// Cara akses: http://127.0.0.1:8000/api/calorie-logs
Route::post('/calorie-logs', [CalorieLogController::class, 'store']);

// 3. [READ] Melihat detail satu catatan spesifik berdasarkan ID log (GET)
// Cara akses: http://127.0.0.1:8000/api/calorie-logs/1
Route::get('/calorie-logs/{id}', [CalorieLogController::class, 'show']);

// 4. [UPDATE] Mengubah catatan spesifik (PUT / PATCH)
// Cara akses: http://127.0.0.1:8000/api/calorie-logs/1
Route::put('/calorie-logs/{id}', [CalorieLogController::class, 'update']);
Route::patch('/calorie-logs/{id}', [CalorieLogController::class, 'update']); // Sedia payung sebelum hujan, izinkan PATCH juga

// 5. [DELETE] Menghapus catatan spesifik (DELETE)
// Cara akses: http://127.0.0.1:8000/api/calorie-logs/1
Route::delete('/calorie-logs/{id}', [CalorieLogController::class, 'destroy']);