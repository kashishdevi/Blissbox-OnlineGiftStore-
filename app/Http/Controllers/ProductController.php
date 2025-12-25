<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
  
public function index(Request $request)
{
    $query = Product::query();
    
    // Add search if provided
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('category', 'like', '%' . $search . '%')
              ->orWhere('description', 'like', '%' . $search . '%');
        });
    }
    
    // Get products with pagination
    $products = $query->orderBy('created_at', 'desc')->paginate(10);
    
    return view('admin.products.index', compact('products'));
}

    public function show($id)
{
    $product = Product::findOrFail($id);
    
    // Get related products
    $relatedProducts = Product::where('category', $product->category)
        ->where('id', '!=', $product->id)
        ->limit(4)
        ->get();
    
    // Use the correct view name (with hyphen)
    return view('pages.product-show', compact('product', 'relatedProducts'));
}


    // Display admin product list
    public function adminIndex()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // Show create form
    public function create()
    {
        return view('admin.products.create');
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
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'features' => 'nullable|string'
    ]);

    // Handle image upload
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $imagePath = $image->storeAs('public/products', $imageName);
        $validated['image'] = 'storage/products/' . $imageName;
    }

    // Process features
    if ($request->has('features')) {
        $validated['features'] = array_map('trim', explode(',', $request->features));
    }

    // Generate slug
    $validated['slug'] = Str::slug($request->name);
    
    // Set default values for missing fields
    $validated['in_stock'] = $request->has('in_stock') ? $request->in_stock : true;
    $validated['is_featured'] = $request->has('is_featured') ? $request->is_featured : false;
    $validated['is_active'] = $request->has('is_active') ? $request->is_active : true;

    Product::create($validated);

    return redirect()->route('admin.products.index')
        ->with('success', 'Product created successfully.');
}

    // Show edit form
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock_quantity' => 'required|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'features' => 'nullable|string'
        ]);

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && Storage::exists(str_replace('storage/', 'public/', $product->image))) {
                Storage::delete(str_replace('storage/', 'public/', $product->image));
            }
            
            // Upload new image
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('public/products', $imageName);
            $validated['image'] = 'storage/products/' . $imageName;
        }

        // Process features
        if ($request->has('features')) {
            $validated['features'] = array_map('trim', explode(',', $request->features));
        }

        // Update slug if name changed
        if ($product->name !== $request->name) {
            $validated['slug'] = Str::slug($request->name);
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    // Delete product
    public function destroy(Product $product)
    {
        // Delete image if exists
        if ($product->image && Storage::exists(str_replace('storage/', 'public/', $product->image))) {
            Storage::delete(str_replace('storage/', 'public/', $product->image));
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}