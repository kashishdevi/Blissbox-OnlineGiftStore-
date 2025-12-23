@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Header -->
<div class="row mb-4 justify-content-center">
    <div class="col-12 col-lg-8 text-center">
        <h1 class="fw-bold mb-3" style="background: linear-gradient(135deg, #db2777 0%, #fbbf24 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
            <i class="fas fa-gifts me-2"></i>
            @isset($title)
                {{ $title }}
            @else
                Our Gift Collection
            @endisset
        </h1>
        <p class="text-muted mb-0">Discover perfect gifts for every special occasion</p>
    </div>
</div>

<!-- Filters and Search -->
<div class="row mb-4 justify-content-center">
    <div class="col-12 col-lg-10">
        <div class="d-flex flex-column flex-lg-row align-items-center justify-content-center gap-3">
            <!-- Search Form -->
            <form action="{{ route('products.index') }}" method="GET" class="d-flex w-100" style="max-width: 500px;">
                <div class="input-group shadow-sm">
                    <input type="text" name="search" class="form-control border-2 border-end-0" 
                           placeholder="Search gifts (type starting letters)..." 
                           value="{{ request('search') }}">
                    <button class="btn btn-purple border-2 border-start-0 px-4" type="submit">
                        <i class="fas fa-search me-2"></i>Search
                    </button>
                </div>
            </form>

            <!-- Sort and Clear Filters -->
            <div class="d-flex flex-wrap gap-2 justify-content-center">
                <div class="dropdown">
                    <button class="btn btn-outline-purple dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-filter me-2"></i>
                        @if(request('sort'))
                            @if(request('sort') == 'price_low') Price: Low to High
                            @elseif(request('sort') == 'price_high') Price: High to Low
                            @elseif(request('sort') == 'newest') Newest
                            @elseif(request('sort') == 'featured') Featured
                            @endif
                        @else
                            Sort By
                        @endif
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'newest'])) }}">Newest</a></li>
                        <li><a class="dropdown-item" href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'featured'])) }}">Featured</a></li>
                        <li><a class="dropdown-item" href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'price_low'])) }}">Price: Low to High</a></li>
                        <li><a class="dropdown-item" href="{{ route('products.index', array_merge(request()->except('sort'), ['sort' => 'price_high'])) }}">Price: High to Low</a></li>
                    </ul>
                </div>
                @if(request('search') || request('sort') || request('category'))
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-2"></i>Clear Filters
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

    <!-- ===== MAIN CATEGORIES SECTION ===== -->
    <div class="row mb-5">
    <div class="col-12 text-center">
        <h4 class="fw-bold mb-4" style="color: #db2777;">
            <i class="fas fa-filter me-2"></i>Browse by Main Category
        </h4>
        <div class="d-flex flex-wrap gap-3 justify-content-center">
            @php
                $mainCategories = [
                    ['name' => 'For Him', 'slug' => 'for-him', 'icon' => 'fa-male', 'color' => '#2563eb'],      // Blue
                    ['name' => 'For Her', 'slug' => 'for-her', 'icon' => 'fa-female', 'color' => '#db2777'],    // Pink
                    ['name' => 'Birthday Specials', 'slug' => 'birthday-specials', 'icon' => 'fa-birthday-cake', 'color' => '#f59e0b'], // Amber
                    ['name' => 'Anniversary Surprises', 'slug' => 'anniversary-surprises', 'icon' => 'fa-heart', 'color' => '#ec4899'],   // Hot Pink
                    ['name' => 'Personalized Gifts', 'slug' => 'personalized-gifts', 'icon' => 'fa-edit', 'color' => '#7c3aed'],          // Violet
                    ['name' => 'Luxury Collection', 'slug' => 'luxury-collection', 'icon' => 'fa-crown', 'color' => '#fbbf24'],           // Yellow
                ];
            @endphp
            
            @foreach($mainCategories as $category)
                @php
                    $isActive = isset($currentCategory) ? $currentCategory == $category['name'] : 
                               (request('category') == $category['name']);
                @endphp
                <a href="{{ route('products.category', $category['slug']) }}" 
                   class="text-decoration-none">
                    <div class="main-category-card {{ $isActive ? 'active' : '' }}" 
                         style="border-color: {{ $category['color'] }}; background: {{ $isActive ? $category['color'] . '15' : 'white' }};">
                        <div class="category-icon mb-2">
                            <i class="fas {{ $category['icon'] }}" style="color: {{ $isActive ? 'white' : $category['color'] }}; background: {{ $isActive ? $category['color'] : $category['color'] . '15' }};"></i>
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: {{ $isActive ? $category['color'] : '#333' }};">
                            {{ $category['name'] }}
                        </h6>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
