<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Category;
use App\Models\Favorite;

class AdminController extends Controller {
    public function index() {
        $stats = [
            'total_users'     => User::count(),
            'total_recipes'   => Recipe::count(),
            'total_categories'=> Category::count(),
            'total_favorites' => Favorite::count(),
        ];
        $latestUsers   = User::latest()->take(5)->get();
        $latestRecipes = Recipe::with('user')->latest()->take(5)->get();
        return view('admin.dashboard', compact('stats', 'latestUsers', 'latestRecipes'));
    }
}