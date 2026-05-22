<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\ActivityHelper;

class AdminCategoryController extends Controller {
    public function index() {
        $categories = Category::withCount('recipes')->latest()->paginate(20);
        return view('admin.categories', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);
        Category::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
        ]);
        ActivityHelper::log('Added Category', auth()->user()->name . ' added category "' . $request->name . '"');
        return back()->with('success', 'Category created!');
    }

    public function update(Request $request, Category $category) {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);
        $category->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
        ]);
        ActivityHelper::log('Edited Category', auth()->user()->name . ' edited category "' . $category->name . '"');
        return back()->with('success', 'Category updated!');
    }

    public function destroy(Category $category) {
        ActivityHelper::log('Deleted Category', auth()->user()->name . ' deleted category "' . $category->name . '"');
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }
}