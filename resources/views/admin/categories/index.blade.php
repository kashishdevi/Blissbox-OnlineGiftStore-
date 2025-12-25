@extends('layouts.app')

@section('title', 'Admin Categories - BlissBox')

@section('content')
<div class="container-fluid py-4">
    @include('admin.partials.nav')
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-bold">Categories Management</h1>
            <p class="text-muted mb-0">Manage your product categories</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Category
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search Bar -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" 
                           id="categorySearch" 
                           class="form-control" 
                           placeholder="Search categories by name or description...">
                    <div id="searchResults" class="list-group mt-2" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="card">
        <div class="card-body">
            @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Products</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" 
                                         class="rounded" 
                                         width="50" 
                                         height="50" 
                                         style="object-fit: cover;">
                                @else
                                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-list text-white"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $category->name }}</strong>
                            </td>
                            <td>
                                @if($category->description)
                                    {{ Str::limit($category->description, 50) }}
                                @else
                                    <span class="text-muted">No description</span>
                                @endif
                            </td>
                            <td>
                                @if($category->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $productCount = \App\Models\Product::where('category', $category->name)->count();
                                @endphp
                                <span class="badge bg-primary">{{ $productCount }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                   class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this category?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger ms-1">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-list fa-3x text-muted mb-3"></i>
                <h4>No categories found</h4>
                <p class="text-muted">Add your first category to get started</p>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add First Category
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mt-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Total Categories</h6>
                            <h2 class="mb-0">{{ $categories->count() }}</h2>
                        </div>
                        <i class="fas fa-list fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Active Categories</h6>
                            <h2 class="mb-0">{{ $categories->where('is_active', true)->count() }}</h2>
                        </div>
                        <i class="fas fa-check-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Total Products</h6>
                            <h2 class="mb-0">{{ \App\Models\Product::count() }}</h2>
                        </div>
                        <i class="fas fa-gift fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Avg Products/Category</h6>
                            <h2 class="mb-0">
                                @if($categories->count() > 0)
                                    {{ round(\App\Models\Product::count() / $categories->count(), 1) }}
                                @else
                                    0
                                @endif
                            </h2>
                        </div>
                        <i class="fas fa-chart-pie fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search JavaScript -->
<script>
document.getElementById('categorySearch').addEventListener('input', function(e) {
    const searchTerm = e.target.value.trim();
    const resultsContainer = document.getElementById('searchResults');
    
    if (searchTerm.length < 2) {
        resultsContainer.style.display = 'none';
        return;
    }
    
    // Show loading
    resultsContainer.innerHTML = '<div class="list-group-item">Searching...</div>';
    resultsContainer.style.display = 'block';
    
    // Fetch results via AJAX
    fetch(`{{ route('admin.categories.search') }}?search=${encodeURIComponent(searchTerm)}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.length > 0) {
            resultsContainer.innerHTML = '';
            data.forEach(category => {
                const item = document.createElement('a');
                item.href = `/admin/categories/${category.id}/edit`;
                item.className = 'list-group-item list-group-item-action';
                item.innerHTML = `
                    <div class="d-flex align-items-center">
                        ${category.image ? 
                            `<img src="/storage/${category.image}" alt="${category.name}" class="rounded me-3" width="40" height="40">` : 
                            `<div class="bg-secondary rounded d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-list text-white"></i>
                            </div>`
                        }
                        <div>
                            <strong>${category.name}</strong>
                            ${category.description ? `<br><small class="text-muted">${category.description.substring(0, 50)}${category.description.length > 50 ? '...' : ''}</small>` : ''}
                        </div>
                    </div>
                `;
                resultsContainer.appendChild(item);
            });
        } else {
            resultsContainer.innerHTML = '<div class="list-group-item">No categories found</div>';
        }
    })
    .catch(error => {
        console.error('Search error:', error);
        resultsContainer.innerHTML = '<div class="list-group-item text-danger">Error searching</div>';
    });
});

// Hide results when clicking outside
document.addEventListener('click', function(e) {
    const searchInput = document.getElementById('categorySearch');
    const resultsContainer = document.getElementById('searchResults');
    
    if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
        resultsContainer.style.display = 'none';
    }
});
</script>

<style>
.alert {
    border-radius: 10px;
    border: none;
}

.badge {
    font-size: 0.8rem;
    padding: 5px 10px;
}

.table th {
    font-weight: 600;
    color: #6c757d;
    border-bottom: 2px solid #dee2e6;
}

.table td {
    vertical-align: middle;
}

.card {
    border-radius: 12px;
    border: none;
}

.list-group-item {
    cursor: pointer;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}
</style>
@endsection