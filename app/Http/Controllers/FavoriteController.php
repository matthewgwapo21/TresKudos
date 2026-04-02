<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller {

    public function index() {
        $favorites = auth()->user()
            ->favorites()
            ->with('recipe.user', 'recipe.category')
            ->latest()
            ->paginate(12);
        return view('profile.favorites', compact('favorites'));
    }

    public function toggle(Recipe $recipe) {
        $existing = Favorite::where('user_id', auth()->id())
            ->where('recipe_id', $recipe->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $message = 'Removed from favorites.';
        } else {
            Favorite::create([
                'user_id'   => auth()->id(),
                'recipe_id' => $recipe->id,
            ]);
            NotificationHelper::send(
             $recipe->user_id,
            'favorite',
            'Someone favorited your recipe!',
            auth()->user()->name . ' added "' . $recipe->title . '" to their favorites.',
            route('recipes.show', $recipe)
            );
            $message = 'Added to favorites!';
        }

        return back()->with('success', $message);
    }
}