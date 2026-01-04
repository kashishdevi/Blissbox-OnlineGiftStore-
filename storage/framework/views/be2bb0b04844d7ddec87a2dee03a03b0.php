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
                                
                                <!-- Credit Card Fields (Hidden by default) -->
                                <div id="credit_card_fields" style="display: none;">
                                    <div class="card border-primary mb-3">
                                        <div class="card-header bg-primary text-white">
                                            <h6 class="mb-0"><i class="fas fa-credit-card me-2"></i>Credit Card Information</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="card_number" class="form-label">Card Number *</label>
                                                <input type="text" class="form-control" id="card_number" name="card_number" 
                                                       placeholder="1234 5678 9012 3456" maxlength="19" 
                                                       value="<?php echo e(old('card_number')); ?>">
                                                <small class="text-muted">Enter 16-digit card number</small>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="card_expiry" class="form-label">Expiry Date *</label>
                                                    <input type="text" class="form-control" id="card_expiry" name="card_expiry" 
                                                           placeholder="MM/YY" maxlength="5" value="<?php echo e(old('card_expiry')); ?>">
                                                    <small class="text-muted">MM/YY format</small>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="card_cvv" class="form-label">CVV *</label>
                                                    <input type="text" class="form-control" id="card_cvv" name="card_cvv" 
                                                           placeholder="123" maxlength="4" value="<?php echo e(old('card_cvv')); ?>">
                                                    <small class="text-muted">3 or 4 digits</small>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="card_name" class="form-label">Cardholder Name *</label>
                                                <input type="text" class="form-control" id="card_name" name="card_name" 
                                                       placeholder="John Doe" value="<?php echo e(old('card_name')); ?>">
                                            </div>
                                            
                                            <div class="alert alert-info small mb-0">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <strong>Test Mode:</strong> For testing, use card number: 4242 4242 4242 4242, any future expiry date, and any 3-digit CVV.
                                            </div>
                                        </div>
                                    </div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethod = document.getElementById('payment_method');
    const creditCardFields = document.getElementById('credit_card_fields');
    const cardNumber = document.getElementById('card_number');
    const cardExpiry = document.getElementById('card_expiry');
    const cardCvv = document.getElementById('card_cvv');
    const checkoutForm = document.getElementById('checkoutForm');
    
    // Show/hide credit card fields based on payment method
    if (paymentMethod && creditCardFields) {
        paymentMethod.addEventListener('change', function() {
            if (this.value === 'credit_card') {
                creditCardFields.style.display = 'block';
                if (cardNumber) cardNumber.setAttribute('required', 'required');
                if (cardExpiry) cardExpiry.setAttribute('required', 'required');
                if (cardCvv) cardCvv.setAttribute('required', 'required');
                const cardName = document.getElementById('card_name');
                if (cardName) cardName.setAttribute('required', 'required');
            } else {
                creditCardFields.style.display = 'none';
                if (cardNumber) cardNumber.removeAttribute('required');
                if (cardExpiry) cardExpiry.removeAttribute('required');
                if (cardCvv) cardCvv.removeAttribute('required');
                const cardName = document.getElementById('card_name');
                if (cardName) cardName.removeAttribute('required');
            }
        });
    }
    
    // Format card number (add spaces every 4 digits)
    if (cardNumber) {
        cardNumber.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s/g, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            e.target.value = formattedValue;
        });
    }
    
    // Format expiry date (MM/YY)
    if (cardExpiry) {
        cardExpiry.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });
    }
    
    // Only allow numbers for CVV
    if (cardCvv) {
        cardCvv.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });
    }
    
    // Form validation before submit
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            if (paymentMethod && paymentMethod.value === 'credit_card') {
                if (cardNumber) {
                    const cardNum = cardNumber.value.replace(/\s/g, '');
                    if (cardNum.length < 13 || cardNum.length > 19) {
                        e.preventDefault();
                        alert('Please enter a valid card number (13-19 digits)');
                        cardNumber.focus();
                        return false;
                    }
                }
                
                if (cardExpiry) {
                    const expiry = cardExpiry.value;
                    if (!/^\d{2}\/\d{2}$/.test(expiry)) {
                        e.preventDefault();
                        alert('Please enter a valid expiry date (MM/YY)');
                        cardExpiry.focus();
                        return false;
                    }
                    
                    const [month, year] = expiry.split('/');
                    const expiryDate = new Date(2000 + parseInt(year), parseInt(month) - 1);
                    if (expiryDate < new Date()) {
                        e.preventDefault();
                        alert('Card has expired. Please use a valid card.');
                        cardExpiry.focus();
                        return false;
                    }
                }
                
                if (cardCvv && (cardCvv.value.length < 3 || cardCvv.value.length > 4)) {
                    e.preventDefault();
                    alert('Please enter a valid CVV (3-4 digits)');
                    cardCvv.focus();
                    return false;
                }
                
                const cardName = document.getElementById('card_name');
                if (cardName && !cardName.value.trim()) {
                    e.preventDefault();
                    alert('Please enter the cardholder name');
                    cardName.focus();
                    return false;
                }
            }
        });
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\blissbox_backup1\blissbox_backup\resources\views/pages/checkout.blade.php ENDPATH**/ ?>