<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller {

    public function index(Request $request) {
        $query = Recipe::query()->with('user', 'category');

        if ($request->filled('q')) {
            $term = $request->q;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

       if ($request->filled('prep_time')) {
    $query->whereRaw('(prep_time + cook_time) <= ?', [(int) $request->prep_time]);
}

        $recipes    = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('search.results', compact('recipes', 'categories'));
    }
}