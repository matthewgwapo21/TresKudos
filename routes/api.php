<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RecipeController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);
Route::get('/recipes',             [RecipeController::class, 'index']);
Route::get('/recipes/{recipe}',    [RecipeController::class, 'show']);
Route::get('/categories',          [RecipeController::class, 'categories']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout',          [AuthController::class, 'logout']);
    Route::get('/me',               [AuthController::class, 'me']);
    Route::post('/recipes',         [RecipeController::class, 'store']);
    Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy']);
});