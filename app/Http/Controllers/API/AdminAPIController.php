<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AdminAPIController extends Controller
{
    /**
     * Get all products (admin view - includes inactive)
     */
    public function getAllProducts(Request $request)
    {
        $query = Product::query();
        
        // Filter by category
        if ($request->has('category')) {
            $query->where('category', $request->category);
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
        $products = $query->latest()->paginate($perPage);
        
        // Format products
        $products->getCollection()->transform(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => (float)$product->price,
                'discount_price' => $product->discount_price ? (float)$product->discount_price : null,
                'category' => $product->category,
                'image' => $product->image_url ?? asset($product->image ?? ''),
                'stock_quantity' => (int)$product->stock_quantity,
                'in_stock' => (bool)$product->in_stock,
                'is_featured' => (bool)$product->is_featured,
                'is_active' => (bool)$product->is_active,
                'features' => $product->features,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
            ];
        });
        
        return response()->json([
            'success' => true,
            'data' => $products,
        ], 200);
    }

    /**
     * Get single product (admin view)
     */
    public function getProduct($id)
    {
        $product = Product::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => (float)$product->price,
                'discount_price' => $product->discount_price ? (float)$product->discount_price : null,
                'category' => $product->category,
                'image' => $product->image_url ?? asset($product->image ?? ''),
                'stock_quantity' => (int)$product->stock_quantity,
                'in_stock' => (bool)$product->in_stock,
                'is_featured' => (bool)$product->is_featured,
                'is_active' => (bool)$product->is_active,
                'features' => $product->features,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
            ],
        ], 200);
    }

    /**
     * Create product (admin)
     */
    public function createProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'category' => 'required|string|max:100',
            'stock_quantity' => 'required|integer|min:0',
            'features' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'in_stock' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
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
        if ($request->has('features') && is_string($request->features)) {
            $data['features'] = array_map('trim', explode(',', $request->features));
        }

        $product = Product::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => (float)$product->price,
                'discount_price' => $product->discount_price ? (float)$product->discount_price : null,
                'category' => $product->category,
                'image' => $product->image_url ?? asset($product->image ?? ''),
                'stock_quantity' => (int)$product->stock_quantity,
                'in_stock' => (bool)$product->in_stock,
                'is_featured' => (bool)$product->is_featured,
                'is_active' => (bool)$product->is_active,
            ],
        ], 201);
    }

    /**
     * Update product (admin)
     */
    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'category' => 'sometimes|required|string|max:100',
            'stock_quantity' => 'sometimes|required|integer|min:0',
            'features' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'in_stock' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
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
        if ($request->has('features') && is_string($request->features)) {
            $data['features'] = array_map('trim', explode(',', $request->features));
        }

        $product->update($data);
        $product->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => (float)$product->price,
                'discount_price' => $product->discount_price ? (float)$product->discount_price : null,
                'category' => $product->category,
                'image' => $product->image_url ?? asset($product->image ?? ''),
                'stock_quantity' => (int)$product->stock_quantity,
                'in_stock' => (bool)$product->in_stock,
                'is_featured' => (bool)$product->is_featured,
                'is_active' => (bool)$product->is_active,
            ],
        ], 200);
    }

    /**
     * Delete product (admin)
     */
    public function deleteProduct($id)
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

    /**
     * Get all categories (admin)
     */
    public function getAllCategories(Request $request)
    {
        $query = Category::query();
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%');
        }
        
        $perPage = $request->get('per_page', 15);
        $categories = $query->latest()->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $categories,
        ], 200);
    }

    /**
     * Get all orders (admin)
     */
    public function getAllOrders(Request $request)
    {
        $query = Order::with('items');
        
        if ($request->has('status')) {
            $query->where('order_status', $request->status);
        }
        
        $perPage = $request->get('per_page', 15);
        $orders = $query->latest()->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $orders,
        ], 200);
    }
}

