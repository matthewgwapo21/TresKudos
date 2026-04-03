@extends('layouts.app')
@section('title', 'Community Forum — TresKudos')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="brand text-5xl font-black text-gray-900 mb-1">Community <span class="text-orange-500">Forum</span></h1>
        <p class="text-gray-400">Ask questions, share tips, give feedback</p>
    </div>
    <a href="{{ route('forum.create') }}"
       class="btn-primary text-white font-medium px-5 py-2.5 rounded-xl text-sm">
        + New Topic
    </a>
</div>

<!-- Category filter -->
<div class="flex gap-2 flex-wrap mb-6">
    @foreach(['all' => 'All', 'general' => '💬 General', 'recipe-help' => '🍳 Recipe Help', 'feedback' => '💡 Feedback', 'bug-report' => '🐛 Bug Report'] as $value => $label)
        <a href="{{ request()->fullUrlWithQuery(['category' => $value === 'all' ? null : $value]) }}"
           class="px-4 py-1.5 rounded-full text-sm font-medium transition
                  {{ request('category', 'all') === $value ? 'bg-orange-500 text-white' : 'bg-white border border-gray-200 text-gray-500 hover:border-orange-300' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

@if($topics->count())
    <div class="space-y-3">
        @foreach($topics as $topic)
            <a href="{{ route('forum.show', $topic) }}"
               class="block bg-white rounded-2xl border {{ $topic->is_pinned ? 'border-orange-200' : 'border-gray-100' }} p-5 hover:border-orange-300 hover:shadow-md transition">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
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
                        <h2 class="font-semibold text-gray-900 text-lg hover:text-orange-500 transition">
                            {{ $topic->title }}
                        </h2>
                        <p class="text-gray-400 text-sm line-clamp-2 mt-1">{{ $topic->body }}</p>
                    </div>
                    <div class="text-center shrink-0">
                        <p class="text-2xl font-black text-gray-900">{{ $topic->replies_count }}</p>
                        <p class="text-xs text-gray-400">replies</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 mt-3 text-xs text-gray-400">
                    @if($topic->user->avatar && str_starts_with($topic->user->avatar, 'http'))
                        <img src="{{ $topic->user->avatar }}" class="w-5 h-5 rounded-full object-cover" alt="">
                    @else
                        <div class="w-5 h-5 rounded-full bg-orange-100 flex items-center justify-center text-xs font-black text-orange-400">
                            {{ strtoupper(substr($topic->user->name, 0, 1)) }}
                        </div>
                    @endif
                    <span>{{ $topic->user->name }}</span>
                    <span>·</span>
                    <span>{{ $topic->created_at->diffForHumans() }}</span>
                </div>
            </a>
        @endforeach
    </div>
    <div class="mt-6">{{ $topics->links() }}</div>
@else
    <div class="text-center py-20 text-gray-400">
        <p class="text-5xl mb-4">💬</p>
        <p class="brand text-2xl font-black text-gray-300">No topics yet</p>
        <p class="mt-2">Be the first to start a discussion!</p>
        <a href="{{ route('forum.create') }}"
           class="btn-primary inline-block mt-6 text-white font-medium px-6 py-3 rounded-xl text-sm">
            Start a Topic
        </a>
    </div>
@endif
@endsection