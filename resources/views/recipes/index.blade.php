@extends('layouts.app')
@section('title', 'All Recipes — TresKudos')

@section('content')

<!-- Hero -->
<div class="mb-10">
    <h1 class="brand text-5xl font-black text-gray-900 mb-2">All <span class="text-orange-500">Recipes</span></h1>
    <p class="text-gray-400 text-lg">Discover dishes from our community of home chefs</p>
</div>

<!-- Category pills -->
<div class="flex gap-2 flex-wrap mb-8">
    <a href="{{ route('recipes.index') }}"
       class="px-4 py-1.5 rounded-full text-sm font-medium transition
              {{ !request('category') ? 'bg-orange-500 text-white shadow-md shadow-orange-200' : 'bg-white border border-gray-200 text-gray-500 hover:border-orange-300' }}">
        All
    </a>
    @foreach($categories as $cat)
        <a href="{{ route('recipes.index', ['category' => $cat->id]) }}"
           class="px-4 py-1.5 rounded-full text-sm font-medium transition
                  {{ request('category') == $cat->id ? 'bg-orange-500 text-white shadow-md shadow-orange-200' : 'bg-white border border-gray-200 text-gray-500 hover:border-orange-300' }}">
            {{ $cat->name }}
        </a>
    @endforeach
</div>

<!-- Grid -->
@if($recipes->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($recipes as $recipe)
            <a href="{{ route('recipes.show', $recipe) }}"
               class="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:border-orange-200 hover:shadow-xl hover:shadow-orange-50 transition-all duration-300">
               
           @if($recipe->image)
                <div class="overflow-hidden h-52">
                 <img src="{{ Storage::url($recipe->image) }}"
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
                                <span class="flex items-center gap-1">
                                    ⏱ {{ ($recipe->prep_time + $recipe->cook_time) }} min
                                </span>
                            @endif
                            @if($recipe->category)
                                <span class="bg-orange-50 text-orange-500 px-2.5 py-1 rounded-full font-medium">
                                    {{ $recipe->category->name }}
                                </span>
                            @endif
                        </div>
                        <span class="text-xs text-gray-300">by {{ $recipe->user->name }}</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    <div class="mt-10">{{ $recipes->links() }}</div>
@else
    <div class="text-center py-28">
        <p class="text-6xl mb-4">🍳</p>
        <p class="brand text-2xl font-black text-gray-300">No recipes yet</p>
        <p class="text-gray-400 mt-2">Be the first to add one!</p>
        <a href="{{ route('recipes.create') }}"
           class="btn-primary inline-block mt-6 text-white font-medium px-6 py-3 rounded-xl text-sm">
            + Add First Recipe
        </a>
    </div>
@endif

@endsection