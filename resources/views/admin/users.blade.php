@extends('layouts.app')
@section('title', 'Manage Users')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-3xl font-bold">All Users</h1>
    <a href="{{ route('admin.dashboard') }}" class="text-sm text-orange-500 hover:underline">← Back to Dashboard</a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-400 text-left">
            <tr>
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">Role</th>
                <th class="px-4 py-3">Recipes</th>
                <th class="px-4 py-3">Favorites</th>
                <th class="px-4 py-3">Joined</th>
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
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $users->links() }}</div>
@endsection