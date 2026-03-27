<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller {

    public function index(Request $request) {
        $query = Recipe::with('user:id,name', 'category:id,name', 'reviews');

        if ($request->filled('q')) {
            $query->where('title', 'like', "%{$request->q}%")
                  ->orWhere('description', 'like', "%{$request->q}%");
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $recipes = $query->latest()->paginate(12);

        return response()->json($recipes);
    }

    public function show(Recipe $recipe) {
        $recipe->load('user:id,name', 'category:id,name', 'ingredients', 'steps', 'reviews.user:id,name');

        return response()->json([
            'id'             => $recipe->id,
            'title'          => $recipe->title,
            'description'    => $recipe->description,
            'image'          => $recipe->image ? Storage::url($recipe->image) : null,
            'prep_time'      => $recipe->prep_time,
            'cook_time'      => $recipe->cook_time,
            'total_time'     => $recipe->prep_time + $recipe->cook_time,
            'average_rating' => $recipe->averageRating(),
            'category'       => $recipe->category,
            'user'           => $recipe->user,
            'ingredients'    => $recipe->ingredients,
            'steps'          => $recipe->steps,
            'reviews'        => $recipe->reviews,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'title'              => 'required|string|max:255',
            'description'        => 'nullable|string',
            'category_id'        => 'nullable|exists:categories,id',
            'prep_time'          => 'nullable|integer|min:0',
            'cook_time'          => 'nullable|integer|min:0',
            'ingredients'        => 'required|array|min:1',
            'ingredients.*.name' => 'required|string',
            'steps'              => 'required|array|min:1',
            'steps.*'            => 'required|string',
        ]);

        $recipe = auth()->user()->recipes()->create($request->only([
            'title', 'description', 'category_id', 'prep_time', 'cook_time'
        ]));

        foreach ($request->ingredients as $i => $ing) {
            $recipe->ingredients()->create([
                'name'        => $ing['name'],
                'quantity'    => $ing['quantity'] ?? null,
                'unit'        => $ing['unit'] ?? null,
                'order_index' => $i,
            ]);
        }

        foreach ($request->steps as $i => $step) {
            $recipe->steps()->create([
                'step_number' => $i + 1,
                'body'        => $step,
            ]);
        }

        return response()->json($recipe->load('ingredients', 'steps'), 201);
    }

    public function destroy(Recipe $recipe) {
        if (auth()->id() !== $recipe->user_id && !auth()->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $recipe->delete();
        return response()->json(['message' => 'Recipe deleted']);
    }

    public function categories() {
        return response()->json(Category::withCount('recipes')->get());
    }
}