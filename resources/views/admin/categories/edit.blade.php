@extends('layouts.app')

@section('title', 'Edit Category - BlissBox Admin')

@section('content')
<div class="container-fluid py-4">
    @include('admin.partials.nav')
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-bold">Edit Category</h1>
            <p class="text-muted mb-0">Update category details</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Categories
        </a>
    </div>

    <!-- Category Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Category Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name *</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $category->name) }}"
                                   required>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" 
                                      id="description" 
                                      name="description" 
                                      rows="3">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
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
                            @error('image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            
                            <!-- Current Image -->
                            @if($category->image)
                            <div class="mt-3">
                                <p class="small text-muted">Current Image:</p>
                                <img src="{{ asset('storage/' . $category->image) }}" 
                                     alt="Current Image" 
                                     class="img-thumbnail me-3" 
                                     style="max-width: 200px;">
                            </div>
                            @endif
                            
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
                                       {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active Category
                                </label>
                            </div>
                            <div class="form-text">Inactive categories won't show in frontend</div>
                            @error('is_active')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
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
                            <span class="text-muted">#{{ $category->id }}</span>
                        </li>
                        <li class="mb-2">
                            <strong>Created:</strong> 
                            <span class="text-muted">{{ $category->created_at->format('M d, Y') }}</span>
                        </li>
                        <li class="mb-2">
                            <strong>Last Updated:</strong> 
                            <span class="text-muted">{{ $category->updated_at->format('M d, Y') }}</span>
                        </li>
                        <li class="mb-2">
                            <strong>Products in this category:</strong> 
                            <span class="text-muted">
                                {{ \App\Models\Product::where('category', $category->name)->count() }}
                            </span>
                        </li>
                    </ul>
                    
                    <!-- Danger Zone -->
                    <div class="mt-4 pt-3 border-top">
                        <h6 class="text-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>Danger Zone
                        </h6>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('WARNING: Deleting this category will NOT delete products in it. Products will remain but will have no category association. Are you sure?')">
                            @csrf
                            @method('DELETE')
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
@endsection