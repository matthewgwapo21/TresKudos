@extends('layouts.app')
@section('title', 'Edit Recipe — TresKudos')

@section('content')
<div class="max-w-2xl mx-auto">

    <a href="{{ route('recipes.show', $recipe) }}"
       class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-orange-500 transition mb-6">
        ← Back to recipe
    </a>

    <h1 class="brand text-4xl font-black text-gray-900 mb-2">Edit <span class="text-orange-500">Recipe</span></h1>
    <p class="text-gray-400 mb-8">Update your recipe details</p>

    <form method="POST" action="{{ route('recipes.update', $recipe) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-5">
            <h2 class="font-semibold text-gray-900">Basic Info</h2>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Recipe title *</label>
                <input type="text" name="title" value="{{ old('title', $recipe->title) }}" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                <textarea name="description" rows="3"
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition">{{ old('description', $recipe->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Category</label>
                <select name="category_id"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition">
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id', $recipe->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Prep time (min)</label>
                    <input type="number" name="prep_time" value="{{ old('prep_time', $recipe->prep_time) }}" min="0"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Cook time (min)</label>
                    <input type="number" name="cook_time" value="{{ old('cook_time', $recipe->cook_time) }}" min="0"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 transition">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Recipe photo</label>
                @if($recipe->image)
                    <div class="mb-3">
                        <img src="{{ Storage::url($recipe->image) }}"
                             class="h-32 rounded-xl object-cover" alt="Current photo">
                        <p class="text-xs text-gray-400 mt-1">Current photo — upload a new one to replace it</p>
                    </div>
                @endif
                <input type="file" name="image" accept="image/*"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-500 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100">
            </div>
        </div>

        <!-- Ingredients -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="font-semibold text-gray-900 mb-4">Ingredients *</h2>
            <div id="ingredients" class="space-y-3">
                @foreach($recipe->ingredients as $i => $ingredient)
                    <div class="flex gap-2 ingredient-row">
                        <input type="text" name="ingredients[{{ $i }}][quantity]"
                               value="{{ $ingredient->quantity }}" placeholder="Qty"
                               class="w-20 border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition">
                        <input type="text" name="ingredients[{{ $i }}][unit]"
                               value="{{ $ingredient->unit }}" placeholder="Unit"
                               class="w-24 border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition">
                        <input type="text" name="ingredients[{{ $i }}][name]"
                               value="{{ $ingredient->name }}" placeholder="Ingredient name" required
                               class="flex-1 border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition">
                        <button type="button" onclick="this.parentElement.remove()"
                                class="text-red-300 hover:text-red-500 text-xl font-light">&times;</button>
                    </div>
                @endforeach
            </div>
            <button type="button" onclick="addIngredient()"
                    class="mt-3 text-orange-500 hover:text-orange-600 text-sm font-medium">
                + Add ingredient
            </button>
        </div>

        <!-- Steps -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="font-semibold text-gray-900 mb-4">Instructions *</h2>
            <div id="steps" class="space-y-3">
                @foreach($recipe->steps as $i => $step)
                    <div class="flex gap-3 step-row">
                        <span class="btn-primary text-white rounded-xl w-8 h-8 flex items-center justify-center text-sm font-bold shrink-0 mt-2">
                            {{ $step->step_number }}
                        </span>
                        <textarea name="steps[{{ $i }}]" rows="2" required
                                  class="flex-1 border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition">{{ $step->body }}</textarea>
                        <button type="button" onclick="this.parentElement.remove()"
                                class="text-red-300 hover:text-red-500 text-xl font-light mt-2">&times;</button>
                    </div>
                @endforeach
            </div>
            <button type="button" onclick="addStep()"
                    class="mt-3 text-orange-500 hover:text-orange-600 text-sm font-medium">
                + Add step
            </button>
        </div>

        <button type="submit"
                class="btn-primary w-full text-white font-semibold py-4 rounded-xl text-sm">
            Save Changes →
        </button>
    </form>
</div>

<script>
let ingredientCount = {{ $recipe->ingredients->count() }};
let stepCount = {{ $recipe->steps->count() }};

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
            <textarea name="steps[${i}]" rows="2" required
                      class="flex-1 border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition"></textarea>
            <button type="button" onclick="this.parentElement.remove()" class="text-red-300 hover:text-red-500 text-xl font-light mt-2">&times;</button>
        </div>
    `);
}
</script>
@endsection