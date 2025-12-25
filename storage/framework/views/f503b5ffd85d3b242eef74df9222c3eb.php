


<nav class="navbar navbar-expand-lg navbar-light fixed-top bg-white shadow-sm">
    <div class="container">
        <!-- Brand Logo -->
        <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
            <i class="fas fa-gift" style="background: linear-gradient(135deg, #ec4899, #8b5cf6, #fbbf24); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i> 
            <span style="background: linear-gradient(135deg, #ec4899, #8b5cf6, #fbbf24); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 800;">BlissBox</span>
        </a>
        
        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Navigation Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">
                        <i class="fas fa-home me-1" style="color: #ec4899;"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('products') || request()->is('products*') ? 'active' : ''); ?>" 
                       href="<?php echo e(route('products')); ?>">
                        <i class="fas fa-box-open me-1" style="color: #8b5cf6;"></i> Shop
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php echo e(request()->has('category') ? 'active' : ''); ?>" 
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-tags me-1" style="color: #fbbf24;"></i> Categories
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('products', ['category' => 'For Her'])); ?>">
                                <i class="fas fa-female me-2" style="color: #ec4899;"></i> For Her
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('products', ['category' => 'For Him'])); ?>">
                                <i class="fas fa-male me-2" style="color: #8b5cf6;"></i> For Him
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('products', ['category' => 'Birthday'])); ?>">
                                <i class="fas fa-birthday-cake me-2" style="color: #fbbf24;"></i> Birthday
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('products', ['category' => 'Anniversary'])); ?>">
                                <i class="fas fa-heart me-2" style="color: #ec4899;"></i> Anniversary
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('contact') ? 'active' : ''); ?>" 
                       href="<?php echo e(route('contact')); ?>">
                        <i class="fas fa-envelope me-1" style="color: #8b5cf6;"></i> Contact
                    </a>
                </li>
            </ul>
            
            <!-- Right Side Actions -->
            <div class="d-flex align-items-center">
                <!-- Search -->
                <div class="d-none d-lg-block me-3">
                    <form action="<?php echo e(route('products')); ?>" method="GET" class="d-flex">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control search-box" 
                                   placeholder="Search gifts..." 
                                   value="<?php echo e(request('search')); ?>"
                                   aria-label="Search"
                                   style="border: 2px solid #8b5cf6; border-right: none; border-radius: 25px 0 0 25px;">
                            <button type="submit" class="btn" style="background: linear-gradient(135deg, #ec4899, #8b5cf6); color: white; border-radius: 0 25px 25px 0; border: 2px solid transparent;">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Cart -->
                <a href="<?php echo e(route('cart')); ?>" class="btn position-relative me-3 cart-btn" 
                   style="background: linear-gradient(135deg, #ec4899, #8b5cf6); color: white; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-shopping-cart"></i>
                    <?php
                        $cartCount = 0;
                        if(session()->has('cart')) {
                            $cart = session('cart');
                            if(is_array($cart)) {
                                foreach($cart as $item) {
                                    if(isset($item['quantity'])) {
                                        $cartCount += $item['quantity'];
                                    } else {
                                        $cartCount += 1;
                                    }
                                }
                            }
                        }
                    ?>
                    <?php if($cartCount > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" 
                              style="background: linear-gradient(135deg, #fbbf24, #ec4899); font-size: 0.7rem; padding: 0.25em 0.6em;">
                            <?php echo e($cartCount); ?>

                        </span>
                    <?php endif; ?>
                </a>
                
                <!-- Admin Link -->
                <a href="<?php echo e(url('/admin')); ?>" class="btn" style="background: linear-gradient(135deg, #fbbf24, #ec4899); color: #1f2937; border: none; font-weight: 600; padding: 10px 20px; border-radius: 12px;">
                    <i class="fas fa-user-cog me-1"></i> Admin
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Search (hidden on desktop) -->
<div class="d-block d-lg-none container mt-2">
    <form action="<?php echo e(route('products')); ?>" method="GET" class="d-flex">
        <input type="text" name="search" class="form-control" 
               placeholder="Search gifts..." value="<?php echo e(request('search')); ?>"
               style="border: 2px solid #8b5cf6; border-radius: 25px 0 0 25px;">
        <button type="submit" class="btn ms-2" style="background: linear-gradient(135deg, #ec4899, #8b5cf6); color: white; border-radius: 0 25px 25px 0;">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>

<!-- Add some CSS for better styling -->
<style>
    .navbar {
        padding: 1rem 0;
        transition: all 0.3s ease;
        border-bottom: 3px solid transparent;
        border-image: linear-gradient(135deg, #ec4899, #8b5cf6, #fbbf24);
        border-image-slice: 1;
    }
    
    .navbar-brand {
        font-size: 1.8rem;
        font-weight: 800;
    }
    
    .nav-link {
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: all 0.2s ease;
        color: #1f2937 !important;
    }
    
    .nav-link:hover, .nav-link.active {
        background: linear-gradient(135deg, rgba(236, 72, 153, 0.1), rgba(139, 92, 246, 0.1));
        color: #ec4899 !important;
        transform: translateY(-2px);
    }
    
    .dropdown-menu {
        border: none;
        box-shadow: 0 10px 25px rgba(236, 72, 153, 0.15);
        border-radius: 16px;
        padding: 0.5rem 0;
        border-left: 4px solid #8b5cf6;
    }
    
    .dropdown-item {
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        margin: 0.1rem 0.5rem;
        transition: all 0.2s ease;
        color: #1f2937;
    }
    
    .dropdown-item:hover {
        background: linear-gradient(135deg, rgba(236, 72, 153, 0.1), rgba(139, 92, 246, 0.1));
        color: #ec4899 !important;
    }
    
    /* Mobile adjustments */
    @media (max-width: 991.98px) {
        .navbar-collapse {
            background: white;
            padding: 1.5rem;
            border-radius: 16px;
            margin-top: 1rem;
            box-shadow: 0 10px 25px rgba(236, 72, 153, 0.15);
            border: 2px solid transparent;
            border-image: linear-gradient(135deg, #ec4899, #8b5cf6);
            border-image-slice: 1;
        }
        
        .nav-link {
            margin-bottom: 0.5rem;
            padding: 0.8rem 1rem;
        }
        
        .dropdown-menu {
            box-shadow: none;
            border-left: 4px solid #fbbf24;
            margin-left: 1rem;
        }
    }
</style>

<!-- Simple functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit search on mobile when pressing Enter
    const searchInputs = document.querySelectorAll('input[name="search"]');
    searchInputs.forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                this.closest('form').submit();
            }
        });
    });
});
</script><?php /**PATH C:\xampp\htdocs\blissbox_backup\resources\views/partials/header.blade.php ENDPATH**/ ?>