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

    $mealFilter = $request->get('meal_filter', 'all');

    $query = auth()->user()->mealPlans()
        ->with('recipe.ingredients')
        ->whereBetween('planned_date', [$weekStart, $weekEnd]);

    if ($mealFilter !== 'all') {
        $query->where('meal_type', $mealFilter);
    }

    $mealPlans = $query->get();

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
                ];
            }
        }
    }

    ksort($ingredients);

    // Paginate manually
    $perPage    = 10;
    $page       = $request->get('page', 1);
    $total      = count($ingredients);
    $ingredients = array_slice($ingredients, ($page - 1) * $perPage, $perPage);
    $paginator  = new \Illuminate\Pagination\LengthAwarePaginator(
        $ingredients, $total, $perPage, $page,
        ['path' => $request->url(), 'query' => $request->query()]
    );

    return view('shopping-list.index', compact('ingredients', 'weekStart', 'mealPlans', 'paginator', 'mealFilter'));
}
}