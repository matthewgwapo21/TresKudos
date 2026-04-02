<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Helpers\NotificationHelper;

class AdminRecipeApprovalController extends Controller {

    public function pending() {
        $recipes = Recipe::with('user', 'category')
            ->pending()
            ->latest()
            ->paginate(20);
        return view('admin.recipes-pending', compact('recipes'));
    }

    public function approve(Recipe $recipe) {
        $recipe->update(['status' => 'approved']);
        NotificationHelper::send(
            $recipe->user_id,
            'recipe',
            'Your recipe was approved! 🎉',
            '"' . $recipe->title . '" has been approved and is now live.',
            route('recipes.show', $recipe)
        );
        return back()->with('success', 'Recipe approved!');
    }

    public function reject(Recipe $recipe) {
        $recipe->update(['status' => 'rejected']);
        NotificationHelper::send(
            $recipe->user_id,
            'recipe',
            'Your recipe was not approved',
            '"' . $recipe->title . '" was not approved by an admin. Please review and resubmit.',
            route('recipes.edit', $recipe)
        );
        return back()->with('success', 'Recipe rejected.');
    }
}