<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RecipeController extends Controller {

   public function index(Request $request) {
    $query = Recipe::with('user', 'category')->latest();

    if ($request->filled('q')) {
        $term = $request->q;
        $query->where(function($q) use ($term) {
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

    if ($request->filled('sort') && $request->sort === 'oldest') {
        $query->reorder('created_at', 'asc');
    }

    $recipes    = $query->paginate(12)->withQueryString();
    $categories = Category::all();
    return view('recipes.index', compact('recipes', 'categories'));
}
public function edit(Recipe $recipe) {
    if (auth()->id() !== $recipe->user_id && !auth()->user()->isAdmin()) {
        abort(403);
    }
    $categories = Category::all();
    return view('recipes.edit', compact('recipe', 'categories'));
}

    public function update(Request $request, Recipe $recipe) {
         if (auth()->id() !== $recipe->user_id && !auth()->user()->isAdmin()) {
        abort(403);
    }

        $request->validate([
            'title'              => 'required|string|max:255',
            'description'        => 'nullable|string',
            'category_id'        => 'nullable|exists:categories,id',
            'prep_time'          => 'nullable|integer|min:0',
            'cook_time'          => 'nullable|integer|min:0',
            'image'              => 'nullable|image|max:2048',
            'ingredients'        => 'required|array|min:1',
            'ingredients.*.name' => 'required|string|max:255',
            'steps'              => 'required|array|min:1',
            'steps.*'            => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $uploaded = $this->uploadToCloudinary($request->file('image'), 'treskudos/recipes');
            if ($uploaded) $recipe->image = $uploaded;
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
    if (auth()->id() !== $recipe->user_id && !auth()->user()->isAdmin()) {
        abort(403);
    }
    if ($recipe->image && str_starts_with($recipe->image, 'http')) {
        // Cloudinary image — no need to delete locally
    } elseif ($recipe->image) {
        Storage::disk('public')->delete($recipe->image);
    }
    $recipe->delete();
    return redirect()->route('recipes.index')
        ->with('success', 'Recipe deleted.');
}

    private function uploadToCloudinary($file, $folder = 'treskudos') {
        try {
            $cloudName = env('CLOUDINARY_CLOUD_NAME');
            $apiKey    = env('CLOUDINARY_API_KEY');
            $apiSecret = env('CLOUDINARY_API_SECRET');
            $timestamp = time();
            $signature = sha1("folder={$folder}&timestamp={$timestamp}{$apiSecret}");

            $response = Http::attach(
                'file', file_get_contents($file->getRealPath()), $file->getClientOriginalName()
            )->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
                'api_key'   => $apiKey,
                'timestamp' => $timestamp,
                'signature' => $signature,
                'folder'    => $folder,
            ]);

            return $response->json()['secure_url'] ?? null;
        } catch (\Exception $e) {
            return null;
        }
    }
}