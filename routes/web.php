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
use App\Http\Controllers\CommunityController;

use App\Http\Controllers\Admin\DashboardController;


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

Route::get('/community', [CommunityController::class, 'index'])->name('community');


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

    
    
});

/*
    |--------------------------------------------------------------------------
    | 3. ADMIN AREA (Master Data)
    |--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Route Dashboard Utama
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Route Manajemen User
    Route::get('/users', [DashboardController::class, 'users'])->name('admin.users');

    //Route Manajemen resep
    Route::get('/recipes', [DashboardController::class, 'recipes'])->name('admin.recipes');

    //Route Manajemen community hub
    Route::get('/community', [\App\Http\Controllers\Admin\DashboardController::class, 'community'])->name('admin.community');

    // Rute untuk melihat Detail Postingan
    Route::get('/community/{id}', [\App\Http\Controllers\Admin\DashboardController::class, 'communityDetail'])->name('admin.community.detail');

    // Rute untuk Menghapus Postingan
    Route::delete('/community/{id}', [\App\Http\Controllers\Admin\DashboardController::class, 'deletePost'])->name('admin.community.destroy');

    //Route Manajemen TKPI
    Route::get('/tkpi', [DashboardController::class, 'tkpi'])->name('admin.tkpi');

    Route::get('/users/{id}/detail', [DashboardController::class, 'userDetail'])->name('admin.users.detail');

    Route::get('/recipes/{id}/detail', [DashboardController::class, 'recipeDetail'])->name('admin.recipes.detail');

    Route::get('/recipes/create', [DashboardController::class, 'createRecipe'])->name('admin.recipes.create');

    // Route untuk halaman Detail Community Hub
    Route::get('/community/detail', function () {
        return view('admin.community-detail');
    })->name('admin.community.detail');

    // Route untuk halaman Edit/Detail TKPI
    Route::get('/tkpi/{id}/edit', [\App\Http\Controllers\Admin\DashboardController::class, 'editTkpi'])->name('admin.tkpi.edit');
    Route::put('/tkpi/{id}', [\App\Http\Controllers\Admin\DashboardController::class, 'updateTkpi'])->name('admin.tkpi.update');
    
    Route::delete('/tkpi/{id}', [\App\Http\Controllers\Admin\DashboardController::class, 'deleteTkpi'])->name('admin.tkpi.destroy');

    // Route untuk halaman Tambah TKPI
    Route::get('/tkpi/create', function () {
        return view('admin.tkpi-create');
    })->name('admin.tkpi.create');

    Route::patch('/users/{id}/role', [DashboardController::class, 'updateRole'])->name('admin.users.updateRole');

    Route::delete('/users/{id}', [DashboardController::class, 'destroyUser'])->name('admin.users.destroy');

    Route::post('/recipes/store', [DashboardController::class, 'storeRecipe'])->name('admin.recipes.store');

    Route::delete('/recipes/{id}', [DashboardController::class, 'destroyRecipe'])->name('admin.recipes.destroy');

    Route::get('/recipes/{id}/edit', [DashboardController::class, 'editRecipe'])->name('admin.recipes.edit');

    Route::put('/recipes/{id}', [DashboardController::class, 'updateRecipe'])->name('admin.recipes.update');

    Route::post('/tkpi/store', [DashboardController::class, 'storeTkpi'])->name('admin.tkpi.store');
});
