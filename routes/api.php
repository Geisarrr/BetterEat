<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalorieLogController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| BetterEat API Routes
|--------------------------------------------------------------------------
*/

// --- 1. MODUL RECIPES (Rekomendasi Makanan Inklusif) ---
// Note: Route kategori ditaruh di atas agar tidak dianggap sebagai ID
Route::get('/recipes/category/{category}', [RecipeController::class, 'getByCategory']);
Route::apiResource('recipes', RecipeController::class);


// --- 2. MODUL POSTS (Komunitas Sehat) ---
// Note: Filter postingan berdasarkan kategori (Diabetes, Fitness, dll)
Route::get('/posts/category/{categoryId}', [PostController::class, 'getByCategory']);
Route::apiResource('posts', PostController::class);


// --- 3. MODUL CALORIE LOGS (Catatan Harian User) ---

// [READ] Rekap harian gizi (Total Kalori, Gula, Protein hari ini)
Route::get('/calorie-logs/summary/daily', [CalorieLogController::class, 'summary']);

// Standard CRUD untuk Calorie Logs
Route::get('/calorie-logs', [CalorieLogController::class, 'index']);
Route::post('/calorie-logs', [CalorieLogController::class, 'store']);
Route::get('/calorie-logs/{id}', [CalorieLogController::class, 'show']);
Route::put('/calorie-logs/{id}', [CalorieLogController::class, 'update']);
Route::patch('/calorie-logs/{id}', [CalorieLogController::class, 'update']);
Route::delete('/calorie-logs/{id}', [CalorieLogController::class, 'destroy']);


// --- 4. MODUL USER (Opsional untuk testing) ---
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');