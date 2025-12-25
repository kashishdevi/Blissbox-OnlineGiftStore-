<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - BlissBox</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #8b5cf6;
            --secondary-color: #10b981;
            --dark-color: #1e293b;
            --light-color: #f8fafc;
            --muted-color: #64748b;
        }
        
        body {
            background-color: var(--light-color);
            color: var(--dark-color);
            font-family: 'Inter', sans-serif;
        }
        
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border-bottom: 1px solid #e2e8f0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary-color) !important;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--dark-color) !important;
            margin: 0 8px;
        }
        
        .nav-link:hover {
            color: var(--primary-color) !important;
        }
        
        .product-img {
            max-height: 500px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        
        .price {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: bold;
        }
        
        .old-price {
            text-decoration: line-through;
            color: var(--muted-color);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 12px 30px;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background-color: #7c3aed;
            border-color: #7c3aed;
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        
        .badge-success {
            background-color: var(--secondary-color);
        }
        
        footer {
            background: linear-gradient(135deg, var(--dark-color), #0f172a);
            color: white;
            border-top: 1px solid #334155;
        }
        
        .breadcrumb {
            background-color: white;
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        
        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .breadcrumb-item.active {
            color: var(--muted-color);
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: all 0.3s;
            background: white;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .input-group {
            width: 150px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .input-group .btn-outline-secondary {
            border: none;
            color: var(--muted-color);
            background-color: #f8fafc;
        }
        
        .input-group .form-control {
            border: none;
            text-align: center;
            font-weight: 600;
        }
        
        .input-group .form-control:focus {
            box-shadow: none;
        }
        
        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.2);
            color: var(--dark-color);
        }
        
        .alert-success .btn-close {
            filter: brightness(0.8);
        }
        
        /* Quantity buttons */
        .quantity-btn {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            color: var(--muted-color);
            padding: 8px 16px;
            cursor: pointer;
            user-select: none;
        }
        
        .quantity-btn:hover {
            background-color: #e2e8f0;
        }
        
        .quantity-btn:active {
            background-color: #cbd5e1;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-gift"></i>
                <span>BlissBox</span>
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/">Home</a>
                <a class="nav-link" href="/products">Products</a>
                <a class="nav-link position-relative" href="/cart">
                    <i class="fas fa-shopping-cart"></i>
                    @php
                        $cartCount = 0;
                        $cart = session()->get('cart', []);
                        foreach ($cart as $item) {
                            $cartCount += $item['quantity'];
                        }
                    @endphp
                    @if($cartCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" 
                          style="background-color: var(--secondary-color);">
                        {{ $cartCount }}
                    </span>
                    @endif
                </a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container" style="margin-top: 80px; padding-top: 20px;">
        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="my-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/products">Products</a></li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row g-4">
            <!-- Product Image -->
            <div class="col-md-6">
                @if($product->image)
                    <img src="{{ $product->image_url }}" 
                         class="img-fluid rounded shadow-sm product-img" 
                         alt="{{ $product->name }}">
                @else
                    <div class="bg-white rounded shadow-sm d-flex align-items-center justify-content-center p-5" 
                         style="height: 400px; border: 1px solid #e2e8f0;">
                        <i class="fas fa-gift fa-6x" style="color: #e2e8f0;"></i>
                    </div>
                @endif
            </div>

            <!-- Product Details -->
            <div class="col-md-6">
                <h1 class="fw-bold mb-3" style="color: var(--dark-color);">{{ $product->name }}</h1>
                
                <p class="text-muted mb-4">{{ $product->description }}</p>
                
                <!-- Stock Status -->
                <div class="mb-3">
                    @if($product->in_stock)
                        <span class="badge" style="background-color: rgba(16, 185, 129, 0.1); color: var(--secondary-color);">
                            <i class="fas fa-check-circle me-1"></i> In Stock
                        </span>
                    @else
                        <span class="badge" style="background-color: rgba(239, 68, 68, 0.1); color: #ef4444;">
                            <i class="fas fa-times-circle me-1"></i> Out of Stock
                        </span>
                    @endif
                </div>
                
                <!-- Price -->
                <div class="mb-4">
                    @if($product->discount_price && $product->discount_price < $product->price)
                        <div class="price">${{ number_format($product->discount_price, 2) }}</div>
                        <div class="old-price">${{ number_format($product->price, 2) }}</div>
                        <span class="badge bg-success">Save ${{ number_format($product->price - $product->discount_price, 2) }}</span>
                    @else
                        <div class="price">${{ number_format($product->price, 2) }}</div>
                    @endif
                </div>

                <!-- Add to Cart Form -->
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold" style="color: var(--dark-color);">Quantity:</label>
                        <div class="input-group">
                            <button type="button" class="btn btn-outline-secondary" onclick="decrementQuantity()">-</button>
                            <input type="number" 
                                   name="quantity" 
                                   id="quantity" 
                                   value="1" 
                                   min="1" 
                                   max="{{ $product->stock_quantity }}"
                                   class="form-control text-center">
                            <button type="button" class="btn btn-outline-secondary" onclick="incrementQuantity()">+</button>
                        </div>
                    </div>
                    
                    @if($product->in_stock)
                    <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                        <i class="fas fa-cart-plus me-2"></i> Add to Cart
                    </button>
                    @else
                    <button type="button" class="btn btn-secondary btn-lg w-100 mb-3" disabled>
                        <i class="fas fa-times-circle me-2"></i> Out of Stock
                    </button>
                    @endif
                </form>

                <a href="/products" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i> Back to Products
                </a>
            </div>
        </div>

        <!-- Related Products -->
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <div class="mt-5 pt-5 border-top">
                <h3 class="mb-4" style="color: var(--dark-color);">Related Products</h3>
                <div class="row g-4">
                    @foreach($relatedProducts as $related)
                        <div class="col-md-3">
                            <div class="card h-100">
                                <a href="/product/{{ $related->id }}" class="text-decoration-none">
                                    @if($related->image)
                                        <img src="{{ $related->image_url }}" 
                                             class="card-img-top" 
                                             alt="{{ $related->name }}"
                                             style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-white d-flex align-items-center justify-content-center" 
                                             style="height: 200px; border-bottom: 1px solid #e2e8f0;">
                                            <i class="fas fa-gift fa-3x" style="color: #e2e8f0;"></i>
                                        </div>
                                    @endif
                                </a>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title" style="color: var(--dark-color);">
                                        {{ Str::limit($related->name, 30) }}
                                    </h5>
                                    <div class="mt-auto">
                                        <p class="card-text mb-2">
                                            <span class="fw-bold" style="color: var(--primary-color);">
                                                ${{ number_format($related->price, 2) }}
                                            </span>
                                        </p>
                                        <div class="d-flex gap-2">
                                            <a href="/product/{{ $related->id }}" 
                                               class="btn btn-sm btn-primary flex-grow-1">
                                                View Details
                                            </a>
                                            <form action="{{ route('cart.add', $related->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-sm btn-outline-primary" 
                                                        @if(!$related->in_stock) disabled @endif>
                                                    <i class="fas fa-cart-plus"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0" style="color: #cbd5e1;">&copy; {{ date('Y') }} BlissBox. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function decrementQuantity() {
            const quantityInput = document.getElementById('quantity');
            let value = parseInt(quantityInput.value);
            if (value > 1) {
                quantityInput.value = value - 1;
            }
        }
        
        function incrementQuantity() {
            const quantityInput = document.getElementById('quantity');
            let value = parseInt(quantityInput.value);
            const max = parseInt(quantityInput.max);
            if (value < max) {
                quantityInput.value = value + 1;
            }
        }
    </script>
</body>
</html>