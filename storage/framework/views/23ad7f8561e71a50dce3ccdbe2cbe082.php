<?php $__env->startSection('title', 'Admin Products - BlissBox'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <?php echo $__env->make('admin.partials.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Product Management</h1>
        <a href="/admin/products/create" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add New Product
        </a>
    </div>
    
    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-body">
            <?php if($products->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($product->id); ?></td>
                            <td>
                                <?php if($product->image): ?>
                                <img src="<?php echo e(asset($product->image)); ?>" alt="<?php echo e($product->name); ?>" 
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                <?php else: ?>
                                <div style="width: 50px; height: 50px; background: #eee; border-radius: 5px; 
                                            display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-gift text-muted"></i>
                                </div>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($product->name); ?></td>
                            <td>
                                <span class="badge bg-primary"><?php echo e($product->category); ?></span>
                            </td>
                            <td>$<?php echo e(number_format($product->price, 2)); ?></td>
                            <td><?php echo e($product->stock_quantity); ?></td>
                            <td>
                                <?php if($product->in_stock): ?>
                                <span class="badge bg-success">In Stock</span>
                                <?php else: ?>
                                <span class="badge bg-danger">Out of Stock</span>
                                <?php endif; ?>
                                <?php if($product->is_featured): ?>
                                <span class="badge bg-warning ms-1">Featured</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="/product/<?php echo e($product->id); ?>" class="btn btn-sm btn-info" 
                                       target="_blank" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/admin/products/<?php echo e($product->id); ?>/edit" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/admin/products/<?php echo e($product->id); ?>" method="POST" 
                                          class="d-inline" onsubmit="return confirm('Delete this product?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                <?php echo e($products->links()); ?>

            </div>
            <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h4>No products found</h4>
                <p class="text-muted">Add your first product to get started</p>
                <a href="/admin/products/create" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i> Add Product
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\blissbox_backup1\blissbox_backup\resources\views/admin/products/index.blade.php ENDPATH**/ ?>