<!-- ===== END MAIN CATEGORIES ===== -->

    <!-- Results Count -->
    @if(request('search') || request('category'))
    <div class="row mb-3">
        <div class="col-12">
            <p class="text-muted mb-0">
                @if(request('search'))
                Search results for "<strong>{{ request('search') }}</strong>"
                @endif
                @if(request('category'))
                {{ request('search') ? ' in ' : '' }}Category: <strong>{{ ucwords(str_replace('-', ' ', request('category'))) }}</strong>
                @endif
                <span class="ms-2">({{ $products->total() }} gifts found)</span>
            </p>
        </div>
    </div>
    @endif

    <!-- Products Grid -->
    <div class="row">
        @forelse($products as $product)
        <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
            <div class="card h-100 border-0 shadow-sm gift-card">
                <!-- Product Image -->
                <div class="position-relative">
                    @if($product->image)
                    <img src="{{ $product->image }}" 
                         class="card-img-top product-image" 
                         alt="{{ $product->name }}"
                         style="height: 250px; object-fit: cover;"
                         onerror="this.src='https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=600&h=600&fit=crop'">
                    @else
                    <div class="card-img-top bg-gradient-light d-flex align-items-center justify-content-center" 
                         style="height: 250px;">
                        <i class="fas fa-gift fa-4x text-muted opacity-50"></i>
                    </div>
                    @endif
                    
                    <!-- Badges -->
                    @if($product->is_featured)
                    <div class="position-absolute top-0 start-0 m-3">
                        <span class="badge featured-badge">
                            <i class="fas fa-star me-1"></i>Featured
                        </span>
                    </div>
                    @endif
                    
                    @if($product->is_on_sale)
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge sale-badge">
                            <i class="fas fa-tag me-1"></i>Sale
                        </span>
                    </div>
                    @endif
                </div>
                
                <!-- Product Details -->
                <div class="card-body d-flex flex-column p-4">
                    <h5 class="card-title fw-bold mb-2">{{ $product->name }}</h5>
                    <p class="card-text text-muted small flex-grow-1 mb-3">
                        {{ $product->short_description ?? Str::limit($product->description, 80) }}
                    </p>
                    
                    <div class="mt-auto">
                        <!-- Price and Stock -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="h4 fw-bold price mb-0">${{ number_format($product->display_price ?? $product->price, 2) }}</span>
                                @if($product->is_on_sale && $product->sale_price)
                                <small class="text-muted ms-2 text-decoration-line-through">
                                    ${{ number_format($product->price, 2) }}
                                </small>
                                @endif
                            </div>
                            <div>
                                @if($product->stock_quantity > 0)
                                <span class="badge stock-badge">
                                    <i class="fas fa-check me-1"></i>
                                    @if($product->stock_quantity <= 10)
                                    Low Stock ({{ $product->stock_quantity }})
                                    @else
                                    In Stock
                                    @endif
                                </span>
                                @else
                                <span class="badge out-of-stock-badge">
                                    <i class="fas fa-times me-1"></i>Out of Stock
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Tags -->
                        @if($product->tags && count($product->tags) > 0)
                        <div class="mb-3">
                            <div class="d-flex flex-wrap gap-1">
                                @foreach(array_slice($product->tags, 0, 3) as $tag)
                                <span class="badge tag-badge">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        <!-- Action Buttons -->
                        <div class="d-grid gap-2">
                            <a href="{{ route('products.show', $product->id) }}" 
                               class="btn btn-purple">
                                <i class="fas fa-eye me-2"></i>View Details
                            </a>
                            @if($product->stock_quantity > 0)
                            <button class="btn btn-outline-purple add-to-cart-btn" 
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}"
                                    data-price="{{ $product->display_price ?? $product->price }}"
                                    data-image="{{ $product->image }}"
                                    data-stock="{{ $product->stock_quantity }}">
                                <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                            </button>
                            @else
                            <button class="btn btn-outline-secondary" disabled>
                                <i class="fas fa-ban me-2"></i>Out of Stock
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-gift fa-4x text-muted mb-3 opacity-50"></i>
                <h4 class="fw-bold text-dark mb-3">No Gifts Found</h4>
                <p class="text-muted mb-4">
                    @if(request('search'))
                    No products found for "{{ request('search') }}". Try a different search term.
                    @elseif(request('category'))
                    No products found in "{{ ucwords(str_replace('-', ' ', request('category'))) }}" category.
                    @else
                    No products available at the moment. Check back soon!
                    @endif
                </p>
                <a href="{{ route('products.index') }}" class="btn btn-purple">
                    <i class="fas fa-redo me-2"></i>View All Gifts
                </a>
            </div>
        </div>
        @endforelse
    </div>

  
