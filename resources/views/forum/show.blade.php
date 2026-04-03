@extends('layouts.app')
@section('title', $topic->title . ' — Forum')

@section('content')
<div class="max-w-3xl mx-auto">

    <a href="{{ route('forum.index') }}"
       class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-orange-500 transition mb-6">
        ← Back to Forum
    </a>

    <!-- Topic -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-6">
        <div class="flex items-start justify-between mb-4">
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-2">
                    @if($topic->is_pinned)
                        <span class="bg-orange-100 text-orange-600 text-xs font-medium px-2 py-0.5 rounded-full">📌 Pinned</span>
                    @endif
                    @if($topic->is_closed)
                        <span class="bg-gray-100 text-gray-500 text-xs font-medium px-2 py-0.5 rounded-full">🔒 Closed</span>
                    @endif
                    <span class="bg-blue-50 text-blue-600 text-xs font-medium px-2 py-0.5 rounded-full capitalize">
                        {{ str_replace('-', ' ', $topic->category) }}
                    </span>
                </div>
                <h1 class="brand text-3xl font-black text-gray-900">{{ $topic->title }}</h1>
            </div>
            @if(auth()->id() === $topic->user_id || auth()->user()->isAdmin())
                <form method="POST" action="{{ route('forum.destroy', $topic) }}"
                      onsubmit="return confirm('Delete this topic?')">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-400 hover:text-red-600 text-sm">Delete</button>
                </form>
            @endif
        </div>

        <div class="flex items-center gap-3 mb-4 text-sm text-gray-400">
            @if($topic->user->avatar && str_starts_with($topic->user->avatar, 'http'))
                <img src="{{ $topic->user->avatar }}" class="w-8 h-8 rounded-full object-cover" alt="">
            @else
                <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center text-sm font-black text-orange-400">
                    {{ strtoupper(substr($topic->user->name, 0, 1)) }}
                </div>
            @endif
            <span class="font-medium text-gray-700">{{ $topic->user->name }}</span>
            <span>·</span>
            <span>{{ $topic->created_at->format('M d, Y') }}</span>
        </div>

        <p class="text-gray-700 leading-relaxed">{{ $topic->body }}</p>
    </div>

    <!-- Replies -->
    <h2 class="brand text-2xl font-black text-gray-900 mb-4">
        Replies
        <span class="text-gray-300 text-lg font-normal">({{ $topic->replies->count() }})</span>
    </h2>

    @if($topic->replies->count())
        <div class="space-y-4 mb-6">
            @foreach($topic->replies as $reply)
                <div class="bg-white rounded-2xl border border-gray-100 p-5 flex gap-4">
                    @if($reply->user->avatar && str_starts_with($reply->user->avatar, 'http'))
                        <img src="{{ $reply->user->avatar }}" class="w-9 h-9 rounded-full object-cover shrink-0" alt="">
                    @else
                        <div class="w-9 h-9 rounded-full bg-orange-100 flex items-center justify-center text-sm font-black text-orange-400 shrink-0">
                            {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <div class="flex items-center gap-2">
                                <span class="font-medium text-gray-900 text-sm">{{ $reply->user->name }}</span>
                                @if($reply->user->role === 'admin')
                                    <span class="bg-orange-100 text-orange-600 text-xs px-2 py-0.5 rounded-full">Admin</span>
                                @endif
                                <span class="text-xs text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                            </div>
                            @if(auth()->id() === $reply->user_id || auth()->user()->isAdmin())
                                <form method="POST" action="{{ route('forum.reply.destroy', $reply) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-300 hover:text-red-500 text-xs">Delete</button>
                                </form>
                            @endif
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $reply->body }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-10 text-gray-400 mb-6">
            <p class="text-4xl mb-2">💬</p>
            <p>No replies yet. Be the first to reply!</p>
        </div>
    @endif

    <!-- Reply form -->
    @if(!$topic->is_closed)
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Post a Reply</h3>
            <form method="POST" action="{{ route('forum.reply', $topic) }}" class="space-y-4">
                @csrf
                <textarea name="body" rows="4" required
                          placeholder="Write your reply..."
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition"></textarea>
                <button type="submit"
                        class="btn-primary text-white font-medium px-6 py-2.5 rounded-xl text-sm">
                    Post Reply →
                </button>
            </form>
        </div>
    @else
        <div class="bg-gray-50 rounded-2xl border border-gray-200 p-4 text-center text-gray-400 text-sm">
            🔒 This topic is closed. No new replies allowed.
        </div>
    @endif

</div>
@endsection