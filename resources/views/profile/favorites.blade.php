@extends('layouts.app')
@section('title', 'My Favorites — TresKudos')

@section('content')

<h1 class="brand text-5xl font-black text-gray-900 mb-2">My <span class="text-orange-500">Favorites</span></h1>
<p class="text-gray-400 mb-10">Recipes you've saved for later</p>

@if($favorites->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($favorites as $favorite)
            <a href="{{ route('recipes.show', $favorite->recipe) }}"
               class="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:border-orange-200 hover:shadow-xl hover:shadow-orange-50 transition-all duration-300">
                @if($favorite->recipe->image)
                    <div class="overflow-hidden h-52">
                        <img src="{{ Storage::url($favorite->recipe->image) }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             alt="{{ $favorite->recipe->title }}">
                    </div>
                @else
                    <div class="h-52 bg-orange-50 flex items-center justify-center text-5xl">🍽️</div>
                @endif
                <div class="p-5">
                    <h2 class="font-semibold text-gray-900 text-lg mb-1 group-hover:text-orange-500 transition">
                        {{ $favorite->recipe->title }}
                    </h2>
                    <p class="text-gray-400 text-sm line-clamp-2 mb-3">{{ $favorite->recipe->description }}</p>
                    <p class="text-xs text-gray-300">by {{ $favorite->recipe->user->name }}</p>
                </div>
            </a>
        @endforeach
    </div>
    <div class="mt-10">{{ $favorites->links() }}</div>
@else
    <div class="text-center py-28">
        <p class="text-6xl mb-4">🤍</p>
        <p class="brand text-2xl font-black text-gray-300">No favorites yet</p>
        <p class="text-gray-400 mt-2">Start exploring and save recipes you love</p>
        <a href="{{ route('recipes.index') }}"
           class="btn-primary inline-block mt-6 text-white font-medium px-6 py-3 rounded-xl text-sm">
            Browse Recipes
        </a>
    </div>
@endif

@endsection