<!-- Pagination-->
@if($products->hasPages())
<div class="row mt-5">
    <div class="col-12">
        <nav aria-label="Page navigation">
            @php
                // Get the current page and total pages
                $currentPage = $products->currentPage();
                $lastPage = $products->lastPage();
                $onEachSide = 2; // Show 2 pages on each side of current page
            @endphp
            
            @if($lastPage > 1)
            <ul class="pagination justify-content-center">
                {{-- Always show first page if not current --}}
                @if($currentPage > $onEachSide + 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $products->url(1) }}" aria-label="First">
                        1
                    </a>
                </li>
                @if($currentPage > $onEachSide + 2)
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
                @endif
                @endif

                {{-- Show pages around current page --}}
                @for($i = max(1, $currentPage - $onEachSide); $i <= min($lastPage, $currentPage + $onEachSide); $i++)
                    <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                        <a class="page-link" href="{{ $products->url($i) }}">
                            {{ $i }}
                        </a>
                    </li>
                @endfor

                {{-- Always show last page if not current --}}
                @if($currentPage < $lastPage - $onEachSide)
                    @if($currentPage < $lastPage - $onEachSide - 1)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                    @endif
                    <li class="page-item">
                        <a class="page-link" href="{{ $products->url($lastPage) }}" aria-label="Last">
                            {{ $lastPage }}
                        </a>
                    </li>
                @endif
            </ul>
            @endif
        </nav>
    </div>
</div>
@endif

