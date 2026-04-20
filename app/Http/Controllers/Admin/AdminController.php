<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Comment;
use App\Models\Review;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\UserSubscription;

class AdminController extends Controller {

    public function index() {
        $stats = [
            'total_users'      => User::count(),
            'total_recipes'    => Recipe::count(),
            'total_categories' => Category::count(),
            'total_favorites'  => Favorite::count(),
            'total_comments'   => Comment::count(),
            'total_reviews'    => Review::count(),
            'pending_recipes'  => Recipe::pending()->count(),
        ];

        $latestUsers   = User::latest()->take(5)->get();
        $latestRecipes = Recipe::with('user')->latest()->take(5)->get();
        $stats['total_subscribers'] = UserSubscription::where('status', 'active')
            ->where('expires_at', '>', now())
            ->count();

        return view('admin.dashboard', compact('stats', 'latestUsers', 'latestRecipes'));
    }

    public function statistics(Request $request) {
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = [
                'label'    => $month->format('M Y'),
                'users'    => User::whereYear('created_at', $month->year)
                                  ->whereMonth('created_at', $month->month)->count(),
                'recipes'  => Recipe::whereYear('created_at', $month->year)
                                    ->whereMonth('created_at', $month->month)->count(),
                'comments' => Comment::whereYear('created_at', $month->year)
                                     ->whereMonth('created_at', $month->month)->count(),
                'reviews'  => Review::whereYear('created_at', $month->year)
                                    ->whereMonth('created_at', $month->month)->count(),
                'favorites' => Favorite::whereYear('created_at', $month->year)
                                       ->whereMonth('created_at', $month->month)->count(),
            ];
        }

        return view('admin.statistics', compact('months'));
    }
}