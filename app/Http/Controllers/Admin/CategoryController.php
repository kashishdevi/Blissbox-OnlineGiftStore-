<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    // Display all categories
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        $data = $request->except('image');
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $data['image'] = 'storage/' . $imagePath;
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        $data = $request->except('image');
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image && Storage::disk('public')->exists(str_replace('storage/', '', $category->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $category->image));
            }
            
            $imagePath = $request->file('image')->store('categories', 'public');
            $data['image'] = 'storage/' . $imagePath;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        // Delete image if exists
        if ($category->image && Storage::disk('public')->exists(str_replace('storage/', '', $category->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $category->image));
        }
        
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }

    // AJAX SEARCH for categories
    public function search(Request $request)
    {
        $search = $request->input('search', '');
        
        $categories = Category::where('name', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->limit(10)
            ->get(['id', 'name', 'description', 'image']);
        
        return response()->json($categories);
    }
}