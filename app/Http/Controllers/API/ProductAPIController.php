<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ProductAPIController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);
        
        // Filter by category
        if ($request->has('category')) {
            $query->where('category', $request->category)
                  ->orWhereHas('categoryRelation', function($q) use ($request) {
                      $q->where('name', $request->category);
                  });
        }
        
        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('category', 'like', '%' . $search . '%');
            });
        }
        
        // Pagination
        $perPage = $request->get('per_page', 15);
        $products = $query->with('categoryRelation')->latest()->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $products,
        ], 200);
    }

    public function show($id)
    {
        $product = Product::with('categoryRelation')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $product,
        ], 200);
    }

    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2',
        ]);
        
        $products = Product::where('is_active', true)
            ->where(function($query) use ($request) {
                $query->where('name', 'like', '%' . $request->q . '%')
                      ->orWhere('category', 'like', '%' . $request->q . '%')
                      ->orWhere('description', 'like', '%' . $request->q . '%');
            })
            ->with('categoryRelation')
            ->limit(10)
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $products,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'category' => 'nullable|string|max:100',
            'stock_quantity' => 'required|integer|min:0',
            'features' => 'nullable|string',
            'is_featured' => 'boolean',
            'in_stock' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'nullable|url|max:2048',
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
            $imagePath = $image->storeAs('public/products', $imageName);
            $data['image'] = 'storage/products/' . $imageName;
        } elseif ($request->has('image_url')) {
            $data['image'] = $request->image_url;
        }

        // Process features
        if ($request->has('features')) {
            $data['features'] = array_map('trim', explode(',', $request->features));
        }

        // Generate slug
        $data['slug'] = Str::slug($request->name);

        $product = Product::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product->load('categoryRelation'),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'category' => 'nullable|string|max:100',
            'stock_quantity' => 'sometimes|required|integer|min:0',
            'features' => 'nullable|string',
            'is_featured' => 'boolean',
            'in_stock' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'nullable|url|max:2048',
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
            if ($product->image && !filter_var($product->image, FILTER_VALIDATE_URL)) {
                Storage::delete(str_replace('storage/', 'public/', $product->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('public/products', $imageName);
            $data['image'] = 'storage/products/' . $imageName;
        } elseif ($request->has('image_url')) {
            // Delete old image if it was local
            if ($product->image && !filter_var($product->image, FILTER_VALIDATE_URL)) {
                Storage::delete(str_replace('storage/', 'public/', $product->image));
            }
            $data['image'] = $request->image_url;
        }

        // Process features
        if ($request->has('features')) {
            $data['features'] = array_map('trim', explode(',', $request->features));
        }

        // Update slug if name changed
        if ($request->has('name') && $product->name !== $request->name) {
            $data['slug'] = Str::slug($request->name);
        }

        $product->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product->load('categoryRelation'),
        ], 200);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Delete image if exists
        if ($product->image && !filter_var($product->image, FILTER_VALIDATE_URL)) {
            Storage::delete(str_replace('storage/', 'public/', $product->image));
        }
        
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully',
        ], 200);
    }
}

