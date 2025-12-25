@extends('layouts.app')

@section('title', 'Admin Products - BlissBox')

@section('content')
<div class="container-fluid py-4">
    @include('admin.partials.nav')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Product Management</h1>
        <a href="/admin/products/create" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add New Product
        </a>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            @if($products->count() > 0)
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
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                @if($product->image)
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" 
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                @else
                                <div style="width: 50px; height: 50px; background: #eee; border-radius: 5px; 
                                            display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-gift text-muted"></i>
                                </div>
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $product->category }}</span>
                            </td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->stock_quantity }}</td>
                            <td>
                                @if($product->in_stock)
                                <span class="badge bg-success">In Stock</span>
                                @else
                                <span class="badge bg-danger">Out of Stock</span>
                                @endif
                                @if($product->is_featured)
                                <span class="badge bg-warning ms-1">Featured</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="/product/{{ $product->id }}" class="btn btn-sm btn-info" 
                                       target="_blank" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/admin/products/{{ $product->id }}/edit" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/admin/products/{{ $product->id }}" method="POST" 
                                          class="d-inline" onsubmit="return confirm('Delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $products->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h4>No products found</h4>
                <p class="text-muted">Add your first product to get started</p>
                <a href="/admin/products/create" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i> Add Product
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection