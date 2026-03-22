@extends('layouts.app')
@section('title', $recipe->title . ' — TresKudos')

@section('content')
<div class="max-w-3xl mx-auto">

    <!-- Back -->
    <a href="{{ route('recipes.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-orange-500 transition mb-6">
        ← Back to recipes
    </a>

    <!-- Image -->
    @if($recipe->image)
        <div class="rounded-2xl overflow-hidden h-80 mb-8">
            <img src="{{ Storage::url($recipe->image) }}" class="w-full h-full object-cover" alt="{{ $recipe->title }}">
        </div>
    @endif

    <!-- Header -->
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="brand text-4xl font-black text-gray-900 mb-2">{{ $recipe->title }}</h1>
            <div class="flex items-center gap-3 text-sm text-gray-400">
                <span>by <strong class="text-gray-600">{{ $recipe->user->name }}</strong></span>
                @if($recipe->category)
                    <span class="bg-orange-50 text-orange-500 px-3 py-1 rounded-full font-medium text-xs">
                        {{ $recipe->category->name }}
                    </span>
                @endif
            </div>
        </div>
        @auth
            <form method="POST" action="{{ route('favorites.toggle', $recipe) }}">
                @csrf
                <button class="text-3xl hover:scale-110 transition-transform" title="Favorite">
                    {{ $isFavorited ? '❤️' : '🤍' }}
                </button>
            </form>
        @endauth
    </div>

    <!-- Meta pills -->
    <div class="flex gap-3 mb-8">
        @if($recipe->prep_time)
            <div class="bg-white border border-gray-100 rounded-xl px-4 py-3 text-center">
                <p class="text-xs text-gray-400 mb-1">Prep time</p>
                <p class="font-semibold text-gray-800">{{ $recipe->prep_time }} min</p>
            </div>
        @endif
        @if($recipe->cook_time)
            <div class="bg-white border border-gray-100 rounded-xl px-4 py-3 text-center">
                <p class="text-xs text-gray-400 mb-1">Cook time</p>
                <p class="font-semibold text-gray-800">{{ $recipe->cook_time }} min</p>
            </div>
        @endif
        @if($recipe->prep_time && $recipe->cook_time)
            <div class="bg-orange-50 border border-orange-100 rounded-xl px-4 py-3 text-center">
                <p class="text-xs text-orange-400 mb-1">Total time</p>
                <p class="font-semibold text-orange-600">{{ $recipe->prep_time + $recipe->cook_time }} min</p>
            </div>
        @endif
    </div>

    <!-- Description -->
    @if($recipe->description)
        <p class="text-gray-600 leading-relaxed mb-8 text-lg">{{ $recipe->description }}</p>
    @endif

    <!-- Ingredients -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-6">
        <h2 class="brand text-2xl font-black text-gray-900 mb-5">Ingredients</h2>
        <ul class="space-y-3">
            @foreach($recipe->ingredients as $ingredient)
                <li class="flex items-center gap-3 text-gray-700">
                    <span class="w-2 h-2 rounded-full bg-orange-400 shrink-0"></span>
                    <span class="font-medium text-orange-600 min-w-fit">
                        {{ $ingredient->quantity }} {{ $ingredient->unit }}
                    </span>
                    <span>{{ $ingredient->name }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Steps -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-8">
        <h2 class="brand text-2xl font-black text-gray-900 mb-5">Instructions</h2>
        <ol class="space-y-6">
            @foreach($recipe->steps as $step)
                <li class="flex gap-4">
                    <span class="btn-primary text-white rounded-xl w-8 h-8 flex items-center justify-center text-sm font-bold shrink-0 mt-0.5">
                        {{ $step->step_number }}
                    </span>
                    <p class="text-gray-600 leading-relaxed pt-1">{{ $step->body }}</p>
                </li>
            @endforeach
        </ol>
    </div>

    <!-- Edit/Delete -->
    @auth
        @if(auth()->id() === $recipe->user_id || auth()->user()->isAdmin())
            <div class="flex gap-3">
                <a href="{{ route('recipes.edit', $recipe) }}"
                   class="bg-white border border-gray-200 hover:border-orange-300 text-gray-700 px-5 py-2.5 rounded-xl text-sm font-medium transition">
                    Edit Recipe
                </a>
                <form method="POST" action="{{ route('recipes.destroy', $recipe) }}"
                      onsubmit="return confirm('Delete this recipe?')">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-50 hover:bg-red-100 text-red-500 px-5 py-2.5 rounded-xl text-sm font-medium transition">
                        Delete
                    </button>
                </form>
            </div>
        @endif
    @endauth

</div>
@endsection