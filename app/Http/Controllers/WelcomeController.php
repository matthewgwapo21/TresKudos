<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\User;
use App\Models\Category;

class WelcomeController extends Controller {
    public function index() {
        $totalRecipes  = Recipe::count();
        $totalUsers    = User::count();
        $totalCategories = Category::count();
        $latestRecipes = Recipe::with('user', 'category')
            ->latest()
            ->take(6)
            ->get();
        return view('welcome', compact('totalRecipes', 'totalUsers', 'totalCategories', 'latestRecipes'));
    }
}