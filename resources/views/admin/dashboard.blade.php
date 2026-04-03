@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold">Admin Dashboard</h1>
    <div class="flex gap-3">
        <a href="{{ route('admin.users') }}" class="bg-white border px-4 py-2 rounded-lg text-sm hover:border-orange-400">Manage Users</a>
        <a href="{{ route('admin.categories.index') }}" class="bg-white border px-4 py-2 rounded-lg text-sm hover:border-orange-400">Manage Categories</a>
        <a href="{{ route('admin.recipes.pending') }}"
             class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-orange-600 relative">
                Pending Recipes
                    @php $pendingCount = \App\Models\Recipe::pending()->count(); @endphp
                    @if($pendingCount)
                <span class="ml-1 bg-white text-orange-500 text-xs font-bold px-1.5 py-0.5 rounded-full">
                    {{ $pendingCount }}
                </span>
                    @endif
        </a>
        <a href="{{ route('admin.statistics') }}"
             class="bg-white border border-gray-200 hover:border-orange-300 text-gray-700 px-4 py-2 rounded-lg text-sm transition">
             📊 Statistics
        </a>
        <a href="{{ route('admin.forum') }}"
            class="bg-white border border-gray-200 hover:border-orange-300 text-gray-700 px-4 py-2 rounded-lg text-sm transition">
             💬 Forum
        </a>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
    <div class="bg-white rounded-xl shadow-sm p-6 text-center">
        <p class="text-4xl font-bold text-orange-500">{{ $stats['total_users'] }}</p>
        <p class="text-gray-500 text-sm mt-1">Total Users</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 text-center">
        <p class="text-4xl font-bold text-orange-500">{{ $stats['total_recipes'] }}</p>
        <p class="text-gray-500 text-sm mt-1">Total Recipes</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 text-center">
        <p class="text-4xl font-bold text-orange-500">{{ $stats['total_categories'] }}</p>
        <p class="text-gray-500 text-sm mt-1">Categories</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 text-center">
        <p class="text-4xl font-bold text-orange-500">{{ $stats['total_favorites'] }}</p>
        <p class="text-gray-500 text-sm mt-1">Total Favorites</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

    <!-- Latest Users -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold mb-4">Latest Users</h2>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-400 border-b">
                    <th class="pb-2">Name</th>
                    <th class="pb-2">Email</th>
                    <th class="pb-2">Role</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($latestUsers as $user)
                    <tr>
                        <td class="py-2">{{ $user->name }}</td>
                        <td class="py-2 text-gray-500">{{ $user->email }}</td>
                        <td class="py-2">
                            <span class="px-2 py-0.5 rounded-full text-xs {{ $user->role === 'admin' ? 'bg-orange-100 text-orange-600' : 'bg-gray-100 text-gray-500' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('admin.users') }}" class="text-orange-500 text-sm mt-4 inline-block hover:underline">View all users →</a>
    </div>

    <!-- Latest Recipes -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold mb-4">Latest Recipes</h2>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-400 border-b">
                    <th class="pb-2">Title</th>
                    <th class="pb-2">By</th>
                    <th class="pb-2">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($latestRecipes as $recipe)
                    <tr>
                        <td class="py-2">
                            <a href="{{ route('recipes.show', $recipe) }}" class="hover:text-orange-500">
                                {{ Str::limit($recipe->title, 30) }}
                            </a>
                        </td>
                        <td class="py-2 text-gray-500">{{ $recipe->user->name }}</td>
                        <td class="py-2">
                            <form method="POST" action="{{ route('admin.recipes.destroy', $recipe) }}"
                                  onsubmit="return confirm('Delete this recipe?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-400 hover:text-red-600 text-xs">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection