@extends('layouts.app')
@section('title', 'Search — TresKudos')

@section('content')

<h1 class="brand text-5xl font-black text-gray-900 mb-2">Search <span class="text-orange-500">Recipes</span></h1>
<p class="text-gray-400 mb-8">Find your next favorite dish</p>

<form method="GET" action="{{ route('search') }}"
      class="bg-white rounded-2xl border border-gray-100 p-4 mb-10 flex flex-wrap gap-3 items-center">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search recipes..."
           class="flex-1 min-w-48 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition">
    <select name="category"
            class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>
    <input type="number" name="prep_time" value="{{ request('prep_time') }}" placeholder="Max total time (min)"
       class="w-44 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition">
    <button type="submit" class="btn-primary text-white px-6 py-2.5 rounded-xl text-sm font-medium">
        Search
    </button>
</form>

@if($recipes->count())
    <p class="text-gray-400 text-sm mb-6">{{ $recipes->total() }} recipe(s) found</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($recipes as $recipe)
            <a href="{{ route('recipes.show', $recipe) }}"
               class="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:border-orange-200 hover:shadow-xl hover:shadow-orange-50 transition-all duration-300">
                @if($recipe->image)
                    <div class="overflow-hidden h-52">
                        <img src="{{ Storage::url($recipe->image) }}"
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
            </a>
        @endforeach
    </div>
    <div class="mt-10">{{ $recipes->links() }}</div>
@else
    <div class="text-center py-28">
        <p class="text-6xl mb-4">🔍</p>
        <p class="brand text-2xl font-black text-gray-300">No results found</p>
        <p class="text-gray-400 mt-2">Try a different search term or category</p>
    </div>
@endif

@endsection