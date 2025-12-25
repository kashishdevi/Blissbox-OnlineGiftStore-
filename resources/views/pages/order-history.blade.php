@extends('layouts.app')

@section('title', 'My Orders - BlissBox')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">My Orders</h1>
        <a href="/products" class="btn btn-primary">
            <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
        </a>
    </div>

    @if($orders->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Payment Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>
                        <strong>{{ $order->order_number }}</strong>
                    </td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                    <td>{{ $order->items->sum('quantity') }} item(s)</td>
                    <td><strong>${{ number_format($order->total, 2) }}</strong></td>
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
                    <td>
                        <a href="{{ route('order.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye me-1"></i>View Details
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links() }}
    </div>
    @else
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="fas fa-shopping-bag fa-4x text-muted"></i>
        </div>
        <h4>No orders yet</h4>
        <p class="text-muted">You haven't placed any orders yet. Start shopping now!</p>
        <a href="/products" class="btn btn-primary btn-lg">
            <i class="fas fa-shopping-bag me-2"></i>Browse Products
        </a>
    </div>
    @endif
</div>
@endsection

