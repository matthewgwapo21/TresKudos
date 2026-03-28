<?php

namespace App\Http\Controllers;

use App\Models\MealPlan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ShoppingListController extends Controller {

    public function index(Request $request) {
        $weekStart = $request->filled('week')
            ? Carbon::parse($request->week)->startOfWeek()
            : Carbon::now()->startOfWeek();

        $weekEnd = $weekStart->copy()->endOfWeek();

        $mealPlans = auth()->user()->mealPlans()
            ->with('recipe.ingredients')
            ->whereBetween('planned_date', [$weekStart, $weekEnd])
            ->get();

        // Group ingredients by name and combine quantities
        $ingredients = [];
        foreach ($mealPlans as $plan) {
            foreach ($plan->recipe->ingredients as $ingredient) {
                $key = strtolower(trim($ingredient->name));
                if (isset($ingredients[$key])) {
                    $ingredients[$key]['recipes'][] = $plan->recipe->title;
                } else {
                    $ingredients[$key] = [
                        'name'     => $ingredient->name,
                        'quantity' => $ingredient->quantity,
                        'unit'     => $ingredient->unit,
                        'recipes'  => [$plan->recipe->title],
                        'checked'  => false,
                    ];
                }
            }
        }

        // Sort alphabetically
        ksort($ingredients);

        return view('shopping-list.index', compact('ingredients', 'weekStart', 'mealPlans'));
    }
}