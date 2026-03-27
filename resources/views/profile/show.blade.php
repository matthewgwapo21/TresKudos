@extends('layouts.app')
@section('title', $user->name . ' — TresKudos')

@section('content')
<div class="max-w-4xl mx-auto">

    <!-- Profile header -->
    <div class="bg-white rounded-2xl border border-gray-100 p-8 mb-8 flex items-center gap-8">
        <!-- Avatar -->
        <div class="shrink-0">
            @if($user->avatar)
                <img src="{{ Storage::url($user->avatar) }}"
                     class="w-24 h-24 rounded-full object-cover border-4 border-orange-100"
                     alt="{{ $user->name }}">
            @else
                <div class="w-24 h-24 rounded-full bg-orange-100 flex items-center justify-center text-3xl font-black text-orange-400">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
        </div>

        <!-- Info -->
        <div class="flex-1">
            <h1 class="brand text-3xl font-black text-gray-900 mb-1">{{ $user->name }}</h1>
            @if($user->bio)
                <p class="text-gray-500 mb-3">{{ $user->bio }}</p>
            @endif
            <div class="flex items-center gap-4 text-sm text-gray-400">
                <span>{{ $user->recipes()->count() }} recipes</span>
                <span>Joined {{ $user->created_at->format('M Y') }}</span>
                @if($user->role === 'admin')
                    <span class="bg-orange-100 text-orange-600 px-2.5 py-0.5 rounded-full text-xs font-medium">Admin</span>
                @endif
            </div>
        </div>

        <!-- Edit button (own profile only) -->
        @if(auth()->id() === $user->id)
            <a href="{{ route('profile.edit') }}"
               class="btn-primary text-white px-5 py-2.5 rounded-xl text-sm font-medium shrink-0">
                Edit Profile
            </a>
        @endif
    </div>

    <!-- User's recipes -->
    <h2 class="brand text-2xl font-black text-gray-900 mb-6">
        {{ auth()->id() === $user->id ? 'My Recipes' : $user->name . "'s Recipes" }}
    </h2>

    @if($recipes->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($recipes as $recipe)
                <a href="{{ route('recipes.show', $recipe) }}"
                   class="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:border-orange-200 hover:shadow-xl hover:shadow-orange-50 transition-all duration-300">
                    @if($recipe->image)
                        <div class="overflow-hidden h-48">
                            <img src="{{ Storage::url($recipe->image) }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 alt="{{ $recipe->title }}">
                        </div>
                    @else
                        <div class="h-48 bg-orange-50 flex items-center justify-center text-4xl">🍽️</div>
                    @endif
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 mb-1 group-hover:text-orange-500 transition">
                            {{ $recipe->title }}
                        </h3>
                        <div class="flex items-center gap-2 text-xs text-gray-400">
                            @if($recipe->prep_time || $recipe->cook_time)
                                <span>⏱ {{ $recipe->prep_time + $recipe->cook_time }} min</span>
                            @endif
                            @if($recipe->category)
                                <span class="bg-orange-50 text-orange-500 px-2 py-0.5 rounded-full">
                                    {{ $recipe->category->name }}
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-8">{{ $recipes->links() }}</div>
    @else
        <div class="text-center py-20 text-gray-400">
            <p class="text-5xl mb-4">🍳</p>
            <p class="text-lg">No recipes yet.</p>
            @if(auth()->id() === $user->id)
                <a href="{{ route('recipes.create') }}"
                   class="btn-primary inline-block mt-4 text-white px-6 py-3 rounded-xl text-sm font-medium">
                    Add Your First Recipe
                </a>
            @endif
        </div>
    @endif

</div>
@endsection