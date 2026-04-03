@extends('layouts.app')
@section('title', 'New Topic — Forum')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('forum.index') }}"
       class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-orange-500 transition mb-6">
        ← Back to Forum
    </a>

    <h1 class="brand text-4xl font-black text-gray-900 mb-2">New <span class="text-orange-500">Topic</span></h1>
    <p class="text-gray-400 mb-8">Start a discussion with the community</p>

    <form method="POST" action="{{ route('forum.store') }}" class="space-y-5">
        @csrf

        <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Category *</label>
                <select name="category" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition">
                    <option value="general">💬 General</option>
                    <option value="recipe-help">🍳 Recipe Help</option>
                    <option value="feedback">💡 Feedback</option>
                    <option value="bug-report">🐛 Bug Report</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       placeholder="What's your topic about?"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Description *</label>
                <textarea name="body" rows="6" required
                          placeholder="Describe your topic in detail..."
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition">{{ old('body') }}</textarea>
            </div>
        </div>

        <button type="submit"
                class="btn-primary w-full text-white font-semibold py-4 rounded-xl text-sm">
            Post Topic →
        </button>
    </form>
</div>
@endsection