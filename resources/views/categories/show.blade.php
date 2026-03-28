@extends('layouts.app')
@section('title', $category->name)

@section('content')
<h1 class="text-3xl font-bold mb-2">{{ $category->name }}</h1>
@if($category->description)
    <p class="text-gray-500 mb-6">{{ $category->description }}</p>
@endif

@if($recipes->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($recipes as $recipe)
            <a href="{{ route('recipes.show', $recipe) }}"
               class="bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden">
                @if($recipe->image)
                @php $imgUrl = str_starts_with($recipe->image, 'http') ? $recipe->image : asset('storage/' . $recipe->image); @endphp
                    <img src="{{ $imgUrl }}" class="w-full h-48 object-cover" alt="{{ $recipe->title }}">
                @else
                    <div class="w-full h-48 bg-orange-50 flex items-center justify-center text-4xl">🍽️</div>
                @endif
                <div class="p-4">
                    <h2 class="font-semibold text-lg mb-1">{{ $recipe->title }}</h2>
                    <p class="text-gray-500 text-sm line-clamp-2">{{ $recipe->description }}</p>
                    <p class="text-xs text-gray-400 mt-2">by {{ $recipe->user->name }}</p>
                </div>
            </a>
        @endforeach
    </div>
    <div class="mt-8">{{ $recipes->links() }}</div>
@else
    <div class="text-center py-20 text-gray-400">
        <p class="text-lg">No recipes in this category yet.</p>
    </div>
@endif
@endsection