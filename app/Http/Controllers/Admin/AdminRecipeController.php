<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Support\Facades\Storage;

class AdminRecipeController extends Controller {
    public function destroy(Recipe $recipe) {
        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }
        $recipe->delete();
        return back()->with('success', 'Recipe deleted successfully.');
    }
}