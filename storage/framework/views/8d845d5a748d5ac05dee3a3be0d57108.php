
<div class="admin-sidebar">
    <div class="sidebar-header">
        <h4 class="mb-0">
            <i class="fas fa-user-cog me-2"></i>Admin Panel
        </h4>
    </div>
    
    <nav class="sidebar-nav">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        
        <div class="nav-section">
            <h6 class="nav-section-title">Overview</h6>
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>">
                <i class="fas fa-shopping-cart"></i>
                <span>Total Orders</span>
                <?php if(isset($totalOrders)): ?>
                <span class="badge"><?php echo e($totalOrders); ?></span>
                <?php endif; ?>
            </a>
            
            <a href="<?php echo e(route('admin.orders.index', ['status' => 'pending'])); ?>" class="nav-item">
                <i class="fas fa-clock"></i>
                <span>Pending Orders</span>
                <?php if(isset($pendingOrders)): ?>
                <span class="badge bg-warning"><?php echo e($pendingOrders); ?></span>
                <?php endif; ?>
            </a>
            
            <a href="<?php echo e(route('admin.products.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.products.*') ? 'active' : ''); ?>">
                <i class="fas fa-gift"></i>
                <span>Manage Products</span>
                <?php if(isset($totalProducts)): ?>
                <span class="badge bg-success"><?php echo e($totalProducts); ?></span>
                <?php endif; ?>
            </a>
            
            <a href="<?php echo e(route('admin.categories.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>">
                <i class="fas fa-tags"></i>
                <span>Manage Categories</span>
            </a>
            
            <a href="<?php echo e(route('admin.revenue')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.revenue') ? 'active' : ''); ?>">
                <i class="fas fa-dollar-sign"></i>
                <span>Total Revenue</span>
                <?php if(isset($totalRevenue)): ?>
                <span class="badge bg-info">$<?php echo e(number_format($totalRevenue, 0)); ?></span>
                <?php endif; ?>
            </a>
        </div>
        
        <div class="nav-section">
            <h6 class="nav-section-title">Quick Actions</h6>
            <a href="<?php echo e(route('admin.products.create')); ?>" class="nav-item">
                <i class="fas fa-plus-circle"></i>
                <span>Add Product</span>
            </a>
            <a href="<?php echo e(route('admin.categories.create')); ?>" class="nav-item">
                <i class="fas fa-plus-circle"></i>
                <span>Add Category</span>
            </a>
        </div>
        
        <div class="nav-section">
            <a href="<?php echo e(route('home')); ?>" class="nav-item" target="_blank">
                <i class="fas fa-external-link-alt"></i>
                <span>View Store</span>
            </a>
        </div>
    </nav>
    
    <div class="sidebar-footer">
        <?php if(auth()->guard()->check()): ?>
        <div class="user-info">
            <i class="fas fa-user-circle"></i>
            <div>
                <div class="user-name"><?php echo e(Auth::user()->name ?? 'Admin'); ?></div>
                <small class="text-muted">Administrator</small>
            </div>
        </div>
        <form action="<?php echo e(route('admin.logout')); ?>" method="POST" class="mt-2">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-sm btn-outline-light w-100">
                <i class="fas fa-sign-out-alt me-1"></i>Logout
            </button>
        </form>
        <?php endif; ?>
    </div>
</div>

<style>
.admin-sidebar {
    position: fixed;
    left: 0;
    top: 0;
    height: 100vh;
    width: 280px;
    background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
    color: white;
    display: flex;
    flex-direction: column;
    z-index: 1000;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    overflow-y: auto;
}

.sidebar-header {
    padding: 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(0, 0, 0, 0.2);
}

.sidebar-header h4 {
    color: white;
    font-weight: 700;
    font-size: 1.25rem;
}

.sidebar-nav {
    flex: 1;
    padding: 1rem 0;
    overflow-y: auto;
}

.nav-section {
    margin-bottom: 1.5rem;
}

.nav-section-title {
    padding: 0.5rem 1.5rem;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: rgba(255, 255, 255, 0.5);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.nav-item {
    display: flex;
    align-items: center;
    padding: 0.875rem 1.5rem;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: all 0.3s;
    border-left: 3px solid transparent;
    position: relative;
}

.nav-item i {
    width: 20px;
    margin-right: 0.75rem;
    font-size: 1rem;
}

.nav-item span:not(.badge) {
    flex: 1;
}

.nav-item .badge {
    margin-left: auto;
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
}

.nav-item:hover {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border-left-color: #8b5cf6;
}

.nav-item.active {
    background: linear-gradient(90deg, rgba(139, 92, 246, 0.2) 0%, transparent 100%);
    color: white;
    border-left-color: #8b5cf6;
    font-weight: 600;
}

.sidebar-footer {
    padding: 1.5rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(0, 0, 0, 0.2);
}

.user-info {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.user-info i {
    font-size: 2rem;
    margin-right: 0.75rem;
    color: rgba(255, 255, 255, 0.8);
}

.user-name {
    font-weight: 600;
    font-size: 0.9rem;
}

/* Scrollbar styling */
.admin-sidebar::-webkit-scrollbar {
    width: 6px;
}

.admin-sidebar::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.2);
}

.admin-sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 3px;
}

.admin-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.3);
}

@media (max-width: 768px) {
    .admin-sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s;
    }
    
    .admin-sidebar.open {
        transform: translateX(0);
    }
}
</style>

<?php /**PATH C:\xampp\htdocs\blissbox_backup1\blissbox_backup\resources\views/admin/layouts/sidebar.blade.php ENDPATH**/ ?>