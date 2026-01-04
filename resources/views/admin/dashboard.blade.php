@extends('layouts.app')

@section('title', 'Admin Dashboard - BlissBox')

@section('content')
<div class="admin-layout">
    @include('admin.layouts.sidebar')
    
    <div class="admin-content">
        <div class="content-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold mb-1">Dashboard Overview</h1>
                    <p class="text-muted mb-0">Welcome back, {{ Auth::user()->name ?? 'Admin' }}!</p>
                </div>
                <div class="text-muted">
                    <i class="fas fa-clock me-1"></i>{{ now()->format('F d, Y h:i A') }}
                </div>
            </div>
        </div>

        <div class="content-body">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Overview Cards -->
            <div class="row g-4 mb-4">
                <!-- Total Orders Card -->
                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('admin.orders.index') }}" class="overview-card card-link">
                        <div class="card border-0 shadow-sm h-100 overview-card-hover">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="text-uppercase text-muted small fw-bold mb-2">Total Orders</h6>
                                        <h2 class="mb-0 fw-bold" style="color: #8b5cf6;">{{ $totalOrders }}</h2>
                                    </div>
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                        <i class="fas fa-shopping-cart fa-lg text-primary"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <span class="text-primary text-decoration-none small fw-bold">
                                        View All Orders <i class="fas fa-arrow-right ms-1"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Pending Orders Card -->
                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="overview-card card-link">
                        <div class="card border-0 shadow-sm h-100 overview-card-hover">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="text-uppercase text-muted small fw-bold mb-2">Pending Orders</h6>
                                        <h2 class="mb-0 fw-bold" style="color: #f59e0b;">{{ $pendingOrders }}</h2>
                                    </div>
                                    <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                        <i class="fas fa-clock fa-lg text-warning"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <span class="text-warning text-decoration-none small fw-bold">
                                        View Pending <i class="fas fa-arrow-right ms-1"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Total Products Card -->
                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('admin.products.index') }}" class="overview-card card-link">
                        <div class="card border-0 shadow-sm h-100 overview-card-hover">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="text-uppercase text-muted small fw-bold mb-2">Total Products</h6>
                                        <h2 class="mb-0 fw-bold" style="color: #10b981;">{{ $totalProducts }}</h2>
                                    </div>
                                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                        <i class="fas fa-gift fa-lg text-success"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <span class="text-success text-decoration-none small fw-bold">
                                        Manage Products <i class="fas fa-arrow-right ms-1"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Total Revenue Card -->
                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('admin.revenue') }}" class="overview-card card-link">
                        <div class="card border-0 shadow-sm h-100 overview-card-hover">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="text-uppercase text-muted small fw-bold mb-2">Total Revenue</h6>
                                        <h2 class="mb-0 fw-bold" style="color: #0ea5e9;">${{ number_format($totalRevenue ?? 0, 2) }}</h2>
                                    </div>
                                    <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                        <i class="fas fa-dollar-sign fa-lg text-info"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <span class="text-info text-decoration-none small fw-bold">
                                        View Revenue <i class="fas fa-arrow-right ms-1"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <!-- Quick Stats -->
                <div class="col-xl-12">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="mb-0 fw-bold" style="color: #1e293b;">Store Statistics</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3">
                                    <div>
                                        <i class="fas fa-tags text-primary me-2"></i>
                                        <span style="color: #64748b;">Categories</span>
                                    </div>
                                    <strong style="color: #1e293b;">{{ $totalCategories }}</strong>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3">
                                    <div>
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <span style="color: #64748b;">Active Products</span>
                                    </div>
                                    <strong style="color: #1e293b;">{{ \App\Models\Product::where('is_active', true)->count() }}</strong>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3">
                                    <div>
                                        <i class="fas fa-star text-warning me-2"></i>
                                        <span style="color: #64748b;">Featured Products</span>
                                    </div>
                                    <strong style="color: #1e293b;">{{ \App\Models\Product::where('is_featured', true)->count() }}</strong>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3">
                                    <div>
                                        <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                                        <span style="color: #64748b;">Out of Stock</span>
                                    </div>
                                    <strong class="fw-bold" style="color: #ef4444;">{{ \App\Models\Product::where('in_stock', false)->count() }}</strong>
                                </div>
                            </div>
                            
                            <hr class="my-3">
                            
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add New Product
                                </a>
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus me-2"></i>Add New Category
                                </a>
                            </div>
                        </div>
                    </div>
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

.overview-card {
    text-decoration: none;
    display: block;
}

.overview-card-hover {
    transition: all 0.3s ease;
    cursor: pointer;
}

.overview-card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
}

.card {
    border-radius: 12px;
}

.card-header {
    border-bottom: 1px solid #e2e8f0;
}

.badge {
    font-size: 0.75rem;
    padding: 4px 8px;
    border-radius: 4px;
}

.list-group-item {
    background-color: transparent;
}

@media (max-width: 768px) {
    .admin-content {
        margin-left: 0;
        padding: 1rem;
    }
    
    .admin-sidebar {
        transform: translateX(-100%);
    }
    
    .admin-sidebar.open {
        transform: translateX(0);
    }
}
</style>
@endsection
