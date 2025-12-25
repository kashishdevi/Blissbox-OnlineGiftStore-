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
            <!-- Ajax Search Bar -->
            <div class="position-relative mb-3">
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" 
                           id="productSearch" 
                           class="form-control" 
                           placeholder="Search products by name or category..." 
                           autocomplete="off"
                           value="{{ request('search') }}">
                    <button type="button" class="btn btn-outline-secondary" id="clearSearch" style="display: none;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <!-- Search Results Dropdown -->
                <div id="searchResults" class="position-absolute w-100 bg-white border rounded shadow-lg mt-1" 
                     style="z-index: 1000; max-height: 400px; overflow-y: auto; display: none;">
                    <!-- Results will be populated here via Ajax -->
                </div>
            </div>
            
            <!-- Category Filter -->
            <form action="/products" method="GET" class="row g-3" id="filterForm">
                <input type="hidden" name="search" id="searchInput" value="{{ request('search') }}">
                <input type="hidden" name="sort_by" value="{{ request('sort_by', 'latest') }}">
                <div class="col-md-6">
                    <select name="category" id="categoryFilter" class="form-select" onchange="document.getElementById('filterForm').submit();">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->name }}" {{ $category == $cat->name ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Apply Filters
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <form action="/products" method="GET" class="row g-3">
                @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div class="col-12">
                    <label for="sort_by" class="form-label small text-muted">Sort by:</label>
                    <select name="sort_by" id="sort_by" class="form-select" onchange="this.form.submit()">
                        <option value="latest" {{ ($sortBy ?? 'latest') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="price_low" {{ ($sortBy ?? '') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ ($sortBy ?? '') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name_asc" {{ ($sortBy ?? '') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                        <option value="name_desc" {{ ($sortBy ?? '') == 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                    </select>
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
                     alt="{{ $product->name }}" style="height: 200px; object-fit: cover;"
                     onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80';">
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

<!-- Ajax Search Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('productSearch');
    const searchResults = document.getElementById('searchResults');
    const clearSearchBtn = document.getElementById('clearSearch');
    const searchInputHidden = document.getElementById('searchInput');
    let searchTimeout;
    
    // Show/hide clear button
    searchInput.addEventListener('input', function() {
        if (this.value.length > 0) {
            clearSearchBtn.style.display = 'block';
        } else {
            clearSearchBtn.style.display = 'none';
            searchResults.style.display = 'none';
        }
    });
    
    // Clear search
    clearSearchBtn.addEventListener('click', function() {
        searchInput.value = '';
        searchInputHidden.value = '';
        searchResults.style.display = 'none';
        clearSearchBtn.style.display = 'none';
        // Reload page to show all products
        window.location.href = '/products';
    });
    
    // Ajax search on keyup
    searchInput.addEventListener('keyup', function(e) {
        const searchTerm = this.value.trim();
        const categoryFilter = document.getElementById('categoryFilter').value;
        
        // Clear previous timeout
        clearTimeout(searchTimeout);
        
        // Hide results if search is too short
        if (searchTerm.length < 2) {
            searchResults.style.display = 'none';
            return;
        }
        
        // Debounce: Wait 300ms after user stops typing
        searchTimeout = setTimeout(function() {
            // Show loading state
            searchResults.innerHTML = `
                <div class="p-3 text-center">
                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span class="ms-2">Searching...</span>
                </div>
            `;
            searchResults.style.display = 'block';
            
            // Build search URL
            let searchUrl = '/products/search?q=' + encodeURIComponent(searchTerm);
            if (categoryFilter) {
                searchUrl += '&category=' + encodeURIComponent(categoryFilter);
            }
            
            // Fetch results via Ajax
            fetch(searchUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    // Display results
                    let html = '';
                    data.forEach(product => {
                        html += `
                            <a href="${product.url}" class="search-result-item d-flex align-items-center p-3 border-bottom text-decoration-none text-dark" style="transition: background-color 0.2s;">
                                <div class="flex-shrink-0 me-3">
                                    ${product.image ? 
                                        `<img src="${product.image}" alt="${product.name}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">` :
                                        `<div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-gift text-muted"></i>
                                        </div>`
                                    }
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold">${escapeHtml(product.name)}</div>
                                    <div class="text-muted small">
                                        <span class="badge bg-primary me-2">${escapeHtml(product.category)}</span>
                                        <span class="text-success">$${product.price}</span>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </div>
                            </a>
                        `;
                    });
                    searchResults.innerHTML = html;
                    
                    // Add hover effects
                    document.querySelectorAll('.search-result-item').forEach(item => {
                        item.addEventListener('mouseenter', function() {
                            this.style.backgroundColor = '#f8f9fa';
                        });
                        item.addEventListener('mouseleave', function() {
                            this.style.backgroundColor = 'white';
                        });
                    });
                } else {
                    // No results found
                    searchResults.innerHTML = `
                        <div class="p-3 text-center text-muted">
                            <i class="fas fa-search me-2"></i>No products found matching "${escapeHtml(searchTerm)}"
                        </div>
                    `;
                }
                searchResults.style.display = 'block';
            })
            .catch(error => {
                console.error('Search error:', error);
                searchResults.innerHTML = `
                    <div class="p-3 text-center text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>Error searching products
                    </div>
                `;
                searchResults.style.display = 'block';
            });
        }, 300); // 300ms debounce
    });
    
    // Hide results when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            // Don't hide if we clicked on a result link
            if (!e.target.closest('.search-result-item')) {
                searchResults.style.display = 'none';
            }
        }
    });
    
    // Handle Enter key - submit form with search
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            searchInputHidden.value = this.value;
            document.getElementById('filterForm').submit();
        }
    });
    
    // Helper function to escape HTML
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }
});
</script>

<style>
#productSearch {
    border-radius: 8px;
    padding: 12px 15px;
}

#searchResults {
    top: 100%;
    left: 0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid #dee2e6;
}

.search-result-item:hover {
    background-color: #f8f9fa !important;
}

#searchResults::-webkit-scrollbar {
    width: 6px;
}

#searchResults::-webkit-scrollbar-track {
    background: #f1f1f1;
}

#searchResults::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

#searchResults::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
@endsection