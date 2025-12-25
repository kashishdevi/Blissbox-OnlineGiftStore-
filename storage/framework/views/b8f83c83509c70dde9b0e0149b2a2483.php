<?php $__env->startSection('title', 'Thank You - BlissBox'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center p-5">
                    <!-- Success Icon -->
                    <div class="mb-4">
                        <div class="success-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    
                    <!-- Success Message -->
                    <h1 class="display-5 fw-bold text-success mb-3">Thank You!</h1>
                    <p class="lead mb-4">Your order has been placed successfully.</p>
                    
                    <!-- Order Details -->
                    <div class="order-details bg-light p-4 rounded mb-4">
                        <h5 class="mb-3">Order Details</h5>
                        <div class="row text-start">
                            <div class="col-md-6 mb-2">
                                <strong>Order Number:</strong>
                                <div class="text-primary fw-bold"><?php echo e($order->order_number); ?></div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Order Date:</strong>
                                <div><?php echo e($order->created_at->format('F d, Y')); ?></div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Customer Name:</strong>
                                <div><?php echo e($order->customer_name); ?></div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Customer Email:</strong>
                                <div><?php echo e($order->customer_email); ?></div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Order Status:</strong>
                                <div>
                                    <?php if($order->order_status == 'pending'): ?>
                                        <span class="badge bg-warning">Pending</span>
                                    <?php elseif($order->order_status == 'processing'): ?>
                                        <span class="badge bg-info">Processing</span>
                                    <?php else: ?>
                                        <span class="badge bg-success"><?php echo e(ucfirst($order->order_status)); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Payment Method:</strong>
                                <div><?php echo e(ucfirst(str_replace('_', ' ', $order->payment_method))); ?></div>
                            </div>
                            <div class="col-12 mt-2">
                                <strong>Total Amount:</strong>
                                <div class="h4 text-success">$<?php echo e(number_format($order->total, 2)); ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Shipping Info -->
                    <div class="shipping-info bg-light p-4 rounded mb-4">
                        <h5 class="mb-3">Shipping Information</h5>
                        <div class="text-start">
                            <p class="mb-1"><strong>Shipping Address:</strong></p>
                            <p class="mb-0"><?php echo e($order->shipping_address); ?></p>
                        </div>
                    </div>
                    
                    <!-- What's Next -->
                    <div class="whats-next mb-4">
                        <h5 class="mb-3">What happens next?</h5>
                        <div class="row text-start">
                            <div class="col-md-4 mb-3">
                                <div class="step">
                                    <div class="step-number">1</div>
                                    <h6>Order Confirmation</h6>
                                    <p class="small">You'll receive an email confirmation shortly.</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="step">
                                    <div class="step-number">2</div>
                                    <h6>Order Processing</h6>
                                    <p class="small">We'll prepare your order for shipping.</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="step">
                                    <div class="step-number">3</div>
                                    <h6>Order Delivery</h6>
                                    <p class="small">Your order will be shipped within 2-3 business days.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                        <a href="<?php echo e(route('order.show', $order->id)); ?>" class="btn btn-primary px-4">
                            <i class="fas fa-eye me-2"></i> View Order Details
                        </a>
                        <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-primary px-4">
                            <i class="fas fa-home me-2"></i> Continue Shopping
                        </a>
                    </div>
                    
                    <!-- Contact Info -->
                    <div class="mt-5 pt-4 border-top">
                        <p class="text-muted mb-1">Need help? Contact our support team</p>
                        <p class="mb-0">
                            <i class="fas fa-envelope me-2"></i> support@blissbox.com
                            <i class="fas fa-phone ms-3 me-2"></i> +1 (555) 123-4567
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.success-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto;
    background: linear-gradient(135deg, #10b981, #059669);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 48px;
    box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
}

.order-details, .shipping-info {
    border: 1px solid #e2e8f0;
}

.step {
    text-align: center;
    padding: 15px;
}

.step-number {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin: 0 auto 15px;
    font-size: 18px;
}

.step h6 {
    font-weight: 600;
    margin-bottom: 10px;
}

.step p {
    color: #64748b;
    font-size: 14px;
    line-height: 1.4;
}

.card {
    border-radius: 20px;
    overflow: hidden;
}

@media (max-width: 768px) {
    .card-body {
        padding: 2rem !important;
    }
    
    .display-5 {
        font-size: 2.5rem;
    }
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\blissbox_backup1\blissbox_backup\resources\views/pages/thankyou.blade.php ENDPATH**/ ?>