


<?php $__env->startSection('title', 'BlissBox - Online Gifting Store'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<div class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">Welcome to <span class="text-primary">BlissBox</span></h1>
        <p class="lead mb-4">Your perfect online gifting destination. Find the ideal gift for every occasion.</p>
        
        <!-- Ajax Search Bar -->
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 col-md-10">
                <div class="position-relative">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-primary"></i>
                        </span>
                        <input type="text" 
                               id="homeProductSearch" 
                               class="form-control border-start-0 border-end-0" 
                               placeholder="Search products by name or category..." 
                               autocomplete="off">
                        <button type="button" class="btn btn-outline-secondary border-start-0" id="homeClearSearch" style="display: none;">
                            <i class="fas fa-times"></i>
                        </button>
                        <button type="button" class="btn btn-primary" id="homeSearchBtn" onclick="window.location.href='/products?search=' + encodeURIComponent(document.getElementById('homeProductSearch').value)">
                            <i class="fas fa-search me-2"></i>Search
                        </button>
                    </div>
                    
                    <!-- Search Results Dropdown -->
                    <div id="homeSearchResults" class="position-absolute w-100 bg-white border rounded shadow-lg mt-1" 
                         style="z-index: 1000; max-height: 400px; overflow-y: auto; display: none;">
                        <!-- Results will be populated here via Ajax -->
                    </div>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-center gap-3">
            <a href="/products" class="btn btn-primary btn-lg px-4">
                <i class="fas fa-gift me-2"></i> Browse Gifts
            </a>
            <a href="/contact" class="btn btn-outline-primary btn-lg px-4">
                <i class="fas fa-envelope me-2"></i> Contact Us
            </a>
        </div>
    </div>
</div>

<!-- Featured Categories -->
<div class="container py-5">
    <h2 class="text-center mb-5">Shop by Category</h2>
    <div class="row">
        <div class="col-md-3 col-6 mb-4">
            <a href="/products?category=For+Her" class="text-decoration-none">
                <div class="category-card">
                    <div class="mb-3">
                        <i class="fas fa-female fa-3x text-primary"></i>
                    </div>
                    <h5>For Her</h5>
                    <p class="text-muted small">Special gifts for women</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6 mb-4">
            <a href="/products?category=For+Him" class="text-decoration-none">
                <div class="category-card">
                    <div class="mb-3">
                        <i class="fas fa-male fa-3x text-primary"></i>
                    </div>
                    <h5>For Him</h5>
                    <p class="text-muted small">Perfect gifts for men</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6 mb-4">
            <a href="/products?category=Birthday" class="text-decoration-none">
                <div class="category-card">
                    <div class="mb-3">
                        <i class="fas fa-birthday-cake fa-3x text-primary"></i>
                    </div>
                    <h5>Birthday</h5>
                    <p class="text-muted small">Birthday celebrations</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6 mb-4">
            <a href="/products?category=Anniversary" class="text-decoration-none">
                <div class="category-card">
                    <div class="mb-3">
                        <i class="fas fa-heart fa-3x text-primary"></i>
                    </div>
                    <h5>Anniversary</h5>
                    <p class="text-muted small">Celebrate love</p>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Featured Products -->
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2>Featured Products</h2>
        <a href="/products" class="btn btn-outline-primary">View All <i class="fas fa-arrow-right ms-1"></i></a>
    </div>
    
    <?php if(isset($featuredProducts) && $featuredProducts->count() > 0): ?>
    <div class="row">
        <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card h-100 product-card">
                <?php if($product->image): ?>
                <img src="<?php echo e($product->image_url); ?>" class="card-img-top" alt="<?php echo e($product->name); ?>" style="height: 200px; object-fit: cover;">
                <?php else: ?>
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                    <i class="fas fa-gift fa-3x text-muted"></i>
                </div>
                <?php endif; ?>
                
                <?php if($product->is_featured): ?>
                <span class="featured-badge">Featured</span>
                <?php endif; ?>
                
                <div class="card-body">
                    <h5 class="card-title"><?php echo e($product->name); ?></h5>
                    <p class="card-text text-muted small">
                        <?php echo e(Str::limit($product->description, 60)); ?>

                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 text-primary">$<?php echo e(number_format($product->price, 2)); ?></span>
                        <a href="/product/<?php echo e($product->id); ?>" class="btn btn-sm btn-outline-primary">View</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php else: ?>
    <div class="text-center py-5">
        <i class="fas fa-gift fa-4x text-muted mb-3"></i>
        <h4>No featured products yet</h4>
        <p class="text-muted">Check back soon for amazing gifts!</p>
    </div>
    <?php endif; ?>
</div>

<!-- Why Choose Us -->
<div class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-5">Why Choose BlissBox?</h2>
        <div class="row">
            <div class="col-md-4 text-center mb-4">
                <div class="mb-3">
                    <i class="fas fa-shipping-fast fa-3x text-primary"></i>
                </div>
                <h5>Free Shipping</h5>
                <p class="text-muted">Free delivery on orders over $50</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="mb-3">
                    <i class="fas fa-gift fa-3x text-primary"></i>
                </div>
                <h5>Gift Wrapping</h5>
                <p class="text-muted">Beautiful gift wrapping available</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="mb-3">
                    <i class="fas fa-headset fa-3x text-primary"></i>
                </div>
                <h5>24/7 Support</h5>
                <p class="text-muted">We're here to help anytime</p>
            </div>
        </div>
    </div>
</div>

<!-- Ajax Search Script for Home Page -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('homeProductSearch');
    const searchResults = document.getElementById('homeSearchResults');
    const clearSearchBtn = document.getElementById('homeClearSearch');
    let searchTimeout;
    
    // Show/hide clear button
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            if (this.value.length > 0) {
                clearSearchBtn.style.display = 'block';
            } else {
                clearSearchBtn.style.display = 'none';
                searchResults.style.display = 'none';
            }
        });
    }
    
    // Clear search
    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', function() {
            searchInput.value = '';
            searchResults.style.display = 'none';
            clearSearchBtn.style.display = 'none';
        });
    }
    
    // Ajax search on keyup
    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            const searchTerm = this.value.trim();
            
            // Clear previous timeout
            clearTimeout(searchTimeout);
            
            // Hide results if search is too short
            if (searchTerm.length < 2) {
                searchResults.style.display = 'none';
                return;
            }
            
            // Allow Enter key to submit search
            if (e.key === 'Enter') {
                window.location.href = '/products?search=' + encodeURIComponent(searchTerm);
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
                const searchUrl = '/products/search?q=' + encodeURIComponent(searchTerm);
                
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
                        document.querySelectorAll('#homeSearchResults .search-result-item').forEach(item => {
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
    }
    
    // Hide results when clicking outside
    document.addEventListener('click', function(e) {
        if (searchInput && searchResults && 
            !searchInput.contains(e.target) && 
            !searchResults.contains(e.target) &&
            !clearSearchBtn.contains(e.target)) {
            // Don't hide if we clicked on a result link
            if (!e.target.closest('.search-result-item')) {
                searchResults.style.display = 'none';
            }
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
#homeProductSearch {
    border-radius: 8px 0 0 8px;
    padding: 12px 15px;
}

#homeSearchResults {
    top: 100%;
    left: 0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid #dee2e6;
}

#homeSearchResults .search-result-item:hover {
    background-color: #f8f9fa !important;
}

#homeSearchResults::-webkit-scrollbar {
    width: 6px;
}

#homeSearchResults::-webkit-scrollbar-track {
    background: #f1f1f1;
}

#homeSearchResults::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

#homeSearchResults::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\blissbox_backup1\blissbox_backup\resources\views/pages/home.blade.php ENDPATH**/ ?>