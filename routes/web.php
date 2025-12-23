<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Models\Product;
use App\Models\Category;

// Frontend Pages
Route::get('/', function() {
    $featuredProducts = Product::where('is_featured', true)
        ->where('is_active', true)
        ->where('in_stock', true)
        ->limit(8)
        ->get();
    
    $categories = Category::where('is_active', true)->get();
    
    return view('pages.home', compact('featuredProducts', 'categories'));
})->name('home');

// Products listing page
Route::get('/products', function() {
    $category = request('category');
    $search = request('search');
    
    $query = Product::where('is_active', true);
    
    if ($category) {
        $query->where('category', $category);
    }
    
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('description', 'like', '%' . $search . '%')
              ->orWhere('category', 'like', '%' . $search . '%');
        });
    }
    
    $products = $query->latest()->paginate(12);
    $categories = Category::where('is_active', true)->get();
    
    return view('pages.products', compact('products', 'categories', 'category', 'search'));
})->name('products');

// Product detail page
Route::get('/product/{id}', function($id) {
    $product = Product::findOrFail($id);
    
    // Get related products from same category
    $relatedProducts = Product::where('category', $product->category)
        ->where('id', '!=', $product->id)
        ->where('is_active', true)
        ->limit(4)
        ->get();
    
    return view('pages.product-show', compact('product', 'relatedProducts'));
})->name('product.show');

// Category page
Route::get('/category/{name}', function($name) {
    $products = Product::where('category', urldecode($name))
        ->where('is_active', true)
        ->latest()
        ->paginate(12);
    
    $categories = Category::where('is_active', true)->get();
    $currentCategory = $name;
    $category = $name;
    
    return view('pages.products', compact('products', 'categories', 'category', 'currentCategory'));
})->name('category.show');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add'); 
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/contact', function() {
    return view('pages.contact');
})->name('contact');

// Order routes using OrderController
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/thankyou/{id}', [OrderController::class, 'thankyou'])->name('order.thankyou');
Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', function () {
        $totalProducts = \App\Models\Product::count();
        $totalCategories = \App\Models\Category::count();
        $totalOrders = \App\Models\Order::count();
        $pendingOrders = \App\Models\Order::where('order_status', 'pending')->count();
        $totalRevenue = \App\Models\Order::where('payment_status', 'paid')->sum('total');
        $recentOrders = \App\Models\Order::with('items')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalOrders',
            'pendingOrders',
            'totalRevenue',
            'recentOrders'
        ));
    })->name('dashboard');
    
    // Product Routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    
    // Category Routes
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');
    
    // Order Routes - FIXED THIS LINE
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus'); // Changed from PUT to POST
    Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
});

// Default redirect for /admin to dashboard
Route::redirect('/admin', '/admin/dashboard');

require __DIR__.'/auth.php';