@extends('layouts.app')

@section('title', 'Products - BlissBox')

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="mb-5">
        <h1 class="mb-3">Our Gift Collection</h1>
        @if($category)
        <p class="lead">Showing gifts in: <span class="badge bg-primary">{{ $category }}</span></p>
        @endif
    </div>

    <!-- Search and Filter -->
    <div class="row mb-5">
        <div class="col-md-8">
            <form action="/products" method="GET" class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search products..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select name="category" class="form-select" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->name }}" {{ $category == $cat->name ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="card h-100 product-card">
                @if($product->image)
                <img src="{{ $product->image_url }}" class="card-img-top" 
                     alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                @else
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                     style="height: 200px;">
                    <i class="fas fa-gift fa-3x text-muted"></i>
                </div>
                @endif
                
                <div class="card-body">
                    <div class="mb-2">
                        <span class="badge bg-primary">{{ $product->category }}</span>
                        @if($product->is_featured)
                        <span class="badge bg-warning ms-1">Featured</span>
                        @endif
                    </div>
                    
                    <h5 class="card-title">{{ $product->name }}</h5>
                    
                    <p class="card-text text-muted small">
                        {{ Str::limit($product->description, 80) }}
                    </p>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            @if($product->discount_price)
                            <span class="text-danger h5">${{ number_format($product->discount_price, 2) }}</span>
                            <span class="text-muted text-decoration-line-through small">
                                ${{ number_format($product->price, 2) }}
                            </span>
                            @else
                            <span class="h5">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                    </div>
                    
                    @if($product->in_stock)
                    <div class="mt-2">
                        <small class="text-success">
                            <i class="fas fa-check-circle"></i> In Stock
                        </small>
                    </div>
                    @else
                    <div class="mt-2">
                        <small class="text-danger">
                            <i class="fas fa-times-circle"></i> Out of Stock
                        </small>
                    </div>
                    @endif
                    
                   <!-- Action Buttons -->
                  <div class="d-flex gap-2 mt-3">
                     <a href="/product/{{ $product->id }}" class="btn btn-outline-secondary btn-sm flex-grow-1">
                          View Details
                     </a>
      @if($product->in_stock)
        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="quantity" value="1">
              <button type="submit" class="btn btn-primary btn-sm" title="Add to Cart">
            <i class="fas fa-cart-plus"></i>
        </button>
             </form>
                 @endif
             </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
    @else
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="fas fa-search fa-3x text-muted"></i>
        </div>
        <h4>No products found</h4>
        <p class="text-muted">Try adjusting your search or filter</p>
        <a href="/products" class="btn btn-primary">Clear Filters</a>
    </div>
    @endif
</div>
@endsection