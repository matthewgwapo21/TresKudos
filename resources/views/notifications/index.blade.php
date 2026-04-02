@extends('layouts.app')
@section('title', 'Notifications — TresKudos')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="brand text-4xl font-black text-gray-900">Notifications</h1>
        @if(auth()->user()->unreadNotifications()->count())
            <form method="POST" action="{{ route('notifications.markAllRead') }}">
                @csrf
                <button class="text-sm text-orange-500 hover:text-orange-600 font-medium">
                    Mark all as read
                </button>
            </form>
        @endif
    </div>

    @if($notifications->count())
        <div class="space-y-3">
            @foreach($notifications as $notification)
                <div class="bg-white rounded-2xl border {{ !$notification->is_read ? 'border-orange-200 bg-orange-50' : 'border-gray-100' }} p-5 flex items-start justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="text-2xl shrink-0">
                            @if($notification->type === 'favorite') ❤️
                            @elseif($notification->type === 'admin') ⚙️
                            @elseif($notification->type === 'recipe') 🍽️
                            @elseif($notification->type === 'comment') 💬
                            @else 🔔
                            @endif
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">{{ $notification->title }}</p>
                            <p class="text-gray-500 text-sm mt-0.5">{{ $notification->message }}</p>
                            @if($notification->link)
                                <a href="{{ $notification->link }}"
                                   class="text-orange-500 hover:text-orange-600 text-xs font-medium mt-1 inline-block">
                                    View →
                                </a>
                            @endif
                            <p class="text-xs text-gray-300 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('notifications.destroy', $notification) }}">
                        @csrf
                        @method('DELETE')
                        <button class="text-gray-300 hover:text-red-400 text-lg shrink-0">&times;</button>
                    </form>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $notifications->links() }}</div>
    @else
        <div class="text-center py-20 text-gray-400">
            <p class="text-5xl mb-4">🔔</p>
            <p class="text-lg">No notifications yet</p>
        </div>
    @endif
</div>
@endsection