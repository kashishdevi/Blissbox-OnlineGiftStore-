@extends('layouts.app')

@section('title', 'Order Details - BlissBox')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            @auth
            <li class="breadcrumb-item"><a href="{{ route('orders.history') }}">My Orders</a></li>
            @endauth
            <li class="breadcrumb-item active">Order #{{ $order->order_number }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Order Details</h1>
            <p class="text-muted mb-0">Order #{{ $order->order_number }}</p>
        </div>
        <div>
            @auth
            <a href="{{ route('orders.history') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to Orders
            </a>
            @else
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to Home
            </a>
            @endauth
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <!-- Order Summary -->
        <div class="col-lg-8 mb-4">
            <!-- Order Information Card -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Order Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <th class="text-muted" style="width: 40%;">Order Number:</th>
                                    <td><strong>{{ $order->order_number }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Order Date:</th>
                                    <td>{{ $order->created_at->format('F d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Order Status:</th>
                                    <td>
                                        @if($order->order_status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($order->order_status == 'processing')
                                            <span class="badge bg-info">Processing</span>
                                        @elseif($order->order_status == 'shipped')
                                            <span class="badge bg-primary">Shipped</span>
                                        @elseif($order->order_status == 'delivered')
                                            <span class="badge bg-success">Delivered</span>
                                        @elseif($order->order_status == 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($order->order_status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 mb-3">
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <th class="text-muted" style="width: 40%;">Payment Status:</th>
                                    <td>
                                        @if($order->payment_status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($order->payment_status == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($order->payment_status == 'failed')
                                            <span class="badge bg-danger">Failed</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($order->payment_status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Payment Method:</th>
                                    <td>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information Card -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Customer Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <th class="text-muted" style="width: 40%;">Name:</th>
                                    <td>{{ $order->customer_name }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Email:</th>
                                    <td>{{ $order->customer_email }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Phone:</th>
                                    <td>{{ $order->customer_phone ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 mb-3">
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <th class="text-muted" style="width: 40%;">Shipping Address:</th>
                                    <td>{{ $order->shipping_address }}</td>
                                </tr>
                                @if($order->billing_address && $order->billing_address != $order->shipping_address)
                                <tr>
                                    <th class="text-muted">Billing Address:</th>
                                    <td>{{ $order->billing_address }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-shopping-bag me-2"></i>Order Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product && $item->product->image)
                                            <img src="{{ $item->product->image_url }}" 
                                                 alt="{{ $item->product_name }}"
                                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; margin-right: 15px;">
                                            @else
                                            <div style="width: 60px; height: 60px; background: #f3f4f6; border-radius: 8px; margin-right: 15px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                            @endif
                                            <div>
                                                <strong>{{ $item->product_name }}</strong>
                                                @if($item->product)
                                                <br><a href="{{ route('product.show', $item->product->id) }}" class="text-muted small">View Product</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-end"><strong>${{ number_format($item->total, 2) }}</strong></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if($order->notes)
            <div class="card mt-4 border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Order Notes</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $order->notes }}</p>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Order Totals Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Order Summary</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm mb-0">
                        <tr>
                            <th>Subtotal:</th>
                            <td class="text-end">${{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Shipping:</th>
                            <td class="text-end">${{ number_format($order->shipping_cost, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Tax:</th>
                            <td class="text-end">${{ number_format($order->tax, 2) }}</td>
                        </tr>
                        <tr class="table-active">
                            <th><strong>Total:</strong></th>
                            <td class="text-end"><strong class="text-success">${{ number_format($order->total, 2) }}</strong></td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-primary" onclick="window.print()">
                            <i class="fas fa-print me-2"></i> Print Invoice
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-bag me-2"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .breadcrumb, .btn, .card-footer {
        display: none !important;
    }
    
    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
    }
}
</style>
@endsection