<style>
    /* Color Variables */
    :root {
        --primary-pink: #db2777;
        --primary-yellow: #fbbf24;
        --secondary-blue: #2563eb;
        --accent-violet: #7c3aed;
        --accent-amber: #f59e0b;
        --hot-pink: #ec4899;
        --light-bg: #fef7ff;
    }
    
    /* Main Categories Styling */
    .main-category-card {
        width: 140px;
        height: 120px;
        border: 2px solid;
        border-radius: 15px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 15px;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }
    
    .main-category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(219, 39, 119, 0.15);
    }
    
    .main-category-card.active {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(219, 39, 119, 0.2);
    }
    
    .category-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }
    
    /* Product Card Styling */
    .product-image {
        transition: transform 0.3s ease;
        border-radius: 10px 10px 0 0;
    }
    
    .gift-card {
        border-radius: 15px;
        transition: all 0.3s ease;
        overflow: hidden;
        background: white;
        border: 1px solid #f3e8ff;
    }
    
    .gift-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(219, 39, 119, 0.2) !important;
        border-color: var(--primary-pink);
    }
    
    .gift-card:hover .product-image {
        transform: scale(1.05);
    }
    
    /* Button Styling */
    .btn-purple {
        background: linear-gradient(135deg, var(--primary-pink), var(--primary-yellow));
        border: none;
        color: white;
        font-weight: 600;
        padding: 12px 24px;
        border-radius: 50px;
        transition: all 0.3s ease;
    }
    
    .btn-purple:hover {
        background: linear-gradient(135deg, #be185d, #eab308);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(219, 39, 119, 0.3);
    }
    
    .btn-outline-purple {
        border: 2px solid var(--primary-pink);
        color: var(--primary-pink);
        background: transparent;
        padding: 10px 24px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-outline-purple:hover {
        background: linear-gradient(135deg, var(--primary-pink), var(--primary-yellow));
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(219, 39, 119, 0.2);
    }
    
    /* Badge Styling */
    .badge.featured-badge {
        background: linear-gradient(135deg, var(--primary-yellow), #f59e0b);
        color: #333;
        font-weight: 600;
    }
    
    .badge.sale-badge {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        font-weight: 600;
    }
    
    .badge.stock-badge {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        font-weight: 600;
    }
    
    .badge.out-of-stock-badge {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: white;
        font-weight: 600;
    }
    
    .badge.tag-badge {
        background: #fdf4ff;
        color: var(--primary-pink);
        border: 1px solid #f3e8ff;
        font-weight: 500;
    }
    
    /* Price Styling */
    .price {
        color: var(--primary-pink);
        background: linear-gradient(135deg, var(--primary-pink), var(--primary-yellow));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    /* Background Gradient */
    .bg-gradient-light {
        background: linear-gradient(135deg, var(--light-bg), #fef3c7);
    }
    
    /* Pagination Styling */
    .pagination .page-link {
        color: var(--primary-pink);
        border: 1px solid #f3e8ff;
        font-weight: 500;
    }
    
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--primary-pink), var(--primary-yellow));
        border-color: transparent;
        color: white;
    }
    
    .pagination .page-link:hover {
        background-color: rgba(219, 39, 119, 0.1);
        color: #be185d;
        border-color: var(--primary-pink);
    }
    
    /* Text Colors */
    .text-purple {
        background: linear-gradient(135deg, var(--primary-pink), var(--primary-yellow));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add to cart functionality
        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', function() {
                const product = {
                    id: this.getAttribute('data-id'),
                    name: this.getAttribute('data-name'),
                    price: parseFloat(this.getAttribute('data-price')),
                    image: this.getAttribute('data-image'),
                    stock: parseInt(this.getAttribute('data-stock'))
                };
                
                // Check stock
                if (product.stock <= 0) {
                    alert('Sorry, this product is out of stock!');
                    return;
                }
                
                // Get existing cart
                let cart = JSON.parse(localStorage.getItem('blissbox_gift_cart')) || [];
                
                // Check if product already in cart
                const existingIndex = cart.findIndex(item => item.id == product.id);
                if (existingIndex !== -1) {
                    // Check if we can add more (stock limit)
                    if (cart[existingIndex].quantity >= product.stock) {
                        alert(`You've reached the maximum available stock (${product.stock}) for this item.`);
                        return;
                    }
                    cart[existingIndex].quantity += 1;
                } else {
                    product.quantity = 1;
                    cart.push(product);
                }
                
                // Save to localStorage
                localStorage.setItem('blissbox_gift_cart', JSON.stringify(cart));
                
                // Show success message with matching colors
                const toast = document.createElement('div');
                toast.className = 'position-fixed top-0 end-0 m-3';
                toast.style.cssText = 'z-index:1050; border-radius:15px; overflow:hidden;';
                toast.innerHTML = `
                    <div style="background: linear-gradient(135deg, #db2777, #fbbf24); color:white; padding:15px 20px; border-radius:15px; box-shadow:0 10px 20px rgba(219,39,119,0.3);">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle fa-2x me-3" style="color:white;"></i>
                            <div>
                                <h6 class="mb-1 fw-bold">Added to Gift Cart!</h6>
                                <p class="mb-0 small">"${product.name}" added to your collection</p>
                            </div>
                        </div>
                    </div>
                `;
                document.body.appendChild(toast);
                
                // Remove toast after 3 seconds
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transition = 'opacity 0.5s';
                    setTimeout(() => toast.remove(), 500);
                }, 3000);
                
                // Update cart count in header
                updateCartCount();
                
                // Animate button
                this.innerHTML = '<i class="fas fa-check me-2"></i>Added!';
                this.classList.remove('btn-outline-purple');
                this.classList.add('btn-purple');
                this.disabled = true;
                
                setTimeout(() => {
                    this.innerHTML = '<i class="fas fa-shopping-cart me-2"></i>Add to Cart';
                    this.classList.remove('btn-purple');
                    this.classList.add('btn-outline-purple');
                    this.disabled = false;
                }, 2000);
            });
        });
        
        // Function to update cart count
        function updateCartCount() {
            const cart = JSON.parse(localStorage.getItem('blissbox_gift_cart')) || [];
            const totalItems = cart.reduce((sum, item) => sum + (item.quantity || 1), 0);
            
            // Update all cart count elements
            document.querySelectorAll('#cart-count, .cart-count').forEach(element => {
                element.textContent = totalItems;
                element.style.display = totalItems > 0 ? 'inline-block' : 'none';
            });
        }
        
        // Initialize cart count
        updateCartCount();
        
        // Fix image fallback
        document.querySelectorAll('.product-image').forEach(img => {
            img.addEventListener('error', function() {
                if (this.src.includes('unsplash.com')) {
                    this.src = 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=600&h=600&fit=crop';
                }
            });
        });
    });
</script>
@endsection