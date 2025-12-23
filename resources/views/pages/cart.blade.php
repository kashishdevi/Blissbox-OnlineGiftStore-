@extends('layouts.app')

@section('title', 'Shopping Cart - BlissBox')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="display-5 fw-bold mb-4">Your Shopping Cart</h1>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @php
                $cart = session()->get('cart', []);
            @endphp
            
            @if(empty($cart))
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                    <h3>Your cart is empty</h3>
                    <p class="text-muted">Add some gifts to get started!</p>
                    <a href="{{ route('products') }}" class="btn btn-primary btn-lg mt-3">
                        <i class="fas fa-gift me-2"></i>Browse Gifts
                    </a>
                </div>
            @else
                <form action="{{ route('cart.update') }}" method="POST">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $subtotal = 0;
                                @endphp
                                @foreach($cart as $productId => $item)
                                    @php
                                        $product = \App\Models\Product::find($productId);
                                    @endphp
                                    @if($product)
                                        @php
                                            $itemPrice = $product->discount_price && $product->discount_price < $product->price 
                                                ? $product->discount_price 
                                                : $product->price;
                                            $itemTotal = $itemPrice * $item['quantity'];
                                            $subtotal += $itemTotal;
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($product->image)
                                                        <img src="{{ $product->image_url }}" 
                                                             class="rounded me-3" 
                                                             width="80" 
                                                             height="80" 
                                                             style="object-fit: cover;">
                                                    @else
                                                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center me-3" 
                                                             style="width: 80px; height: 80px;">
                                                            <i class="fas fa-gift text-white fa-2x"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h5 class="mb-1">{{ $product->name }}</h5>
                                                        <span class="badge bg-primary">{{ $product->category }}</span>
                                                        @if(!$product->in_stock)
                                                        <br>
                                                        <small class="text-danger">
                                                            <i class="fas fa-exclamation-circle"></i> Out of stock
                                                        </small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>${{ number_format($itemPrice, 2) }}</td>
                                            <td>
                                                <input type="number" 
                                                       name="quantity[{{ $productId }}]" 
                                                       value="{{ $item['quantity'] }}" 
                                                       min="1" 
                                                       max="{{ $product->stock_quantity }}"
                                                       class="form-control quantity-input" 
                                                       style="width: 80px;">
                                            </td>
                                            <td>${{ number_format($itemTotal, 2) }}</td>
                                            <td>
                                                <a href="{{ route('cart.remove', $productId) }}" class="btn btn-danger btn-sm" 
                                                   onclick="return confirm('Are you sure you want to remove this item?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Subtotal:</td>
                                    <td class="fw-bold">${{ number_format($subtotal, 2) }}</td>
                                    <td></td>
                                </tr>
                                @php
                                    $shipping = $subtotal > 100 ? 0 : 10;
                                    $tax = $subtotal * 0.08;
                                    $total = $subtotal + $shipping + $tax;
                                @endphp
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Shipping:</td>
                                    <td class="fw-bold">${{ number_format($shipping, 2) }}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Tax (8%):</td>
                                    <td class="fw-bold">${{ number_format($tax, 2) }}</td>
                                    <td></td>
                                </tr>
                                <tr class="table-active">
                                    <td colspan="3" class="text-end fw-bold">Total:</td>
                                    <td class="fw-bold">${{ number_format($total, 2) }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <a href="{{ route('products') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                            </a>
                            <a href="{{ route('cart.clear') }}" class="btn btn-outline-danger ms-2"
                               onclick="return confirm('Are you sure you want to clear your cart?')">
                                <i class="fas fa-trash me-2"></i>Clear Cart
                            </a>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-sync-alt me-2"></i>Update Cart
                            </button>
                            <a href="{{ route('checkout') }}" class="btn btn-success btn-lg">
                                <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                            </a>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>

<style>
.quantity-input {
    width: 80px;
    text-align: center;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.table td {
    vertical-align: middle;
}

.badge {
    font-size: 0.75em;
}
</style>

<script>
// Input validation for quantity
document.querySelectorAll('.quantity-input').forEach(input => {
    input.addEventListener('change', function() {
        const max = parseInt(this.max);
        const value = parseInt(this.value);
        
        if (value < 1) {
            this.value = 1;
        } else if (value > max) {
            this.value = max;
            alert('Maximum available stock is ' + max);
        }
    });
});
</script>
@endsection