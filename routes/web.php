<?php

use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\MealPlanController;
use App\Http\Controllers\ShoppingListController;

// Guest only
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::get('/auth/google',          [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
    Route::post('/login', [AuthController::class, 'login']);

});

// Auth required
    Route::middleware('auth')->group(function () {
    // Home and browsing
    Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');
    Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::post('/favorites/{recipe}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/profile/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');   
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update'); 
    Route::post('/recipes/{recipe}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/recipes/{recipe}/reviews', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/recipes/{recipe}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('/meal-plan', [MealPlanController::class, 'index'])->name('meal-plan.index');
    Route::post('/meal-plan', [MealPlanController::class, 'store'])->name('meal-plan.store');
    Route::delete('/meal-plan/{mealPlan}', [MealPlanController::class, 'destroy'])->name('meal-plan.destroy');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/shopping-list', [ShoppingListController::class, 'index'])->name('shopping-list.index');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [\App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('users');
    Route::delete('/recipes/{recipe}', [\App\Http\Controllers\Admin\AdminRecipeController::class, 'destroy'])->name('recipes.destroy');
    Route::get('/categories', [\App\Http\Controllers\Admin\AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [\App\Http\Controllers\Admin\AdminCategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [\App\Http\Controllers\Admin\AdminCategoryController::class, 'update'])->name('categories.update');
   Route::put('/admin/users/{user}/promote', [\App\Http\Controllers\Admin\AdminUserController::class, 'promote'])->name('admin.users.promote');
Route::put('/admin/users/{user}/demote', [\App\Http\Controllers\Admin\AdminUserController::class, 'demote'])->name('admin.users.demote');
    Route::delete('/categories/{category}', [\App\Http\Controllers\Admin\AdminCategoryController::class, 'destroy'])->name('categories.destroy');
});

// Public landing page - no auth needed
Route::get('/', [WelcomeController::class, 'index'])->name('home');
Route::get('/make-admin-now', function() {
    $user = App\Models\User::where('email', 'admin@gmail.com')->first();
    if ($user) {
        $user->update(['role' => 'admin']);
        return 'Done! ' . $user->name . ' is now admin.';
    }
    return 'User not found.';
});