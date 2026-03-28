@extends('layouts.app')
@section('title', 'Meal Planner — TresKudos')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="brand text-5xl font-black text-gray-900 mb-1">Meal <span class="text-orange-500">Planner</span></h1>
        <p class="text-gray-400">Plan your week one meal at a time</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('meal-plan.index', ['week' => $weekStart->copy()->subWeek()->format('Y-m-d')]) }}"
           class="bg-white border border-gray-200 hover:border-orange-300 text-gray-600 px-4 py-2 rounded-xl text-sm transition">
            ← Prev
        </a>
        <span class="text-sm font-medium text-gray-700">
            {{ $weekStart->format('M d') }} — {{ $weekStart->copy()->endOfWeek()->format('M d, Y') }}
        </span>
        <a href="{{ route('meal-plan.index', ['week' => $weekStart->copy()->addWeek()->format('Y-m-d')]) }}"
           class="bg-white border border-gray-200 hover:border-orange-300 text-gray-600 px-4 py-2 rounded-xl text-sm transition">
            Next →
        </a>
        <a href="{{ route('meal-plan.index') }}"
           class="btn-primary text-white px-4 py-2 rounded-xl text-sm">
            Today
        </a>
    </div>
</div>

<div class="grid grid-cols-1 gap-4">
    @foreach($weekDays as $day)
        @php
            $dateKey  = $day->format('Y-m-d');
            $dayMeals = $mealPlans[$dateKey] ?? collect();
            $isToday  = $day->isToday();
        @endphp

        <div class="bg-white rounded-2xl border {{ $isToday ? 'border-orange-300 shadow-md shadow-orange-50' : 'border-gray-100' }} overflow-hidden">

            <div class="px-6 py-3 {{ $isToday ? 'bg-orange-500' : 'bg-gray-50 border-b border-gray-100' }} flex items-center justify-between">
                <div>
                    <span class="font-semibold {{ $isToday ? 'text-white' : 'text-gray-900' }}">
                        {{ $day->format('l') }}
                    </span>
                    <span class="text-sm {{ $isToday ? 'text-orange-100' : 'text-gray-400' }} ml-2">
                        {{ $day->format('M d') }}
                    </span>
                    @if($isToday)
                        <span class="ml-2 bg-white text-orange-500 text-xs font-bold px-2 py-0.5 rounded-full">Today</span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-3 divide-x divide-gray-100">
                @foreach(['breakfast' => '🌅', 'lunch' => '☀️', 'dinner' => '🌙'] as $mealType => $emoji)
                    @php
                        $meal = $dayMeals->where('meal_type', $mealType)->first();
                    @endphp
                    <div class="p-4">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">
                            {{ $emoji }} {{ ucfirst($mealType) }}
                        </p>

                        @if($meal)
                            <div class="group">
                                @if($meal->recipe->image)
                                    <img src="{{ Storage::url($meal->recipe->image) }}"
                                         class="w-full h-24 object-cover rounded-xl mb-2" alt="">
                                @else
                                    <div class="w-full h-24 bg-orange-50 rounded-xl mb-2 flex items-center justify-center text-2xl">🍽️</div>
                                @endif
                                <a href="{{ route('recipes.show', $meal->recipe) }}"
                                   class="font-medium text-gray-900 text-sm hover:text-orange-500 transition line-clamp-1">
                                    {{ $meal->recipe->title }}
                                </a>
                                @if($meal->recipe->prep_time || $meal->recipe->cook_time)
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        ⏱ {{ $meal->recipe->prep_time + $meal->recipe->cook_time }} min
                                    </p>
                                @endif
                                <form method="POST" action="{{ route('meal-plan.destroy', $meal) }}" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-xs text-red-400 hover:text-red-600 transition">Remove</button>
                                </form>
                            </div>
                        @else
                            <!-- Empty slot — add meal form -->
                            <form method="POST" action="{{ route('meal-plan.store') }}">
                                @csrf
                                <input type="hidden" name="planned_date" value="{{ $dateKey }}">
                                <input type="hidden" name="meal_type" value="{{ $mealType }}">
                                <select name="recipe_id" required
                                        class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-orange-400 transition mb-2">
                                    <option value="">Pick a recipe...</option>
                                    @foreach($recipes as $recipe)
                                        <option value="{{ $recipe->id }}">{{ $recipe->title }}</option>
                                    @endforeach
                                </select>
                                <button type="submit"
                                        class="w-full bg-orange-50 hover:bg-orange-100 text-orange-500 font-medium py-1.5 rounded-xl text-xs transition">
                                    + Add
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

@endsection