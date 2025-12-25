<?php $__env->startSection('title', 'Checkout - BlissBox'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="fw-bold mb-4">Checkout</h1>
            
            <?php if(empty($cartItems)): ?>
                <div class="alert alert-warning">
                    <i class="fas fa-shopping-cart me-2"></i>Your cart is empty. Please add some products first.
                </div>
                <a href="<?php echo e(route('products')); ?>" class="btn btn-primary">
                    <i class="fas fa-gift me-2"></i>Browse Products
                </a>
            <?php else: ?>
            <!-- Progress Steps -->
            <div class="card mb-4 border-light shadow-sm">
                <div class="card-body p-4">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="step active">
                                <div class="step-icon bg-primary text-white rounded-circle mx-auto mb-2" style="width: 40px; height: 40px; line-height: 40px;">
                                    1
                                </div>
                                <span class="small fw-bold text-primary">Cart</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="step active">
                                <div class="step-icon bg-primary text-white rounded-circle mx-auto mb-2" style="width: 40px; height: 40px; line-height: 40px;">
                                    2
                                </div>
                                <span class="small fw-bold text-primary">Checkout</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="step">
                                <div class="step-icon bg-light text-secondary rounded-circle mx-auto mb-2" style="width: 40px; height: 40px; line-height: 40px;">
                                    3
                                </div>
                                <span class="small text-secondary">Confirmation</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <!-- Left Column - Checkout Form -->
                <div class="col-lg-8">
                    <div class="card border-light shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0 text-dark"><i class="fas fa-user me-2 text-primary"></i>Customer Information</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo e(route('order.store')); ?>" method="POST" id="checkoutForm">
                                <?php echo csrf_field(); ?>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="customer_name" class="form-label">Full Name *</label>
                                        <input type="text" class="form-control" id="customer_name" name="customer_name" 
                                               value="<?php echo e(old('customer_name', auth()->user()->name ?? '')); ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="customer_email" class="form-label">Email Address *</label>
                                        <input type="email" class="form-control" id="customer_email" name="customer_email" 
                                               value="<?php echo e(old('customer_email', auth()->user()->email ?? '')); ?>" required>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="customer_phone" class="form-label">Phone Number *</label>
                                    <input type="tel" class="form-control" id="customer_phone" name="customer_phone" 
                                           value="<?php echo e(old('customer_phone')); ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="shipping_address" class="form-label">Shipping Address *</label>
                                    <textarea class="form-control" id="shipping_address" name="shipping_address" 
                                              rows="3" required><?php echo e(old('shipping_address')); ?></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Payment Method *</label>
                                    <select class="form-select" id="payment_method" name="payment_method" required>
                                        <option value="cash_on_delivery" selected>Cash on Delivery</option>
                                        <option value="credit_card">Credit Card</option>
                                        <option value="paypal">PayPal</option>
                                    </select>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="notes" class="form-label">Order Notes (Optional)</label>
                                    <textarea class="form-control" id="notes" name="notes" 
                                              rows="2" placeholder="Special instructions for delivery..."><?php echo e(old('notes')); ?></textarea>
                                </div>
                                
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label text-dark" for="terms">
                                        I agree to the <a href="#" class="text-primary">Terms & Conditions</a> and <a href="#" class="text-primary">Privacy Policy</a>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column - Order Summary -->
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 20px;">
                        <div class="card border-light shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Order Summary</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <!-- Cart Items -->
                                    <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                        <div>
                                            <small class="text-dark"><?php echo e($item['name']); ?></small>
                                            <br>
                                            <small class="text-muted">Qty: <?php echo e($item['quantity']); ?></small>
                                        </div>
                                        <small class="text-dark">$<?php echo e(number_format($item['total'], 2)); ?></small>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-dark">Subtotal</span>
                                        <span class="text-dark">$<?php echo e(number_format($subtotal, 2)); ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-dark">Shipping</span>
                                        <span class="text-dark">$<?php echo e(number_format($shipping, 2)); ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="text-dark">Tax (8%)</span>
                                        <span class="text-dark">$<?php echo e(number_format($tax, 2)); ?></span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between mb-3">
                                        <h5 class="mb-0 text-dark">Total</h5>
                                        <h5 class="mb-0 text-success">$<?php echo e(number_format($subtotal + $shipping + $tax, 2)); ?></h5>
                                    </div>
                                </div>
                                
                                <!-- Security Info -->
                                <div class="alert alert-light border small mb-3">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-shield-alt me-2 mt-1 text-success"></i>
                                        <div>
                                            <strong class="text-dark">Secure Checkout</strong>
                                            <p class="mb-0 text-muted">Your information is protected by SSL encryption</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Place Order Button -->
                                <button type="submit" form="checkoutForm" class="btn btn-primary btn-lg w-100 py-3 mb-3">
                                    <i class="fas fa-lock me-2"></i>Place Order
                                </button>
                                
                                <div class="text-center">
                                    <a href="<?php echo e(route('cart')); ?>" class="text-primary">
                                        <i class="fas fa-arrow-left me-1"></i>Return to Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.step {
    position: relative;
    padding: 0 10px;
}

.step:not(:last-child):after {
    content: '';
    position: absolute;
    top: 20px;
    right: -50%;
    width: 100%;
    height: 2px;
    background-color: #dee2e6;
    z-index: 1;
}

.step.active:not(:last-child):after {
    background-color: #0d6efd;
}

.step-icon {
    position: relative;
    z-index: 2;
    font-weight: 600;
}

.sticky-top {
    z-index: 100;
}

.card {
    border-radius: 8px;
}

.border-light {
    border-color: #e9ecef !important;
}

.btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn-primary:hover {
    background-color: #0b5ed7;
    border-color: #0a58ca;
}
</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\blissbox_backup1\blissbox_backup\resources\views/pages/checkout.blade.php ENDPATH**/ ?>