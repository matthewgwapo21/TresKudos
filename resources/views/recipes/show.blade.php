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
        @php $imgUrl = str_starts_with($recipe->image, 'http') ? $recipe->image : asset('storage/' . $recipe->image); @endphp
        <img src="{{ $imgUrl }}" class="w-full h-full object-cover" alt="{{ $recipe->title }}">
    </div>
@endif

    <!-- Header -->
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="brand text-4xl font-black text-gray-900 mb-2">{{ $recipe->title }}</h1>
            <div class="flex items-center gap-3 text-sm text-gray-400">
                <span>by <strong class="text-gray-600">{{ $recipe->user->name }} · {{ $recipe->created_at->format('M d, Y') }}</strong></span>
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
        <!-- Reviews section -->
<div class="mt-10">
    <h2 class="brand text-2xl font-black text-gray-900 mb-6">
        Reviews
        @if($recipe->reviews->count())
            <span class="text-orange-500">
                {{ $recipe->averageRating() }} ★
            </span>
            <span class="text-gray-300 text-lg font-normal">({{ $recipe->reviews->count() }})</span>
        @endif
    </h2>

    <!-- Submit review form -->
    @if(!$userReview)
        <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-6">
            <h3 class="font-semibold text-gray-900 mb-4">Leave a Review</h3>
            <form method="POST" action="{{ route('reviews.store', $recipe) }}" class="space-y-4">
                @csrf

                <!-- Star rating -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating *</label>
                    <div class="flex gap-2" id="star-rating">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button"
                                    onclick="setRating({{ $i }})"
                                    class="star text-3xl text-gray-200 hover:text-orange-400 transition cursor-pointer"
                                    data-value="{{ $i }}">★</button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating-input" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Comment (optional)</label>
                    <textarea name="body" rows="3"
                              placeholder="Share your experience with this recipe..."
                              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition"></textarea>
                </div>

                <button type="submit"
                        class="btn-primary text-white px-6 py-2.5 rounded-xl text-sm font-medium">
                    Submit Review
                </button>
            </form>
        </div>
    @else
        <!-- User already reviewed -->
        <div class="bg-orange-50 border border-orange-100 rounded-2xl p-4 mb-6 flex items-center justify-between">
            <div>
                <p class="text-orange-600 font-medium text-sm">You rated this recipe</p>
                <p class="text-orange-400">
                    @for($i = 1; $i <= 5; $i++)
                        {{ $i <= $userReview->rating ? '★' : '☆' }}
                    @endfor
                </p>
            </div>
            <form method="POST" action="{{ route('reviews.destroy', $recipe) }}">
                @csrf
                @method('DELETE')
                <button class="text-red-400 hover:text-red-600 text-sm">Remove review</button>
            </form>
        </div>
    @endif

    <!-- All reviews -->
    @if($recipe->reviews->count())
        <div class="space-y-4">
            @foreach($recipe->reviews as $review)
                <div class="bg-white rounded-2xl border border-gray-100 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                           @if($review->user->avatar && str_starts_with($review->user->avatar, 'http'))
                                <img src="{{ $review->user->avatar }}"
                                    class="w-9 h-9 rounded-full object-cover shrink-0" alt="">
                            @else
                                <div class="w-9 h-9 rounded-full bg-orange-100 flex items-center justify-center text-sm font-black text-orange-400 shrink-0">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-medium text-gray-900 text-sm">{{ $review->user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="text-orange-400 text-lg">
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= $review->rating ? '★' : '☆' }}
                            @endfor
                        </div>
                    </div>
                    @if($review->body)
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $review->body }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-10 text-gray-400">
            <p class="text-4xl mb-2">⭐</p>
            <p>No reviews yet. Be the first!</p>
        </div>
    @endif
</div>
<!-- Comments section -->
<div class="mt-10">
   <h2 class="brand text-2xl font-black text-gray-900 mb-4">
    Comments
    @if($comments->count())
        <span class="text-gray-300 text-lg font-normal">({{ $recipe->comments->count() }})</span>
    @endif
</h2>
<div class="flex gap-2 mb-6">
    <a href="{{ request()->fullUrlWithQuery(['comment_sort' => 'latest']) }}"
       class="px-3 py-1 rounded-full text-xs font-medium {{ request('comment_sort', 'latest') === 'latest' ? 'bg-orange-500 text-white' : 'bg-white border border-gray-200 text-gray-500' }}">
        Latest
    </a>
    <a href="{{ request()->fullUrlWithQuery(['comment_sort' => 'oldest']) }}"
       class="px-3 py-1 rounded-full text-xs font-medium {{ request('comment_sort') === 'oldest' ? 'bg-orange-500 text-white' : 'bg-white border border-gray-200 text-gray-500' }}">
        Oldest
    </a>
</div>

    <!-- Post comment form -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-6">
        <form method="POST" action="{{ route('comments.store', $recipe) }}" class="flex gap-3">
            @csrf
            @if(auth()->user()->avatar && str_starts_with(auth()->user()->avatar, 'http'))
                <img src="{{ auth()->user()->avatar }}"
                    class="w-9 h-9 rounded-full object-cover shrink-0" alt="">
            @else
                <div class="w-9 h-9 rounded-full bg-orange-100 flex items-center justify-center text-sm font-black text-orange-400 shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif
            <div class="flex-1 flex gap-3">
                <textarea name="body" rows="1"
                          placeholder="Write a comment..."
                          class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition resize-none"></textarea>
                <button type="submit"
                        class="btn-primary text-white px-5 py-2.5 rounded-xl text-sm font-medium shrink-0">
                    Post
                </button>
            </div>
        </form>
    </div>

    <!-- Comment list -->
    @if($comments->count())
        <div class="space-y-4">
            @foreach($comments as $comment)
                <div class="bg-white rounded-2xl border border-gray-100 p-5 flex gap-4">
                  @if($comment->user->avatar && str_starts_with($comment->user->avatar, 'http'))
                    <img src="{{ $comment->user->avatar }}"
                        class="w-9 h-9 rounded-full object-cover shrink-0" alt="">
                @else
                <div class="w-9 h-9 rounded-full bg-orange-100 flex items-center justify-center text-sm font-black text-orange-400 shrink-0">
                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                </div>
                @endif
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <div class="flex items-center gap-2">
                                <span class="font-medium text-gray-900 text-sm">{{ $comment->user->name }}</span>
                                <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            @if(auth()->id() === $comment->user_id || auth()->user()->isAdmin())
                                <form method="POST" action="{{ route('comments.destroy', $comment) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-300 hover:text-red-500 text-xs transition">Delete</button>
                                </form>
                            @endif
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $comment->body }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-10 text-gray-400">
            <p class="text-4xl mb-2">💬</p>
            <p>No comments yet. Start the conversation!</p>
        </div>
    @endif
</div>

<script>
function setRating(value) {
    document.getElementById('rating-input').value = value;
    document.querySelectorAll('.star').forEach((star, index) => {
        star.style.color = index < value ? '#f97316' : '#e5e7eb';
    });
}
</script>
   

</div>
@endsection