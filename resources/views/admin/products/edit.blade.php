@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-bold">Edit Product</h1>
            <p class="text-muted mb-0">Update product details</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Products
        </a>
    </div>

    <!-- Product Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Product Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name *</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $product->name) }}"
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
                                      rows="3">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
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
                                       value="{{ old('price', $product->price) }}"
                                       required>
                                @error('price')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Category *</label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="For Him" {{ (old('category', $product->category) == 'For Him') ? 'selected' : '' }}>For Him</option>
                                    <option value="For Her" {{ (old('category', $product->category) == 'For Her') ? 'selected' : '' }}>For Her</option>
                                    <option value="Birthday" {{ (old('category', $product->category) == 'Birthday') ? 'selected' : '' }}>Birthday Specials</option>
                                    <option value="Anniversary" {{ (old('category', $product->category) == 'Anniversary') ? 'selected' : '' }}>Anniversary</option>
                                    <option value="Other" {{ (old('category', $product->category) == 'Other') ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('category')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Image URL -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Image URL</label>
                            <input type="url" 
                                   class="form-control" 
                                   id="image" 
                                   name="image" 
                                   value="{{ old('image', $product->image) }}"
                                   placeholder="https://example.com/image.jpg">
                            @if($product->image)
                                <div class="mt-2">
                                    <small>Current Image:</small>
                                    <img src="{{ $product->image }}" 
                                         alt="Product Image" 
                                         class="img-thumbnail mt-1" 
                                         style="max-width: 150px;">
                                </div>
                            @endif
                            @error('image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Features -->
                        <div class="mb-4">
                            <label for="features" class="form-label">Features (comma separated)</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="features" 
                                   name="features" 
                                   value="{{ old('features', is_array($product->features) ? implode(', ', $product->features) : $product->features) }}"
                                   placeholder="Gift Wrapping, Custom Message, Express Delivery">
                            <div class="form-text">Separate multiple features with commas</div>
                            @error('features')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
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
                            <span class="text-muted">#{{ $product->id }}</span>
                        </li>
                        <li class="mb-2">
                            <strong>Created:</strong> 
                            <span class="text-muted">{{ $product->created_at->format('M d, Y') }}</span>
                        </li>
                        <li class="mb-2">
                            <strong>Last Updated:</strong> 
                            <span class="text-muted">{{ $product->updated_at->format('M d, Y') }}</span>
                        </li>
                        <li class="mb-2">
                            <strong>Features Count:</strong> 
                            <span class="text-muted">
                                {{ is_array($product->features) ? count($product->features) : 0 }}
                            </span>
                        </li>
                    </ul>
                    
                    <!-- Danger Zone -->
                    <div class="mt-4 pt-3 border-top">
                        <h6 class="text-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>Danger Zone
                        </h6>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
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
</style>
@endsection