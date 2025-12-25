<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryAPIController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();
        
        // Only active categories by default
        if (!$request->has('include_inactive')) {
            $query->where('is_active', true);
        }
        
        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        
        $categories = $query->with('products')->latest()->get();
        
        return response()->json([
            'success' => true,
            'data' => $categories,
        ], 200);
    }

    public function show($id)
    {
        $category = Category::with('products')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $category,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'nullable|url|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('public/categories', $imageName);
            $data['image'] = 'storage/categories/' . $imageName;
        } elseif ($request->has('image_url')) {
            $data['image'] = $request->image_url;
        }

        $category = Category::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully',
            'data' => $category->load('products'),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'nullable|url|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request->all();

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image && !filter_var($category->image, FILTER_VALIDATE_URL)) {
                Storage::delete(str_replace('storage/', 'public/', $category->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('public/categories', $imageName);
            $data['image'] = 'storage/categories/' . $imageName;
        } elseif ($request->has('image_url')) {
            // Delete old image if it was local
            if ($category->image && !filter_var($category->image, FILTER_VALIDATE_URL)) {
                Storage::delete(str_replace('storage/', 'public/', $category->image));
            }
            $data['image'] = $request->image_url;
        }

        $category->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully',
            'data' => $category->load('products'),
        ], 200);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        // Check if category has products
        if ($category->products()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete category with existing products',
            ], 400);
        }
        
        // Delete image if exists
        if ($category->image && !filter_var($category->image, FILTER_VALIDATE_URL)) {
            Storage::delete(str_replace('storage/', 'public/', $category->image));
        }
        
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully',
        ], 200);
    }
}

