@extends('layouts.app')

@section('title', 'Add Product - BlissBox Admin')

@section('content')
<div class="admin-layout">
    @include('admin.layouts.sidebar')
    
    <div class="admin-content">
        <div class="content-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold mb-1">Add New Product</h1>
                    <p class="text-muted mb-0">Create a new product</p>
                </div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i> Back to Products
                </a>
            </div>
        </div>

        <div class="content-body">
            <div class="card">
        <div class="card-body">
            <form action="/admin/products" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name *</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ old('name') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="4" required>{{ old('description') }}</textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price * ($)</label>
                                <input type="number" step="0.01" class="form-control" id="price" 
                                       name="price" value="{{ old('price') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="discount_price" class="form-label">Discount Price ($)</label>
                                <input type="number" step="0.01" class="form-control" id="discount_price" 
                                       name="discount_price" value="{{ old('discount_price') }}">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="features" class="form-label">Features (comma separated)</label>
                            <input type="text" class="form-control" id="features" name="features" 
                                   value="{{ old('features') }}" placeholder="e.g., Free Gift Wrap, Eco-friendly, Handmade">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="category" class="form-label">Category *</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="">Select Category</option>
                                @if(isset($categories) && $categories->count() > 0)
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->name }}" {{ old('category') == $cat->name ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="For Her" {{ old('category') == 'For Her' ? 'selected' : '' }}>For Her</option>
                                    <option value="For Him" {{ old('category') == 'For Him' ? 'selected' : '' }}>For Him</option>
                                    <option value="Birthday" {{ old('category') == 'Birthday' ? 'selected' : '' }}>Birthday</option>
                                    <option value="Anniversary" {{ old('category') == 'Anniversary' ? 'selected' : '' }}>Anniversary</option>
                                    <option value="Special Occasion" {{ old('category') == 'Special Occasion' ? 'selected' : '' }}>Special Occasion</option>
                                @endif
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Product Image *</label>
                            <input type="file" class="form-control" id="image" name="image" 
                                   accept="image/*" required>
                            <div class="form-text">Max 2MB. Supported: JPG, PNG, GIF</div>
                            <div id="imagePreview" class="mt-2"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="stock_quantity" class="form-label">Stock Quantity *</label>
                            <input type="number" class="form-control" id="stock_quantity" 
                                   name="stock_quantity" value="{{ old('stock_quantity', 0) }}" min="0" required>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="in_stock" 
                                       name="in_stock" value="1" checked>
                                <label class="form-check-label" for="in_stock">In Stock</label>
                            </div>
                            
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_featured" 
                                       name="is_featured" value="1">
                                <label class="form-check-label" for="is_featured">Featured Product</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-end">
                    <button type="reset" class="btn btn-secondary me-2">Reset</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>
        </div>
    </div>
</div>

<style>
.admin-layout {
    display: flex;
    min-height: 100vh;
    background-color: #f8fafc;
}

.admin-content {
    flex: 1;
    margin-left: 280px;
    padding: 2rem;
    transition: margin-left 0.3s;
}

.content-header {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
}

.content-body {
    /* Content body styles */
}

.card {
    border-radius: 12px;
}

@media (max-width: 768px) {
    .admin-content {
        margin-left: 0;
        padding: 1rem;
    }
}
</style>

<script>
    // Image preview
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.maxWidth = '200px';
                preview.appendChild(img);
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection