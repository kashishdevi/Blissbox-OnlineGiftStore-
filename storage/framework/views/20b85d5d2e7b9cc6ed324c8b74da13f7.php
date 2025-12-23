


<?php $__env->startSection('title', 'BlissBox - Online Gifting Store'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<div class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">Welcome to <span class="text-primary">BlissBox</span></h1>
        <p class="lead mb-4">Your perfect online gifting destination. Find the ideal gift for every occasion.</p>
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
                <img src="<?php echo e(asset($product->image)); ?>" class="card-img-top" alt="<?php echo e($product->name); ?>" style="height: 200px; object-fit: cover;">
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\blissbox_backup1\blissbox_backup\resources\views/pages/home.blade.php ENDPATH**/ ?>