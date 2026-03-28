@extends('layouts.app')
@section('title', 'Manage Users')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="brand text-3xl font-black text-gray-900">All <span class="text-orange-500">Users</span></h1>
    <a href="{{ route('admin.dashboard') }}" class="text-sm text-orange-500 hover:underline">← Back to Dashboard</a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-400 text-left">
            <tr>
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">Role</th>
                <th class="px-4 py-3">Recipes</th>
                <th class="px-4 py-3">Favorites</th>
                <th class="px-4 py-3">Joined</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $user->email }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs {{ $user->role === 'admin' ? 'bg-orange-100 text-orange-600' : 'bg-gray-100 text-gray-500' }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ $user->recipes_count }}</td>
                    <td class="px-4 py-3">{{ $user->favorites_count }}</td>
                    <td class="px-4 py-3 text-gray-400">{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-3">
                        @if($user->role !== 'admin')
                            <form method="POST" action="{{ route('admin.users.promote', $user) }}">
                                @csrf
                                @method('PUT')
                                <button class="text-xs text-orange-500 hover:text-orange-700 font-medium transition">
                                    Make Admin
                                </button>
                            </form>
                        @else
                            @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.demote', $user) }}"
                                      onsubmit="return confirm('Remove admin from {{ $user->name }}?')">
                                    @csrf
                                    @method('PUT')
                                    <button class="text-xs text-red-400 hover:text-red-600 font-medium transition">
                                        Remove Admin
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-gray-300">You</span>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $users->links() }}</div>
@endsection