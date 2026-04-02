@extends('layouts.app')
@section('title', 'Pending Recipes — Admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="brand text-3xl font-black text-gray-900">Pending <span class="text-orange-500">Recipes</span></h1>
        <p class="text-gray-400 text-sm mt-1">{{ $recipes->total() }} recipe(s) waiting for approval</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="text-sm text-orange-500 hover:underline">← Back to Dashboard</a>
</div>

@if($recipes->count())
    <div class="space-y-4">
        @foreach($recipes as $recipe)
            <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center gap-6">

                <!-- Image -->
                @if($recipe->image)
                    @php $imgUrl = str_starts_with($recipe->image, 'http') ? $recipe->image : asset('storage/' . $recipe->image); @endphp
                    <img src="{{ $imgUrl }}" class="w-24 h-24 rounded-xl object-cover shrink-0" alt="">
                @else
                    <div class="w-24 h-24 rounded-xl bg-orange-50 flex items-center justify-center text-3xl shrink-0">🍽️</div>
                @endif

                <!-- Info -->
                <div class="flex-1">
                    <h2 class="font-semibold text-gray-900 text-lg">{{ $recipe->title }}</h2>
                    <p class="text-gray-400 text-sm line-clamp-2 mt-1">{{ $recipe->description }}</p>
                    <div class="flex items-center gap-3 mt-2 text-xs text-gray-400">
                        <span>by <strong class="text-gray-600">{{ $recipe->user->name }}</strong></span>
                        @if($recipe->category)
                            <span class="bg-orange-50 text-orange-500 px-2 py-0.5 rounded-full">{{ $recipe->category->name }}</span>
                        @endif
                        <span>{{ $recipe->created_at->format('M d, Y') }}</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-3 shrink-0">
                    <a href="{{ route('recipes.show', $recipe) }}"
                       class="bg-gray-50 hover:bg-gray-100 text-gray-600 px-4 py-2 rounded-xl text-sm font-medium transition">
                        Preview
                    </a>
                    <form method="POST" action="{{ route('admin.recipes.approve', $recipe) }}">
                        @csrf
                        @method('PUT')
                        <button class="bg-green-50 hover:bg-green-100 text-green-600 px-4 py-2 rounded-xl text-sm font-medium transition">
                            ✓ Approve
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.recipes.reject', $recipe) }}"
                          onsubmit="return confirm('Reject this recipe?')">
                        @csrf
                        @method('PUT')
                        <button class="bg-red-50 hover:bg-red-100 text-red-500 px-4 py-2 rounded-xl text-sm font-medium transition">
                            ✕ Reject
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-6">{{ $recipes->links() }}</div>
@else
    <div class="text-center py-20 text-gray-400">
        <p class="text-5xl mb-4">✅</p>
        <p class="text-lg">No pending recipes!</p>
        <p class="text-sm mt-1">All caught up.</p>
    </div>
@endif
@endsection