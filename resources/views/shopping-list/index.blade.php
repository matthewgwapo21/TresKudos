@extends('layouts.app')
@section('title', 'Shopping List — TresKudos')

@section('content')
<div class="max-w-2xl mx-auto">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="brand text-5xl font-black text-gray-900 mb-1">Shopping <span class="text-orange-500">List</span></h1>
            <p class="text-gray-400">
                Week of {{ $weekStart->format('M d') }} — {{ $weekStart->copy()->endOfWeek()->format('M d, Y') }}
            </p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('shopping-list.index', ['week' => $weekStart->copy()->subWeek()->format('Y-m-d')]) }}"
               class="bg-white border border-gray-200 hover:border-orange-300 text-gray-600 px-4 py-2 rounded-xl text-sm transition">
                ← Prev week
            </a>
            <a href="{{ route('shopping-list.index', ['week' => $weekStart->copy()->addWeek()->format('Y-m-d')]) }}"
               class="bg-white border border-gray-200 hover:border-orange-300 text-gray-600 px-4 py-2 rounded-xl text-sm transition">
                Next week →
            </a>
        </div>
    </div>

    @if($mealPlans->isEmpty())
        <div class="text-center py-28">
            <p class="text-6xl mb-4">🛒</p>
            <p class="brand text-2xl font-black text-gray-300">No meals planned</p>
            <p class="text-gray-400 mt-2">Add meals to your planner first</p>
            <a href="{{ route('meal-plan.index') }}"
               class="btn-primary inline-block mt-6 text-white font-medium px-6 py-3 rounded-xl text-sm">
                Go to Meal Planner
            </a>
        </div>
    @else

        <!-- Summary -->
        <div class="bg-orange-50 border border-orange-100 rounded-2xl p-4 mb-6 flex items-center justify-between">
            <div class="flex gap-6 text-sm">
                <span class="text-orange-600 font-medium">{{ $mealPlans->count() }} meals planned</span>
                <span class="text-orange-400">{{ count($ingredients) }} ingredients needed</span>
            </div>
            <button onclick="window.print()"
                    class="bg-white border border-orange-200 text-orange-500 hover:bg-orange-50 px-4 py-1.5 rounded-xl text-sm font-medium transition">
                🖨️ Print
            </button>
        </div>

        <!-- Meals this week -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-6">
            <h2 class="font-semibold text-gray-900 mb-4">Meals this week</h2>
            <div class="space-y-2">
                @foreach($mealPlans as $plan)
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">
                            {{ $plan->planned_date->format('D, M d') }} —
                            <span class="capitalize text-gray-400">{{ $plan->meal_type }}</span>
                        </span>
                        <a href="{{ route('recipes.show', $plan->recipe) }}"
                           class="font-medium text-gray-900 hover:text-orange-500 transition">
                            {{ $plan->recipe->title }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Ingredients checklist -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-gray-900">Ingredients</h2>
                <button onclick="toggleAll()"
                        class="text-sm text-orange-500 hover:text-orange-600 font-medium">
                    Check all
                </button>
            </div>

            <ul class="space-y-2" id="ingredient-list">
                @foreach($ingredients as $key => $ingredient)
                    <li class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition cursor-pointer"
                        onclick="toggleItem(this)">
                        <div class="w-5 h-5 rounded-md border-2 border-gray-300 flex items-center justify-center shrink-0 check-box transition">
                        </div>
                        <div class="flex-1">
                            <span class="item-text text-gray-800 text-sm font-medium">
                                @if($ingredient['quantity'])
                                    <span class="text-orange-500">{{ $ingredient['quantity'] }} {{ $ingredient['unit'] }}</span>
                                @endif
                                {{ $ingredient['name'] }}
                            </span>
                            <p class="text-xs text-gray-400 mt-0.5">
                                For: {{ implode(', ', array_unique($ingredient['recipes'])) }}
                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

    @endif
</div>

<style>
    .checked .check-box {
        background: #f97316;
        border-color: #f97316;
    }
    .checked .check-box::after {
        content: '✓';
        color: white;
        font-size: 12px;
        font-weight: bold;
    }
    .checked .item-text {
        text-decoration: line-through;
        opacity: 0.4;
    }
    @media print {
        nav, footer, button, .btn-primary { display: none !important; }
        body { background: white; }
    }
</style>

<script>
function toggleItem(el) {
    el.classList.toggle('checked');
}

function toggleAll() {
    const items = document.querySelectorAll('#ingredient-list li');
    const allChecked = [...items].every(i => i.classList.contains('checked'));
    items.forEach(i => {
        if (allChecked) {
            i.classList.remove('checked');
        } else {
            i.classList.add('checked');
        }
    });
}
</script>

@endsection