

<?php $__env->startSection('title', 'Edit Category - BlissBox Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <?php echo $__env->make('admin.partials.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-bold">Edit Category</h1>
            <p class="text-muted mb-0">Update category details</p>
        </div>
        <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Categories
        </a>
    </div>

    <!-- Category Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('admin.categories.update', $category->id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <!-- Category Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name *</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="name" 
                                   name="name" 
                                   value="<?php echo e(old('name', $category->name)); ?>"
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
                                      rows="3"><?php echo e(old('description', $category->description)); ?></textarea>
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

                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Category Image</label>
                            <input type="file" 
                                   class="form-control" 
                                   id="image" 
                                   name="image"
                                   accept="image/*">
                            <div class="form-text">
                                Leave empty to keep current image. Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB
                            </div>
                            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            
                            <!-- Current Image -->
                            <?php if($category->image): ?>
                            <div class="mt-3">
                                <p class="small text-muted">Current Image:</p>
                                <img src="<?php echo e(asset('storage/' . $category->image)); ?>" 
                                     alt="Current Image" 
                                     class="img-thumbnail me-3" 
                                     style="max-width: 200px;">
                            </div>
                            <?php endif; ?>
                            
                            <!-- New Image Preview -->
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <p class="small text-muted">New Image Preview:</p>
                                <img id="previewImage" src="#" alt="Image Preview" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        </div>

                        <!-- Active Status -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1"
                                       <?php echo e(old('is_active', $category->is_active) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="is_active">
                                    Active Category
                                </label>
                            </div>
                            <div class="form-text">Inactive categories won't show in frontend</div>
                            <?php $__errorArgs = ['is_active'];
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
                            <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Category
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
                        <i class="fas fa-info-circle text-primary me-2"></i>Category Information
                    </h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <strong>ID:</strong> 
                            <span class="text-muted">#<?php echo e($category->id); ?></span>
                        </li>
                        <li class="mb-2">
                            <strong>Created:</strong> 
                            <span class="text-muted"><?php echo e($category->created_at->format('M d, Y')); ?></span>
                        </li>
                        <li class="mb-2">
                            <strong>Last Updated:</strong> 
                            <span class="text-muted"><?php echo e($category->updated_at->format('M d, Y')); ?></span>
                        </li>
                        <li class="mb-2">
                            <strong>Products in this category:</strong> 
                            <span class="text-muted">
                                <?php echo e(\App\Models\Product::where('category', $category->name)->count()); ?>

                            </span>
                        </li>
                    </ul>
                    
                    <!-- Danger Zone -->
                    <div class="mt-4 pt-3 border-top">
                        <h6 class="text-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>Danger Zone
                        </h6>
                        <form action="<?php echo e(route('admin.categories.destroy', $category->id)); ?>" 
                              method="POST" 
                              onsubmit="return confirm('WARNING: Deleting this category will NOT delete products in it. Products will remain but will have no category association. Are you sure?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                <i class="fas fa-trash me-2"></i>Delete This Category
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Preview Script -->
<script>
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('previewImage');
    const previewContainer = document.getElementById('imagePreview');
    
    if (file) {
        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (!validTypes.includes(file.type)) {
            alert('Please select a valid image file (JPEG, PNG, JPG, GIF)');
            e.target.value = '';
            previewContainer.style.display = 'none';
            return;
        }
        
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Image size should be less than 2MB');
            e.target.value = '';
            previewContainer.style.display = 'none';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        previewContainer.style.display = 'none';
    }
});
</script>

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
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\blissbox_backup1\blissbox_backup\resources\views/admin/categories/edit.blade.php ENDPATH**/ ?>