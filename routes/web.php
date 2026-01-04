<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminRegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
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
    $sortBy = request('sort_by', 'latest'); // Default to latest
    
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
    
    // Apply sorting
    switch ($sortBy) {
        case 'price_low':
            $query->orderBy('price', 'asc');
            break;
        case 'price_high':
            $query->orderBy('price', 'desc');
            break;
        case 'name_asc':
            $query->orderBy('name', 'asc');
            break;
        case 'name_desc':
            $query->orderBy('name', 'desc');
            break;
        case 'latest':
        default:
            $query->latest();
            break;
    }
    
    $products = $query->paginate(12);
    $categories = Category::where('is_active', true)->get();
    
    return view('pages.products', compact('products', 'categories', 'category', 'search', 'sortBy'));
})->name('products');

// Ajax search route for products
Route::get('/products/search', function() {
    $searchTerm = request('q', '');
    $category = request('category', '');
    
    if (strlen($searchTerm) < 2) {
        return response()->json([]);
    }
    
    $query = Product::where('is_active', true);
    
    // Apply category filter if provided
    if ($category) {
        $query->where('category', $category);
    }
    
    // Filter by name OR category (at least two fields as required)
    $query->where(function($q) use ($searchTerm) {
        // Search in name
        $q->where('name', 'like', '%' . $searchTerm . '%');
        
        // OR search in category
        $q->orWhere('category', 'like', '%' . $searchTerm . '%');
    });
    
    // Limit results for dropdown
    $products = $query->limit(10)->get();
    
    // Format results for dropdown
    $results = $products->map(function($product) {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'category' => $product->category,
            'price' => number_format($product->price, 2),
            'image' => $product->image_url,
            'url' => route('product.show', $product->id)
        ];
    });
    
    return response()->json($results);
})->name('products.search.ajax');

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

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Order routes using OrderController
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/thankyou/{id}', [OrderController::class, 'thankyou'])->name('order.thankyou');
Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');
Route::get('/my-orders', [OrderController::class, 'history'])->middleware('auth')->name('orders.history');

// Admin Authentication Routes (Public)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login']);
        Route::get('/register', [AdminRegisterController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [AdminRegisterController::class, 'register']);
    });
    
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    });
});

// Admin Routes (Protected)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', function () {
        $totalProducts = \App\Models\Product::count();
        $totalCategories = \App\Models\Category::count();
        $totalOrders = \App\Models\Order::count();
        $pendingOrders = \App\Models\Order::where('order_status', 'pending')->count();
        $totalRevenue = \App\Models\Order::where('payment_status', 'paid')->sum('total') ?? 0;
        
        // Share variables for sidebar
        view()->share([
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'totalRevenue' => $totalRevenue,
        ]);
        
        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalOrders',
            'pendingOrders',
            'totalRevenue'
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
    
    // Revenue Route
    Route::get('/revenue', function () {
        $totalRevenue = \App\Models\Order::where('payment_status', 'paid')->sum('total') ?? 0;
        $totalOrders = \App\Models\Order::where('payment_status', 'paid')->count();
        $monthlyRevenue = \App\Models\Order::where('payment_status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total') ?? 0;
        $revenueOrders = \App\Models\Order::where('payment_status', 'paid')
            ->with('items')
            ->latest()
            ->paginate(20);
        
        return view('admin.revenue', compact('totalRevenue', 'totalOrders', 'monthlyRevenue', 'revenueOrders'));
    })->name('revenue');
});

// Default redirect for /admin
Route::get('/admin', function () {
    if (Auth::check() && Auth::user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('admin.login');
});

require __DIR__.'/auth.php';