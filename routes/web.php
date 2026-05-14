<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\SavedRecipeController;
use App\Http\Controllers\CalorieLogController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\DiseaseCategoryController;
use App\Http\Controllers\FoodNutritionTkpiController;
use App\Http\Controllers\RecipeIngredientController;
use App\Http\Controllers\RecipeDiseaseCategoryController;
use App\Http\Controllers\CalorieCalculatorController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/resep', [RecipeController::class, 'index'])->name('resep');

Route::get('/kalkulator', [CalorieCalculatorController::class, 'index'])->name('kalkulator');

Route::prefix('kalkulator')->group(function () {
    Route::get('/search',       [CalorieCalculatorController::class, 'search'])      ->name('kalkulator.search');
    Route::get('/alternatives', [CalorieCalculatorController::class, 'alternatives'])->name('kalkulator.alternatives');
});

Route::post('/kalkulator/calculate', [CalorieCalculatorController::class, 'calculate'])->name('kalkulator.calculate');

Route::get('/community', function () {
    return view('community'); 
})->name('community');

// GUEST ROUTES (BISA DIAKSES MESKIPUN BELUM LOGIN)
Route::middleware('guest')->group(function () {
    // Register
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// 2. AUTHENTICATED RULES (WAJIB LOGIN)
Route::middleware('auth')->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard & Profile User
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    Route::get('/my-health-profile', [UserProfileController::class, 'editMyProfile'])->name('my_profile.edit');
    Route::post('/my-health-profile', [UserProfileController::class, 'updateMyProfile'])->name('my_profile.update');

    // Jurnal Kalori
    Route::get('/calorie-logs', [CalorieLogController::class, 'index'])->name('calorie_logs.index');
    Route::post('/calorie-logs', [CalorieLogController::class, 'store'])->name('calorie_logs.store');
    Route::get('/calorie-logs/{id}/edit', [CalorieLogController::class, 'edit'])->name('calorie_logs.edit');
    Route::put('/calorie-logs/{id}', [CalorieLogController::class, 'update'])->name('calorie_logs.update');
    Route::delete('/calorie-logs/{id}', [CalorieLogController::class, 'destroy'])->name('calorie_logs.destroy');
    Route::get('/calorie-summary', [CalorieLogController::class, 'summary'])->name('calorie_logs.summary');

    // Komunitas (Post & Feed)
    Route::get('/posts/category/{category}', [PostController::class, 'getByCategory'])->name('posts.category');
    Route::resource('posts', PostController::class);
    
    // Like & Comment
    Route::post('/posts/{postId}/like', [PostLikeController::class, 'toggle'])->name('post.like');
    Route::resource('comments', CommentController::class)->only(['store', 'edit', 'update', 'destroy']);

    // Resep & Bookmark
    Route::get('/recipes/category/{category}', [RecipeController::class, 'getByCategory'])->name('recipes.category');
    Route::get('/my-saved-recipes', [SavedRecipeController::class, 'index'])->name('saved_recipes.index');
    Route::post('/recipes/{recipe}/toggle-save', [SavedRecipeController::class, 'toggle'])->name('saved_recipes.toggle');
    Route::resource('recipes', RecipeController::class);

    /*
    |--------------------------------------------------------------------------
    | 3. ADMIN AREA (Master Data)
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('user_profiles', UserProfileController::class);
        Route::resource('disease_categories', DiseaseCategoryController::class);
        Route::resource('food_nutrition', FoodNutritionTkpiController::class);
        Route::resource('recipe_ingredients', RecipeIngredientController::class);
        Route::post('/recipe-categories', [RecipeDiseaseCategoryController::class, 'store'])->name('recipe_categories.store');
        Route::delete('/recipe-categories', [RecipeDiseaseCategoryController::class, 'destroy'])->name('recipe_categories.destroy');
    });

});