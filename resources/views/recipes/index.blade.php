@extends('layouts.app')
@section('title', 'Browse Recipes — TresKudos')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="brand text-5xl font-black text-gray-900 mb-1">Browse <span class="text-orange-500">Recipes</span></h1>
        <p class="text-gray-400">Discover dishes from our community of home chefs</p>
    </div>
    <a href="{{ route('recipes.create') }}"
       class="btn-primary text-white text-sm font-medium px-5 py-2.5 rounded-xl hidden md:block">
        + Add Recipe
    </a>
</div>

<!-- Search + Filters -->
<form method="GET" action="{{ route('recipes.index') }}"
      class="bg-white rounded-2xl border border-gray-100 p-4 mb-6 space-y-3">

    <!-- Search bar -->
    <div class="relative">
        <input type="text" name="q" value="{{ request('q') }}"
               placeholder="Search recipes by name or description..."
               class="w-full border border-gray-200 rounded-xl px-4 py-3 pr-12 text-sm focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition">
        <button type="submit"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </button>
    </div>

    <!-- Filters row -->
    <div class="flex flex-wrap gap-3 items-center">

        <!-- Category pills -->
        <div class="flex gap-2 flex-wrap flex-1">
            <a href="{{ request()->fullUrlWithQuery(['category' => '']) }}"
               class="px-4 py-1.5 rounded-full text-sm font-medium transition
                      {{ !request('category') ? 'bg-orange-500 text-white shadow-md shadow-orange-200' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                All
            </a>
            @foreach($categories as $cat)
                <a href="{{ request()->fullUrlWithQuery(['category' => $cat->id]) }}"
                   class="px-4 py-1.5 rounded-full text-sm font-medium transition
                          {{ request('category') == $cat->id ? 'bg-orange-500 text-white shadow-md shadow-orange-200' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        <!-- Max time input -->
        <input type="number" name="prep_time" value="{{ request('prep_time') }}"
               placeholder="Max cook time (min)"
               class="border border-gray-200 rounded-xl px-4 py-2 text-sm w-44 focus:outline-none focus:border-orange-400 transition">

        <!-- Sort -->
        <div class="flex gap-2">
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}"
               class="px-4 py-1.5 rounded-full text-sm font-medium transition
                      {{ request('sort', 'latest') === 'latest' ? 'bg-orange-500 text-white' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                Latest
            </a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'oldest']) }}"
               class="px-4 py-1.5 rounded-full text-sm font-medium transition
                      {{ request('sort') === 'oldest' ? 'bg-orange-500 text-white' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                Oldest
            </a>
        </div>

        <!-- Clear filters -->
        @if(request()->anyFilled(['q', 'category', 'prep_time', 'sort']))
            <a href="{{ route('recipes.index') }}"
               class="text-sm text-red-400 hover:text-red-600 transition">
                Clear filters
            </a>
        @endif

    </div>
</form>

<!-- Results count -->
@if(request()->anyFilled(['q', 'category', 'prep_time']))
    <p class="text-gray-400 text-sm mb-4">{{ $recipes->total() }} recipe(s) found</p>
@endif

<!-- Grid -->
@if($recipes->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($recipes as $recipe)
            <a href="{{ route('recipes.show', $recipe) }}"
               class="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:border-orange-200 hover:shadow-xl hover:shadow-orange-50 transition-all duration-300">
                @if($recipe->image)
                    @php $imgUrl = str_starts_with($recipe->image, 'http') ? $recipe->image : asset('storage/' . $recipe->image); @endphp
                    <div class="overflow-hidden h-52">
                        <img src="{{ $imgUrl }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             alt="{{ $recipe->title }}">
                    </div>
                @else
                    <div class="h-52 bg-orange-50 flex items-center justify-center text-5xl">🍽️</div>
                @endif
                <div class="p-5">
                    <h2 class="font-semibold text-gray-900 text-lg mb-1 group-hover:text-orange-500 transition">
                        {{ $recipe->title }}
                    </h2>
                    <p class="text-gray-400 text-sm line-clamp-2 mb-4">{{ $recipe->description }}</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3 text-xs text-gray-400">
                            @if($recipe->prep_time || $recipe->cook_time)
                                <span>⏱ {{ ($recipe->prep_time + $recipe->cook_time) }} min</span>
                            @endif
                            @if($recipe->category)
                                <span class="bg-orange-50 text-orange-500 px-2.5 py-1 rounded-full font-medium">
                                    {{ $recipe->category->name }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <p class="text-xs text-gray-300 mt-2">by {{ $recipe->user->name }} · {{ $recipe->created_at->format('M d, Y') }}</p>
                </div>
            </a>
        @endforeach
    </div>
    <div class="mt-10">{{ $recipes->links() }}</div>
@else
    <div class="text-center py-28">
        <p class="text-6xl mb-4">🍳</p>
        <p class="brand text-2xl font-black text-gray-300">No recipes found</p>
        <p class="text-gray-400 mt-2">Try a different search or category</p>
        <a href="{{ route('recipes.index') }}"
           class="btn-primary inline-block mt-6 text-white font-medium px-6 py-3 rounded-xl text-sm">
            Clear filters
        </a>
    </div>
@endif

@endsection