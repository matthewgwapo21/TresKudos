@extends('layouts.app')
@section('title', 'Forum Management — Admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="brand text-3xl font-black text-gray-900">Forum <span class="text-orange-500">Management</span></h1>
    <a href="{{ route('admin.dashboard') }}" class="text-sm text-orange-500 hover:underline">← Back to Dashboard</a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-400 text-left">
            <tr>
                <th class="px-4 py-3">Topic</th>
                <th class="px-4 py-3">By</th>
                <th class="px-4 py-3">Category</th>
                <th class="px-4 py-3">Replies</th>
                <th class="px-4 py-3">Posted</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($topics as $topic)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <a href="{{ route('forum.show', $topic) }}"
                           class="font-medium text-gray-900 hover:text-orange-500 transition">
                            @if($topic->is_pinned) 📌 @endif
                            @if($topic->is_closed) 🔒 @endif
                            {{ Str::limit($topic->title, 40) }}
                        </a>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $topic->user->name }}</td>
                    <td class="px-4 py-3">
                        <span class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full text-xs capitalize">
                            {{ str_replace('-', ' ', $topic->category) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ $topic->replies_count }}</td>
                    <td class="px-4 py-3 text-gray-400">{{ $topic->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('admin.forum.pin', $topic) }}">
                                @csrf @method('PUT')
                                <button class="text-xs text-orange-500 hover:text-orange-700 font-medium">
                                    {{ $topic->is_pinned ? 'Unpin' : 'Pin' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.forum.close', $topic) }}">
                                @csrf @method('PUT')
                                <button class="text-xs text-gray-500 hover:text-gray-700 font-medium">
                                    {{ $topic->is_closed ? 'Reopen' : 'Close' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.forum.destroy', $topic) }}"
                                  onsubmit="return confirm('Delete this topic?')">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-400 hover:text-red-600 font-medium">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $topics->links() }}</div>
@endsection