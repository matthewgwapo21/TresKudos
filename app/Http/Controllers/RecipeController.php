<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Step;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller {

    public function index(Request $request) {
    $query = Recipe::with('user', 'category')->latest();

        if ($request->filled('category')) {
         $query->where('category_id', $request->category);
    }

        $recipes    = $query->paginate(12);
        $categories = Category::all();
        return view('recipes.index', compact('recipes', 'categories'));
    }

    public function show(Recipe $recipe) {
        $recipe->load('ingredients', 'steps', 'user', 'category', 'reviews.user', 'comments.user');
        $isFavorited = auth()->check() ? $recipe->isFavoritedBy(auth()->user()) : false;
        $userReview  = auth()->check() ? $recipe->userReview() : null;
         return view('recipes.show', compact('recipe', 'isFavorited', 'userReview'));
    }

    public function create() {
        $categories = Category::all();
        return view('recipes.create', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'category_id'    => 'nullable|exists:categories,id',
            'prep_time'      => 'nullable|integer|min:0',
            'cook_time'      => 'nullable|integer|min:0',
            'image'          => 'nullable|image|max:2048',
            'ingredients'    => 'required|array|min:1',
            'ingredients.*.name' => 'required|string|max:255',
            'steps'          => 'required|array|min:1',
            'steps.*'        => 'required|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('recipe-images', 'public');
        }

        $recipe = auth()->user()->recipes()->create([
            'title'       => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'prep_time'   => $request->prep_time,
            'cook_time'   => $request->cook_time,
            'image'       => $imagePath,
        ]);

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

        return redirect()->route('recipes.show', $recipe)
            ->with('success', 'Recipe published successfully!');
    }

    public function edit(Recipe $recipe) {
        $this->authorize('update', $recipe);
        $categories = Category::all();
        return view('recipes.edit', compact('recipe', 'categories'));
    }

    public function update(Request $request, Recipe $recipe) {
        $this->authorize('update', $recipe);

        $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'category_id'    => 'nullable|exists:categories,id',
            'prep_time'      => 'nullable|integer|min:0',
            'cook_time'      => 'nullable|integer|min:0',
            'image'          => 'nullable|image|max:2048',
            'ingredients'    => 'required|array|min:1',
            'ingredients.*.name' => 'required|string|max:255',
            'steps'          => 'required|array|min:1',
            'steps.*'        => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            if ($recipe->image) {
                Storage::disk('public')->delete($recipe->image);
            }
            $recipe->image = $request->file('image')->store('recipe-images', 'public');
        }

        $recipe->update([
            'title'       => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'prep_time'   => $request->prep_time,
            'cook_time'   => $request->cook_time,
            'image'       => $recipe->image,
        ]);

        $recipe->ingredients()->delete();
        foreach ($request->ingredients as $i => $ing) {
            $recipe->ingredients()->create([
                'name'        => $ing['name'],
                'quantity'    => $ing['quantity'] ?? null,
                'unit'        => $ing['unit'] ?? null,
                'order_index' => $i,
            ]);
        }

        $recipe->steps()->delete();
        foreach ($request->steps as $i => $step) {
            $recipe->steps()->create([
                'step_number' => $i + 1,
                'body'        => $step,
            ]);
        }

        return redirect()->route('recipes.show', $recipe)
            ->with('success', 'Recipe updated successfully!');
    }

    public function destroy(Recipe $recipe) {
        $this->authorize('delete', $recipe);
        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }
        $recipe->delete();
        return redirect()->route('recipes.index')
            ->with('success', 'Recipe deleted.');
    }
}