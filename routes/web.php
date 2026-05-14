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

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Resep
Route::get('/resep', [RecipeController::class, 'index'])->name('resep');

// Kalkulator Gizi
Route::get('/kalkulator', [CalorieCalculatorController::class, 'index'])->name('kalkulator');

Route::prefix('kalkulator')->group(function () {

    Route::get('/search', [CalorieCalculatorController::class, 'search'])
        ->name('kalkulator.search');

    Route::get('/alternatives', [CalorieCalculatorController::class, 'alternatives'])
        ->name('kalkulator.alternatives');

    Route::post('/calculate', [CalorieCalculatorController::class, 'calculate'])
        ->name('kalkulator.calculate');
});

// Community
Route::get('/community', function () {
    return view('community');
})->name('community');


/*
|--------------------------------------------------------------------------
| 1. GUEST ROUTES (Hanya bisa diakses jika BELUM login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // Register
    Route::get('/register', [AuthController::class, 'showRegisterForm'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register']);

    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);
});


/*
|--------------------------------------------------------------------------
| 2. AUTHENTICATED ROUTES (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // Dashboard User
    Route::get('/dashboard', function () {
        return view('dashboardUser');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Profile & Health Settings
    |--------------------------------------------------------------------------
    */
    Route::get('/my-health-profile', [UserProfileController::class, 'editMyProfile'])
        ->name('my_profile.edit');

    Route::post('/my-health-profile', [UserProfileController::class, 'updateMyProfile'])
        ->name('my_profile.update');

    /*
    |--------------------------------------------------------------------------
    | Jurnal Kalori
    |--------------------------------------------------------------------------
    */
    Route::prefix('calorie-logs')->group(function () {

        Route::get('/', [CalorieLogController::class, 'index'])
            ->name('calorie_logs.index');

        Route::post('/', [CalorieLogController::class, 'store'])
            ->name('calorie_logs.store');

        Route::get('/{id}/edit', [CalorieLogController::class, 'edit'])
            ->name('calorie_logs.edit');

        Route::put('/{id}', [CalorieLogController::class, 'update'])
            ->name('calorie_logs.update');

        Route::delete('/{id}', [CalorieLogController::class, 'destroy'])
            ->name('calorie_logs.destroy');

        Route::get('/summary', [CalorieLogController::class, 'summary'])
            ->name('calorie_logs.summary');
    });

    /*
    |--------------------------------------------------------------------------
    | Komunitas (Post & Feed)
    |--------------------------------------------------------------------------
    */
    Route::get('/posts/category/{category}', [PostController::class, 'getByCategory'])
        ->name('posts.category');

    Route::resource('posts', PostController::class);

    // Like & Comment
    Route::post('/posts/{postId}/like', [PostLikeController::class, 'toggle'])
        ->name('post.like');

    Route::resource('comments', CommentController::class)
        ->only(['store', 'edit', 'update', 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Resep & Bookmark
    |--------------------------------------------------------------------------
    */
    Route::get('/recipes/category/{category}', [RecipeController::class, 'getByCategory'])
        ->name('recipes.category');

    Route::get('/my-saved-recipes', [SavedRecipeController::class, 'index'])
        ->name('saved_recipes.index');

    Route::post('/recipes/{recipe}/toggle-save', [SavedRecipeController::class, 'toggle'])
        ->name('saved_recipes.toggle');

    Route::resource('recipes', RecipeController::class);

    /*
    |--------------------------------------------------------------------------
    | 3. ADMIN AREA (Master Data)
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->group(function () {

        // User Management
        Route::resource('users', UserController::class);

        // User Profile
        Route::resource('user_profiles', UserProfileController::class);

        // Disease Categories
        Route::resource('disease_categories', DiseaseCategoryController::class);

        // TKPI Nutrition Data
        Route::resource('food_nutrition', FoodNutritionTkpiController::class);

        // Recipe Ingredients
        Route::resource('recipe_ingredients', RecipeIngredientController::class);

        // Pivot Table Recipe Categories
        Route::post('/recipe-categories', [RecipeDiseaseCategoryController::class, 'store'])
            ->name('recipe_categories.store');

        Route::delete('/recipe-categories', [RecipeDiseaseCategoryController::class, 'destroy'])
            ->name('recipe_categories.destroy');
    });
});