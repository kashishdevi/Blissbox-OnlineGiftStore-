<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Display all products (admin)
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }
    
    // Show single product (frontend)
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();
        return view('pages.product-show', compact('product', 'relatedProducts'));
    }
    
    // Show create form
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }
    
    // Store new product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'category' => 'required|string|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock_quantity' => 'required|integer|min:0',
            'features' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'in_stock' => 'nullable|boolean'
        ]);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('public/products', $imageName);
            $validated['image'] = 'storage/products/' . $imageName;
            
            // Also copy to public/storage/products for immediate access (fallback for symlink issues)
            $publicPath = public_path('storage/products/' . $imageName);
            $publicDir = dirname($publicPath);
            if (!is_dir($publicDir)) {
                mkdir($publicDir, 0755, true);
            }
            if (file_exists(storage_path('app/public/products/' . $imageName))) {
                copy(storage_path('app/public/products/' . $imageName), $publicPath);
            }
        }
        
        // Generate slug
        $validated['slug'] = Str::slug($request->name);
        
        // Make slug unique if it already exists
        $count = Product::where('slug', 'like', $validated['slug'] . '%')->count();
        if ($count > 0) {
            $validated['slug'] .= '-' . ($count + 1);
        }
        
        // Process features - convert comma-separated string to array
        if ($request->has('features') && !empty($request->features)) {
            $validated['features'] = array_map('trim', explode(',', $request->features));
        } else {
            $validated['features'] = null;
        }
        
        // Handle boolean fields (checkboxes)
        $validated['is_featured'] = $request->has('is_featured') && $request->is_featured == '1';
        $validated['in_stock'] = $request->has('in_stock') && $request->in_stock == '1';
        
        // Try to get category_id from category name
        if ($request->has('category')) {
            $category = Category::where('name', $request->category)->first();
            if ($category) {
                $validated['category_id'] = $category->id;
            }
        }
        
        Product::create($validated);
        
        return redirect('/admin/products')->with('success', 'Product created successfully!');
    }
    
    // Show edit form
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }
    
    // Update product
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'category' => 'required|string|max:100',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'nullable|url',
            'stock_quantity' => 'required|integer|min:0',
            'features' => 'nullable|string',
            'is_featured' => 'boolean',
            'in_stock' => 'boolean'
        ]);
        
        // Handle image update - prioritize file upload over URL
        if ($request->hasFile('image_file')) {
            // Delete old image if it was a local file
            if ($product->image && !filter_var($product->image, FILTER_VALIDATE_URL) && Storage::exists(str_replace('storage/', 'public/', $product->image))) {
                Storage::delete(str_replace('storage/', 'public/', $product->image));
            }
            
            // Upload new image file
            $image = $request->file('image_file');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('public/products', $imageName);
            $validated['image'] = 'storage/products/' . $imageName;
            
            // Also copy to public/storage/products for immediate access (fallback for symlink issues)
            $publicPath = public_path('storage/products/' . $imageName);
            $publicDir = dirname($publicPath);
            if (!is_dir($publicDir)) {
                mkdir($publicDir, 0755, true);
            }
            copy(storage_path('app/public/products/' . $imageName), $publicPath);
        } elseif ($request->filled('image_url') && filter_var($request->input('image_url'), FILTER_VALIDATE_URL)) {
            // Delete old image if it was a local file
            if ($product->image && !filter_var($product->image, FILTER_VALIDATE_URL) && Storage::exists(str_replace('storage/', 'public/', $product->image))) {
                Storage::delete(str_replace('storage/', 'public/', $product->image));
            }
            
            // Save URL directly
            $validated['image'] = $request->input('image_url');
        } else {
            // Keep existing image if no new image provided
            unset($validated['image']);
        }
        
        // Remove the temporary fields from validated array
        unset($validated['image_file'], $validated['image_url']);
        
        $product->update($validated);
        
        return redirect('/admin/products')->with('success', 'Product updated successfully!');
    }
    
    // Delete product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Delete image if exists
        if ($product->image && Storage::exists(str_replace('storage/', 'public/', $product->image))) {
            Storage::delete(str_replace('storage/', 'public/', $product->image));
        }
        
        $product->delete();
        
        return redirect('/admin/products')->with('success', 'Product deleted successfully!');
    }
}