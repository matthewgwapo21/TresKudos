@extends('layouts.app')
@section('title', 'Manage Categories')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-3xl font-bold">Manage Categories</h1>
    <a href="{{ route('admin.dashboard') }}" class="text-sm text-orange-500 hover:underline">← Back to Dashboard</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- Add Category -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold mb-4">Add New Category</h2>
        <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-3">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Description</label>
                <textarea name="description" rows="2"
                          class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">{{ old('description') }}</textarea>
            </div>
            <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 rounded-lg text-sm transition">
                Add Category
            </button>
        </form>
    </div>

    <!-- Category List -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-400 text-left">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Description</th>
                    <th class="px-4 py-3">Recipes</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($categories as $category)
                    <tr class="hover:bg-gray-50" id="cat-{{ $category->id }}">
                        <td class="px-4 py-3 font-medium">{{ $category->name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $category->description ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $category->recipes_count }}</td>
                        <td class="px-4 py-3 flex gap-3">
                            <!-- Edit inline -->
                            <button onclick="toggleEdit({{ $category->id }})"
                                    class="text-blue-400 hover:text-blue-600 text-xs">Edit</button>
                            <!-- Delete -->
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                  onsubmit="return confirm('Delete this category?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-400 hover:text-red-600 text-xs">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <!-- Edit row (hidden by default) -->
                    <tr id="edit-{{ $category->id }}" class="hidden bg-orange-50">
                        <td colspan="4" class="px-4 py-3">
                            <form method="POST" action="{{ route('admin.categories.update', $category) }}"
                                  class="flex gap-3 items-end flex-wrap">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Name</label>
                                    <input type="text" name="name" value="{{ $category->name }}" required
                                           class="border rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Description</label>
                                    <input type="text" name="description" value="{{ $category->description }}"
                                           class="border rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                                </div>
                                <button type="submit"
                                        class="bg-orange-500 text-white px-4 py-1.5 rounded-lg text-sm hover:bg-orange-600">
                                    Save
                                </button>
                                <button type="button" onclick="toggleEdit({{ $category->id }})"
                                        class="text-gray-400 hover:text-gray-600 text-sm">Cancel</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">{{ $categories->links() }}</div>
    </div>

</div>

<script>
function toggleEdit(id) {
    document.getElementById('edit-' + id).classList.toggle('hidden');
}
</script>
@endsection