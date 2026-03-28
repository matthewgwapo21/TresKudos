<?php

namespace App\Http\Controllers;

use App\Models\MealPlan;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MealPlanController extends Controller {

    public function index(Request $request) {
        $weekStart = $request->filled('week')
            ? Carbon::parse($request->week)->startOfWeek()
            : Carbon::now()->startOfWeek();

        $weekEnd  = $weekStart->copy()->endOfWeek();
        $weekDays = [];

        for ($day = $weekStart->copy(); $day <= $weekEnd; $day->addDay()) {
            $weekDays[] = $day->copy();
        }

        $mealPlans = auth()->user()->mealPlans()
            ->with('recipe')
            ->whereBetween('planned_date', [$weekStart, $weekEnd])
            ->get()
            ->groupBy(function ($plan) {
                return $plan->planned_date->format('Y-m-d');
            });

        $recipes = Recipe::orderBy('title')->get();

        return view('meal-plan.index', compact('weekDays', 'mealPlans', 'recipes', 'weekStart'));
    }

    public function store(Request $request) {
        $request->validate([
            'recipe_id'    => 'required|exists:recipes,id',
            'planned_date' => 'required|date',
            'meal_type'    => 'required|in:breakfast,lunch,dinner',
        ]);

        MealPlan::updateOrCreate(
            [
                'user_id'      => auth()->id(),
                'planned_date' => $request->planned_date,
                'meal_type'    => $request->meal_type,
            ],
            ['recipe_id' => $request->recipe_id]
        );

        return back()->with('success', 'Meal planned!');
    }

    public function destroy(MealPlan $mealPlan) {
        if ($mealPlan->user_id !== auth()->id()) abort(403);
        $mealPlan->delete();
        return back()->with('success', 'Meal removed.');
    }
}