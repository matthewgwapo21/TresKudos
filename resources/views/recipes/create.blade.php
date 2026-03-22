@extends('layouts.app')
@section('title', 'Add Recipe — TresKudos')

@section('content')
<div class="max-w-2xl mx-auto">

    <a href="{{ route('recipes.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-orange-500 transition mb-6">
        ← Back to recipes
    </a>

    <h1 class="brand text-4xl font-black text-gray-900 mb-2">Add New <span class="text-orange-500">Recipe</span></h1>
    <p class="text-gray-400 mb-8">Share your culinary creation with the community</p>

    <form method="POST" action="{{ route('recipes.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-5">
            <h2 class="font-semibold text-gray-900">Basic Info</h2>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Recipe title *</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       placeholder="e.g. Classic Carbonara"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                <textarea name="description" rows="3"
                          placeholder="What makes this recipe special?"
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Category</label>
                <select name="category_id"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition">
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Prep time (min)</label>
                    <input type="number" name="prep_time" value="{{ old('prep_time') }}" min="0"
                           placeholder="10"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Cook time (min)</label>
                    <input type="number" name="cook_time" value="{{ old('cook_time') }}" min="0"
                           placeholder="20"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Recipe photo</label>
                <input type="file" name="image" accept="image/*"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-500 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100">
            </div>
        </div>

        <!-- Ingredients -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="font-semibold text-gray-900 mb-4">Ingredients *</h2>
            <div id="ingredients" class="space-y-3">
                <div class="flex gap-2 ingredient-row">
                    <input type="text" name="ingredients[0][quantity]" placeholder="Qty"
                           class="w-20 border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition">
                    <input type="text" name="ingredients[0][unit]" placeholder="Unit"
                           class="w-24 border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition">
                    <input type="text" name="ingredients[0][name]" placeholder="Ingredient name" required
                           class="flex-1 border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition">
                </div>
            </div>
            <button type="button" onclick="addIngredient()"
                    class="mt-3 text-orange-500 hover:text-orange-600 text-sm font-medium flex items-center gap-1">
                + Add ingredient
            </button>
        </div>

        <!-- Steps -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="font-semibold text-gray-900 mb-4">Instructions *</h2>
            <div id="steps" class="space-y-3">
                <div class="flex gap-3 step-row">
                    <span class="btn-primary text-white rounded-xl w-8 h-8 flex items-center justify-center text-sm font-bold shrink-0 mt-2">1</span>
                    <textarea name="steps[0]" rows="2" placeholder="Describe this step..." required
                              class="flex-1 border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition"></textarea>
                </div>
            </div>
            <button type="button" onclick="addStep()"
                    class="mt-3 text-orange-500 hover:text-orange-600 text-sm font-medium flex items-center gap-1">
                + Add step
            </button>
        </div>

        <button type="submit"
                class="btn-primary w-full text-white font-semibold py-4 rounded-xl text-sm">
            Publish Recipe →
        </button>
    </form>
</div>

<script>
let ingredientCount = 1;
let stepCount = 1;

function addIngredient() {
    const i = ingredientCount++;
    document.getElementById('ingredients').insertAdjacentHTML('beforeend', `
        <div class="flex gap-2 ingredient-row">
            <input type="text" name="ingredients[${i}][quantity]" placeholder="Qty"
                   class="w-20 border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition">
            <input type="text" name="ingredients[${i}][unit]" placeholder="Unit"
                   class="w-24 border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition">
            <input type="text" name="ingredients[${i}][name]" placeholder="Ingredient name" required
                   class="flex-1 border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition">
            <button type="button" onclick="this.parentElement.remove()" class="text-red-300 hover:text-red-500 text-xl font-light">&times;</button>
        </div>
    `);
}

function addStep() {
    const i = stepCount++;
    document.getElementById('steps').insertAdjacentHTML('beforeend', `
        <div class="flex gap-3 step-row">
            <span class="bg-gradient-to-br from-orange-400 to-orange-600 text-white rounded-xl w-8 h-8 flex items-center justify-center text-sm font-bold shrink-0 mt-2">${i + 1}</span>
            <textarea name="steps[${i}]" rows="2" placeholder="Describe this step..." required
                      class="flex-1 border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition"></textarea>
            <button type="button" onclick="this.parentElement.remove()" class="text-red-300 hover:text-red-500 text-xl font-light mt-2">&times;</button>
        </div>
    `);
}
</script>
@endsection