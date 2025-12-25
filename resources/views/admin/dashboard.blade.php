@extends('layouts.app')

@section('title', 'Admin Dashboard - BlissBox')

@section('content')
<div class="container-fluid py-4">
    @include('admin.partials.nav')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold" style="color: #1e293b;">Dashboard Overview</h1>
        <div class="text-muted">
            Last updated: {{ now()->format('F d, Y h:i A') }}
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Total Orders Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
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
                        <a href="/admin/orders" class="text-primary text-decoration-none small fw-bold">
                            View All <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pending Orders Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
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
                        <a href="/admin/orders?status=pending" class="text-warning text-decoration-none small fw-bold">
                            View Pending <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Total Products Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
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
                        <a href="/admin/products" class="text-success text-decoration-none small fw-bold">
                            View All <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Total Revenue Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
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
                        <a href="/admin/orders?payment_status=paid" class="text-info text-decoration-none small fw-bold">
                            View Revenue <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Recent Orders -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold" style="color: #1e293b;">Recent Orders</h5>
                </div>
                <div class="card-body p-0">
                    @if($recentOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="color: #64748b;" class="ps-4">Order #</th>
                                    <th style="color: #64748b;">Customer</th>
                                    <th style="color: #64748b;">Amount</th>
                                    <th style="color: #64748b;">Status</th>
                                    <th style="color: #64748b;">Date</th>
                                    <th style="color: #64748b;" class="pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td class="ps-4">
                                        <strong style="color: #1e293b;">{{ $order->order_number }}</strong>
                                    </td>
                                    <td style="color: #1e293b;">{{ $order->customer_name }}</td>
                                    <td style="color: #1e293b;" class="fw-bold">${{ number_format($order->total, 2) }}</td>
                                    <td>
                                        @if($order->order_status == 'pending')
                                            <span class="badge" style="background-color: #fbbf24; color: #1e293b;">Pending</span>
                                        @elseif($order->order_status == 'processing')
                                            <span class="badge" style="background-color: #0ea5e9; color: white;">Processing</span>
                                        @elseif($order->order_status == 'shipped')
                                            <span class="badge" style="background-color: #8b5cf6; color: white;">Shipped</span>
                                        @elseif($order->order_status == 'delivered')
                                            <span class="badge" style="background-color: #10b981; color: white;">Delivered</span>
                                        @elseif($order->order_status == 'cancelled')
                                            <span class="badge" style="background-color: #ef4444; color: white;">Cancelled</span>
                                        @endif
                                        @if($order->payment_status != 'paid')
                                        <br><small class="text-danger">{{ ucfirst($order->payment_status) }} payment</small>
                                        @endif
                                    </td>
                                    <td style="color: #64748b;">{{ $order->created_at->format('M d, Y') }}</td>
                                    <td class="pe-4">
                                        <a href="/admin/orders/{{ $order->id }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No orders yet</p>
                    </div>
                    @endif
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    <a href="/admin/orders" class="btn btn-primary btn-sm">
                        View All Orders
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold" style="color: #1e293b;">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="/admin/products/create" class="btn btn-primary py-2">
                            <i class="fas fa-plus me-2"></i>Add New Product
                        </a>
                        <a href="/admin/categories/create" class="btn btn-success py-2">
                            <i class="fas fa-plus me-2"></i>Add New Category
                        </a>
                        <a href="/admin/orders" class="btn" style="background-color: #f59e0b; color: #1e293b; border: none;" class="py-2">
                            <i class="fas fa-shopping-cart me-2"></i>Manage Orders
                        </a>
                        <a href="/" class="btn btn-outline-primary py-2">
                            <i class="fas fa-eye me-2"></i>View Store
                        </a>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div>
                        <h6 class="fw-bold mb-3" style="color: #1e293b;">Store Statistics</h6>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                <span style="color: #64748b;">Categories:</span>
                                <strong style="color: #1e293b;">{{ $totalCategories }}</strong>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                <span style="color: #64748b;">Active Products:</span>
                                <strong style="color: #1e293b;">{{ \App\Models\Product::where('is_active', true)->count() }}</strong>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                <span style="color: #64748b;">Featured Products:</span>
                                <strong style="color: #1e293b;">{{ \App\Models\Product::where('is_featured', true)->count() }}</strong>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                <span style="color: #64748b;">Out of Stock:</span>
                                <strong class="fw-bold" style="color: #ef4444;">{{ \App\Models\Product::where('in_stock', false)->count() }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders by Status -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0 fw-bold" style="color: #1e293b;">Orders Overview</h5>
        </div>
        <div class="card-body">
            @php
                $ordersByStatus = \App\Models\Order::select('order_status', \DB::raw('count(*) as count'))
                    ->groupBy('order_status')
                    ->get();
            @endphp
            
            <div class="row g-3">
                @foreach($ordersByStatus as $status)
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="text-center p-3 rounded" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                        <div class="mb-2">
                            @if($status->order_status == 'pending')
                                <i class="fas fa-clock fa-2x" style="color: #f59e0b;"></i>
                            @elseif($status->order_status == 'processing')
                                <i class="fas fa-cog fa-2x" style="color: #0ea5e9;"></i>
                            @elseif($status->order_status == 'shipped')
                                <i class="fas fa-shipping-fast fa-2x" style="color: #8b5cf6;"></i>
                            @elseif($status->order_status == 'delivered')
                                <i class="fas fa-check-circle fa-2x" style="color: #10b981;"></i>
                            @elseif($status->order_status == 'cancelled')
                                <i class="fas fa-times-circle fa-2x" style="color: #ef4444;"></i>
                            @else
                                <i class="fas fa-shopping-cart fa-2x text-muted"></i>
                            @endif
                        </div>
                        <h3 class="mb-1 fw-bold" style="color: #1e293b;">{{ $status->count }}</h3>
                        <small class="text-muted text-uppercase">{{ ucfirst($status->order_status) }}</small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 8px;
}

.card-header {
    border-bottom: 1px solid #e2e8f0;
}

.btn-primary {
    background-color: #8b5cf6;
    border-color: #8b5cf6;
}

.btn-primary:hover {
    background-color: #7c3aed;
    border-color: #7c3aed;
}

.btn-success {
    background-color: #10b981;
    border-color: #10b981;
}

.btn-outline-primary {
    color: #8b5cf6;
    border-color: #8b5cf6;
}

.btn-outline-primary:hover {
    background-color: #8b5cf6;
    border-color: #8b5cf6;
    color: white;
}

.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
}

.table td {
    vertical-align: middle;
}

.badge {
    font-size: 0.75rem;
    padding: 4px 8px;
    border-radius: 4px;
}

.list-group-item {
    background-color: transparent;
}
</style>
@endsection