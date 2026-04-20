<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MealPlanController;
use App\Http\Controllers\ShoppingListController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\SubscriptionController;

// Landing page
Route::get('/', function() {
    if (auth()->check()) {
        return redirect()->route('recipes.index');
    }
    return app(WelcomeController::class)->index();
})->name('home');

// Guest only
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

// Auth required
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
    Route::get('/forum/create', [ForumController::class, 'create'])->name('forum.create');
    Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
    Route::get('/forum/{topic}', [ForumController::class, 'show'])->name('forum.show');
    Route::post('/forum/{topic}/reply', [ForumController::class, 'reply'])->name('forum.reply');
    Route::delete('/forum/{topic}', [ForumController::class, 'destroy'])->name('forum.destroy');
    Route::delete('/forum/replies/{reply}', [ForumController::class, 'destroyReply'])->name('forum.reply.destroy');

    //Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Recipes
    Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');
    Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');

    // Search & categories
    Route::get('/search', function() {
    return redirect()->route('recipes.index', request()->all());
})->name('search');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

    // Favorites
    Route::post('/favorites/{recipe}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/profile/favorites', [FavoriteController::class, 'index'])->name('favorites.index');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Reviews
    Route::post('/recipes/{recipe}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/recipes/{recipe}/reviews', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Comments
    Route::post('/recipes/{recipe}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

   
    // Shopping list
    Route::get('/shopping-list', [ShoppingListController::class, 'index'])->name('shopping-list.index');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [\App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('users');
    Route::put('/users/{user}/promote', [\App\Http\Controllers\Admin\AdminUserController::class, 'promote'])->name('users.promote');
    Route::put('/users/{user}/demote', [\App\Http\Controllers\Admin\AdminUserController::class, 'demote'])->name('users.demote');
    Route::delete('/recipes/{recipe}', [\App\Http\Controllers\Admin\AdminRecipeController::class, 'destroy'])->name('recipes.destroy');
    Route::get('/categories', [\App\Http\Controllers\Admin\AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [\App\Http\Controllers\Admin\AdminCategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [\App\Http\Controllers\Admin\AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [\App\Http\Controllers\Admin\AdminCategoryController::class, 'destroy'])->name('categories.destroy');
   Route::get('/recipes/pending', [\App\Http\Controllers\Admin\AdminRecipeApprovalController::class, 'pending'])->name('recipes.pending');
    Route::put('/recipes/{recipe}/approve', [\App\Http\Controllers\Admin\AdminRecipeApprovalController::class, 'approve'])->name('recipes.approve');
    Route::put('/recipes/{recipe}/reject', [\App\Http\Controllers\Admin\AdminRecipeApprovalController::class, 'reject'])->name('recipes.reject');
    Route::get('/statistics', [\App\Http\Controllers\Admin\AdminController::class, 'statistics'])->name('statistics');
    Route::get('/forum', [\App\Http\Controllers\Admin\AdminForumController::class, 'index'])->name('forum');
    Route::put('/forum/{topic}/pin', [\App\Http\Controllers\Admin\AdminForumController::class, 'pin'])->name('forum.pin');
    Route::put('/forum/{topic}/close', [\App\Http\Controllers\Admin\AdminForumController::class, 'close'])->name('forum.close');
    Route::delete('/forum/{topic}', [\App\Http\Controllers\Admin\AdminForumController::class, 'destroy'])->name('forum.destroy');
    Route::get('/premium', [SubscriptionController::class, 'upgrade'])->name('subscription.upgrade');
    Route::post('/premium/pay', [SubscriptionController::class, 'pay'])->name('subscription.pay');
    Route::post('/premium/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
});

Route::middleware('premium')->group(function () {
    Route::get('/meal-plan', [MealPlanController::class, 'index'])->name('meal-plan.index');
    Route::post('/meal-plan', [MealPlanController::class, 'store'])->name('meal-plan.store');
    Route::delete('/meal-plan/{mealPlan}', [MealPlanController::class, 'destroy'])->name('meal-plan.destroy');
    Route::get('/shopping-list', [ShoppingListController::class, 'index'])->name('shopping-list.index');
});