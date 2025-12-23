@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
            @if($product->tags && count($product->tags) > 0)
            <li class="breadcrumb-item"><a href="{{ route('products.index', ['category' => $product->tags[0]]) }}">{{ ucwords(str_replace('-', ' ', $product->tags[0])) }}</a></li>
            @endif
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm">
                @if($product->image)
                <img src="{{ $product->image }}" 
                     class="card-img-top main-product-image" 
                     alt="{{ $product->name }}"
                     style="max-height: 500px; object-fit: contain;"
                     onerror="this.src='https://images.unsplash.com/photo-1547887537-6158d64c35b3?w=800&h=800&fit=crop'">
                @else
                <div class="card-img-top bg-gradient-light d-flex align-items-center justify-content-center" 
                     style="height: 400px;">
                    <i class="fas fa-gift fa-6x text-muted opacity-50"></i>
                </div>
                @endif
                
                <!-- Gallery Images -->
                @if($product->gallery_images && count($product->gallery_images) > 0)
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-3">
                            <img src="{{ $product->image }}" 
                                 class="img-thumbnail gallery-thumbnail active" 
                                 alt="Main"
                                 onclick="changeMainImage(this, '{{ $product->image }}')">
                        </div>
                        @foreach($product->gallery_images as $galleryImage)
                        <div class="col-3">
                            <img src="{{ $galleryImage }}" 
                                 class="img-thumbnail gallery-thumbnail" 
                                 alt="Gallery {{ $loop->iteration }}"
                                 onclick="changeMainImage(this, '{{ $galleryImage }}')">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-lg-6">
            <div class="product-details">
                <!-- Badges -->
                <div class="d-flex flex-wrap gap-2 mb-3">
                    @if($product->is_featured)
                    <span class="badge bg-warning text-dark">
                        <i class="fas fa-star me-1"></i>Featured
                    </span>
                    @endif
                    
                    @if($product->is_on_sale)
                    <span class="badge bg-danger text-white">
                        <i class="fas fa-tag me-1"></i>Sale
                    </span>
                    @endif
                    
                    @if($product->is_gift_wrapped)
                    <span class="badge" style="background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 100%); color: white;">
                        <i class="fas fa-gift me-1"></i>Gift Wrapped
                    </span>
                    @endif
                    
                    @if($product->personalization_allowed)
                    <span class="badge" style="background: linear-gradient(135deg, #10b981 0%, #34d399 100%); color: white;">
                        <i class="fas fa-edit me-1"></i>Personalizable
                    </span>
                    @endif
                </div>

                <!-- Product Name -->
                <h1 class="fw-bold mb-3">{{ $product->name }}</h1>
                
                <!-- Rating -->
                <div class="d-flex align-items-center mb-3">
                    <div class="text-warning me-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <span class="text-muted">(4.5/5)</span>
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <h2 class="fw-bold mb-2" style="background: linear-gradient(135deg, #db2777, #fbbf24); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                        ${{ number_format($product->display_price, 2) }}
                        @if($product->is_on_sale)
                        <small class="text-muted ms-2 text-decoration-line-through fs-4">
                            ${{ number_format($product->price, 2) }}
                        </small>
                        <span class="badge bg-danger ms-2">Save ${{ number_format($product->price - $product->display_price, 2) }}</span>
                        @endif
                    </h2>
                </div>

                <!-- Stock Status -->
                <div class="alert {{ $product->stock_quantity > 0 ? 'alert-success' : 'alert-danger' }} mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas {{ $product->stock_quantity > 0 ? 'fa-check-circle' : 'fa-times-circle' }} me-2 fa-lg"></i>
                        <div>
                            @if($product->stock_quantity > 0)
                            <strong>In Stock</strong>
                            <div class="small">
                                @if($product->stock_quantity <= 10)
                                Only {{ $product->stock_quantity }} left in stock - order soon!
                                @else
                                {{ $product->stock_quantity }} available
                                @endif
                            </div>
                            @else
                            <strong>Out of Stock</strong>
                            <div class="small">This item is currently unavailable</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Description</h5>
                    <p class="text-muted">{{ $product->description }}</p>
                </div>

                <!-- Features -->
                @if($product->features && count($product->features) > 0)
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Key Features</h5>
                    <ul class="list-unstyled">
                        @foreach($product->features as $feature)
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            {{ $feature }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Tags -->
                @if($product->tags && count($product->tags) > 0)
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Categories</h5>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($product->tags as $tag)
                        <a href="{{ route('products.index', ['category' => $tag]) }}" 
                           class="badge bg-light text-dark text-decoration-none">
                            {{ ucwords(str_replace('-', ' ', $tag)) }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Product Specifications -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Product Details</h5>
                        <div class="row">
                            @if($product->weight)
                            <div class="col-md-6 mb-2">
                                <strong>Weight:</strong> {{ $product->weight }} kg
                            </div>
                            @endif
                            
                            @if($product->dimensions)
                            <div class="col-md-6 mb-2">
                                <strong>Dimensions:</strong> {{ $product->dimensions }}
                            </div>
                            @endif
                            
                            @if($product->delivery_time)
                            <div class="col-md-6 mb-2">
                                <strong>Delivery Time:</strong> {{ $product->delivery_time }}
                            </div>
                            @endif
                            
                            @if($product->personalization_allowed)
                            <div class="col-md-6 mb-2">
                                <strong>Personalization:</strong> Available (Max {{ $product->max_personalization_length }} characters)
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Add to Cart Form -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Add to Gift Cart</h5>
                        
                        <!-- Personalization (if allowed) -->
                        @if($product->personalization_allowed)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Add Personalization</label>
                            <textarea class="form-control" 
                                      id="personalization-text" 
                                      placeholder="Enter your custom message here..."
                                      maxlength="{{ $product->max_personalization_length }}"
                                      rows="3"></textarea>
                            <div class="form-text">
                                Max {{ $product->max_personalization_length }} characters
                            </div>
                        </div>
                        @endif

                        <!-- Quantity -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Quantity</label>
                            <div class="d-flex align-items-center">
                                <button class="btn btn-outline-secondary" id="decrease-qty">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" 
                                       id="quantity" 
                                       class="form-control mx-2 text-center" 
                                       value="1" 
                                       min="1" 
                                       max="{{ $product->stock_quantity }}"
                                       style="max-width: 80px;">
                                <button class="btn btn-outline-secondary" id="increase-qty">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="form-text">
                                Maximum: {{ $product->stock_quantity }} items
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-3">
                            @if($product->stock_quantity > 0)
                            <button class="btn btn-lg py-3 add-to-cart-single" 
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}"
                                    data-price="{{ $product->display_price }}"
                                    data-image="{{ $product->image }}"
                                    data-stock="{{ $product->stock_quantity }}"
                                    style="background: linear-gradient(135deg, #db2777 0%, #fbbf24 100%); border: none; color: white; font-weight: 600;">
                                <i class="fas fa-shopping-cart me-2"></i>Add to Gift Cart
                            </button>
                            
                            <button class="btn btn-lg py-3" id="buy-now-btn"
                                    style="border: 2px solid #db2777; color: #db2777; background: transparent; font-weight: 600;">
                                <i class="fas fa-bolt me-2"></i>Buy Now
                            </button>
                            @else
                            <button class="btn btn-secondary btn-lg py-3" disabled>
                                <i class="fas fa-ban me-2"></i>Out of Stock
                            </button>
                            
                            <button class="btn btn-outline-secondary btn-lg py-3" id="notify-me">
                                <i class="fas fa-bell me-2"></i>Notify When Available
                            </button>
                            @endif
                        </div>

                        <!-- Gift Options -->
                        @if($product->is_gift_wrapped)
                        <div class="mt-3 text-center">
                            <small class="text-success">
                                <i class="fas fa-gift me-1"></i>
                                This gift comes beautifully wrapped at no extra cost!
                            </small>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts && count($relatedProducts) > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="fw-bold mb-4">You Might Also Like</h3>
            <div class="row">
                @foreach($relatedProducts as $relatedProduct)
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <a href="{{ route('products.show', $relatedProduct->id) }}" class="text-decoration-none">
                            @if($relatedProduct->image)
                            <img src="{{ $relatedProduct->image }}" 
                                 class="card-img-top" 
                                 alt="{{ $relatedProduct->name }}"
                                 style="height: 200px; object-fit: cover;">
                            @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                 style="height: 200px;">
                                <i class="fas fa-gift fa-3x text-muted"></i>
                            </div>
                            @endif
                            
                            <div class="card-body">
                                <h6 class="card-title text-dark fw-bold">{{ $relatedProduct->name }}</h6>
                                <p class="card-text fw-bold mb-2" style="background: linear-gradient(135deg, #db2777, #fbbf24); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                    ${{ number_format($relatedProduct->display_price, 2) }}
                                </p>
                                <span class="badge {{ $relatedProduct->stock_quantity > 0 ? 'bg-success' : 'bg-danger' }} small">
                                    {{ $relatedProduct->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

<style>
    .main-product-image {
        border-radius: 15px;
        transition: transform 0.3s ease;
    }
    
    .main-product-image:hover {
        transform: scale(1.02);
    }
    
    .gallery-thumbnail {
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        border-radius: 8px;
    }
    
    .gallery-thumbnail:hover {
        border-color: #db2777;
        transform: scale(1.05);
    }
    
    .gallery-thumbnail.active {
        border-color: #db2777;
        box-shadow: 0 0 0 3px rgba(219, 39, 119, 0.2);
    }
    
    button[style*="background: linear-gradient(135deg, #db2777 0%, #fbbf24 100%)"]:hover {
        background: linear-gradient(135deg, #be185d 0%, #eab308 100%) !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(219, 39, 119, 0.3);
    }
    
    button[style*="border: 2px solid #db2777"]:hover {
        background: linear-gradient(135deg, #db2777 0%, #fbbf24 100%) !important;
        color: white !important;
        border-color: transparent !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(219, 39, 119, 0.2);
    }
    
    .breadcrumb-item a {
        color: #db2777;
        text-decoration: none;
    }
    
    .breadcrumb-item a:hover {
        text-decoration: underline;
    }
    
    .alert-success {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border: none;
        color: #065f46;
    }
    
    .alert-danger {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        border: none;
        color: #7f1d1d;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quantity controls
        const quantityInput = document.getElementById('quantity');
        const decreaseBtn = document.getElementById('decrease-qty');
        const increaseBtn = document.getElementById('increase-qty');
        
        decreaseBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });
        
        increaseBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            const maxStock = parseInt(quantityInput.max);
            if (currentValue < maxStock) {
                quantityInput.value = currentValue + 1;
            } else {
                alert(`Maximum available stock is ${maxStock}`);
            }
        });
        
        // Ensure quantity stays within bounds
        quantityInput.addEventListener('change', function() {
            let value = parseInt(this.value);
            const maxStock = parseInt(this.max);
            
            if (isNaN(value) || value < 1) {
                this.value = 1;
            } else if (value > maxStock) {
                this.value = maxStock;
                alert(`Maximum available stock is ${maxStock}`);
            }
        });
        
        // Add to cart functionality
        const addToCartBtn = document.querySelector('.add-to-cart-single');
        if (addToCartBtn) {
            addToCartBtn.addEventListener('click', function() {
                const product = {
                    id: this.getAttribute('data-id'),
                    name: this.getAttribute('data-name'),
                    price: parseFloat(this.getAttribute('data-price')),
                    image: this.getAttribute('data-image'),
                    stock: parseInt(this.getAttribute('data-stock'))
                };
                
                // Get quantity
                const quantity = parseInt(document.getElementById('quantity').value);
                
                // Get personalization text (if available)
                const personalizationText = document.getElementById('personalization-text');
                const personalization = personalizationText ? personalizationText.value : '';
                
                // Check stock
                if (product.stock <= 0) {
                    alert('Sorry, this product is out of stock!');
                    return;
                }
                
                // Check if requested quantity exceeds stock
                if (quantity > product.stock) {
                    alert(`Only ${product.stock} items available in stock.`);
                    return;
                }
                
                // Get existing cart
                let cart = JSON.parse(localStorage.getItem('blissbox_cart')) || [];
                
                // Check if product already in cart
                const existingIndex = cart.findIndex(item => item.id == product.id);
                if (existingIndex !== -1) {
                    // Check total quantity after adding
                    const totalAfterAdd = cart[existingIndex].quantity + quantity;
                    if (totalAfterAdd > product.stock) {
                        alert(`You already have ${cart[existingIndex].quantity} in cart. Maximum available is ${product.stock}.`);
                        return;
                    }
                    cart[existingIndex].quantity += quantity;
                    // Update personalization if provided
                    if (personalization && personalization.trim()) {
                        cart[existingIndex].personalization = personalization;
                    }
                } else {
                    product.quantity = quantity;
                    if (personalization && personalization.trim()) {
                        product.personalization = personalization;
                    }
                    cart.push(product);
                }
                
                // Save to localStorage
                localStorage.setItem('blissbox_cart', JSON.stringify(cart));
                
                // Show success message
                const toast = document.createElement('div');
                toast.className = 'position-fixed top-0 end-0 m-3';
                toast.style.zIndex = '1050';
                toast.innerHTML = `
                    <div class="alert alert-success border-0 shadow-lg" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle fa-2x text-success me-3"></i>
                            <div>
                                <h6 class="mb-1">Added to Cart!</h6>
                                <p class="mb-0 small">${quantity} x "${product.name}" added to your gift cart</p>
                            </div>
                        </div>
                    </div>
                `;
                document.body.appendChild(toast);
                
                // Remove toast after 3 seconds
                setTimeout(() => {
                    toast.remove();
                }, 3000);
                
                // Update cart count in header
                updateCartCount();
                
                // Animate button
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-check me-2"></i>Added to Cart!';
                this.style.background = 'linear-gradient(135deg, #10b981 0%, #34d399 100%)';
                this.disabled = true;
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.style.background = 'linear-gradient(135deg, #db2777 0%, #fbbf24 100%)';
                    this.disabled = false;
                }, 2000);
            });
        }
        
        // Buy Now button
        const buyNowBtn = document.getElementById('buy-now-btn');
        if (buyNowBtn) {
            buyNowBtn.addEventListener('click', function() {
                // First add to cart
                const addToCartEvent = new Event('click');
                if (addToCartBtn) {
                    addToCartBtn.dispatchEvent(addToCartEvent);
                    
                    // Then redirect to checkout after a short delay
                    setTimeout(() => {
                        window.location.href = '{{ route("cart") }}';
                    }, 1500);
                }
            });
        }
        
        // Notify me button
        const notifyBtn = document.getElementById('notify-me');
        if (notifyBtn) {
            notifyBtn.addEventListener('click', function() {
                const email = prompt('Enter your email to be notified when this product is back in stock:');
                if (email && email.includes('@')) {
                    alert(`Thank you! We'll notify you at ${email} when "${document.querySelector('h1').textContent}" is back in stock.`);
                }
            });
        }
        
        // Gallery image switching
        window.changeMainImage = function(thumbnail, imageUrl) {
            // Update main image
            const mainImage = document.querySelector('.main-product-image');
            mainImage.src = imageUrl;
            
            // Update active thumbnail
            document.querySelectorAll('.gallery-thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            thumbnail.classList.add('active');
        };
        
        // Function to update cart count
        function updateCartCount() {
            const cart = JSON.parse(localStorage.getItem('blissbox_cart')) || [];
            const totalItems = cart.reduce((sum, item) => sum + (item.quantity || 1), 0);
            
            // Update all cart count elements
            document.querySelectorAll('#cart-count, .cart-count').forEach(element => {
                element.textContent = totalItems;
                element.style.display = totalItems > 0 ? 'inline-block' : 'none';
            });
        }
        
        // Initialize cart count
        updateCartCount();
    });
</script>
@endsection