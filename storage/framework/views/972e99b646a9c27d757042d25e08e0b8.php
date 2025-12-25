<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <?php echo $__env->make('admin.partials.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-bold">Edit Product</h1>
            <p class="text-muted mb-0">Update product details</p>
        </div>
        <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Products
        </a>
    </div>

    <!-- Product Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('admin.products.update', $product->id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <!-- Product Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name *</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="name" 
                                   name="name" 
                                   value="<?php echo e(old('name', $product->name)); ?>"
                                   required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" 
                                      id="description" 
                                      name="description" 
                                      rows="3"><?php echo e(old('description', $product->description)); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Price and Category -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price ($) *</label>
                                <input type="number" 
                                       step="0.01" 
                                       class="form-control" 
                                       id="price" 
                                       name="price" 
                                       value="<?php echo e(old('price', $product->price)); ?>"
                                       required>
                                <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Category *</label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="For Him" <?php echo e((old('category', $product->category) == 'For Him') ? 'selected' : ''); ?>>For Him</option>
                                    <option value="For Her" <?php echo e((old('category', $product->category) == 'For Her') ? 'selected' : ''); ?>>For Her</option>
                                    <option value="Birthday" <?php echo e((old('category', $product->category) == 'Birthday') ? 'selected' : ''); ?>>Birthday Specials</option>
                                    <option value="Anniversary" <?php echo e((old('category', $product->category) == 'Anniversary') ? 'selected' : ''); ?>>Anniversary</option>
                                    <option value="Other" <?php echo e((old('category', $product->category) == 'Other') ? 'selected' : ''); ?>>Other</option>
                                </select>
                                <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Image Input -->
                        <div class="mb-3">
                            <label class="form-label">Product Image</label>
                            <div class="mb-2">
                                <small class="text-muted d-block mb-2">Upload a file OR enter an image URL</small>
                                
                                <!-- Tabs for switching between file and URL -->
                                <ul class="nav nav-tabs nav-tabs-sm mb-3" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="file-tab" data-bs-toggle="tab" data-bs-target="#file-panel" type="button" role="tab">
                                            Upload File
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="url-tab" data-bs-toggle="tab" data-bs-target="#url-panel" type="button" role="tab">
                                            Image URL
                                        </button>
                                    </li>
                                </ul>
                                
                                <div class="tab-content">
                                    <!-- File Upload Tab -->
                                    <div class="tab-pane fade show active" id="file-panel" role="tabpanel">
                                        <input type="file" 
                                               class="form-control" 
                                               id="image_file" 
                                               name="image_file" 
                                               accept="image/*">
                                        <div class="form-text mt-1">Max 2MB. Supported: JPG, PNG, GIF. Leave empty to keep current image.</div>
                                    </div>
                                    
                                    <!-- URL Input Tab -->
                                    <div class="tab-pane fade" id="url-panel" role="tabpanel">
                                        <input type="url" 
                                               class="form-control" 
                                               id="image_url" 
                                               name="image_url" 
                                               value="<?php echo e(old('image_url', (filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : ''))); ?>"
                                               placeholder="https://example.com/image.jpg">
                                        <div class="form-text mt-1">Enter a full URL to an image. Leave empty to keep current image.</div>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if($product->image): ?>
                                <div class="mt-3">
                                    <small class="d-block mb-1">Current Image:</small>
                                    <img src="<?php echo e($product->image_url); ?>" 
                                         alt="Product Image" 
                                         class="img-thumbnail" 
                                         style="max-width: 150px;"
                                         onerror="this.src='https://via.placeholder.com/150?text=Image+Not+Found'">
                                    <div class="form-text mt-1">Current: <?php echo e(Str::limit($product->image, 50)); ?></div>
                                </div>
                            <?php endif; ?>
                            <?php $__errorArgs = ['image_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <?php $__errorArgs = ['image_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Features -->
                        <div class="mb-4">
                            <label for="features" class="form-label">Features (comma separated)</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="features" 
                                   name="features" 
                                   value="<?php echo e(old('features', is_array($product->features) ? implode(', ', $product->features) : $product->features)); ?>"
                                   placeholder="Gift Wrapping, Custom Message, Express Delivery">
                            <div class="form-text">Separate multiple features with commas</div>
                            <?php $__errorArgs = ['features'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-between">
                            <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-info-circle text-primary me-2"></i>Product Information
                    </h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <strong>ID:</strong> 
                            <span class="text-muted">#<?php echo e($product->id); ?></span>
                        </li>
                        <li class="mb-2">
                            <strong>Created:</strong> 
                            <span class="text-muted"><?php echo e($product->created_at->format('M d, Y')); ?></span>
                        </li>
                        <li class="mb-2">
                            <strong>Last Updated:</strong> 
                            <span class="text-muted"><?php echo e($product->updated_at->format('M d, Y')); ?></span>
                        </li>
                        <li class="mb-2">
                            <strong>Features Count:</strong> 
                            <span class="text-muted">
                                <?php echo e(is_array($product->features) ? count($product->features) : 0); ?>

                            </span>
                        </li>
                    </ul>
                    
                    <!-- Danger Zone -->
                    <div class="mt-4 pt-3 border-top">
                        <h6 class="text-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>Danger Zone
                        </h6>
                        <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" 
                              method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                <i class="fas fa-trash me-2"></i>Delete This Product
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-control, .form-select {
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    padding: 10px 15px;
}

.form-control:focus, .form-select:focus {
    border-color: #6a11cb;
    box-shadow: 0 0 0 0.25rem rgba(106, 17, 203, 0.1);
}

.card {
    border-radius: 12px;
    border: none;
}

.img-thumbnail {
    border-radius: 8px;
    border: 2px solid #e0e0e0;
}

.border-top {
    border-top: 2px solid #f0f0f0 !important;
}

.nav-tabs-sm .nav-link {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

.nav-tabs-sm .nav-link.active {
    background-color: #6a11cb;
    color: white;
    border-color: #6a11cb;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\blissbox_backup1\blissbox_backup\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>