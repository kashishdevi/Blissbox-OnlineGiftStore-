

<?php $__env->startSection('title', 'Order Details - BlissBox Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <?php echo $__env->make('admin.partials.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-bold">Order Details</h1>
            <p class="text-muted mb-0">Order #<?php echo e($order->order_number); ?></p>
        </div>
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Orders
        </a>
    </div>
    
    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    
    <div class="row">
        <!-- Order Summary -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Order Information</h6>
                            <table class="table table-sm">
                                <tr>
                                    <th>Order Number:</th>
                                    <td><?php echo e($order->order_number); ?></td>
                                </tr>
                                <tr>
                                    <th>Order Date:</th>
                                    <td><?php echo e($order->created_at->format('F d, Y h:i A')); ?></td>
                                </tr>
                                <tr>
                                    <th>Order Status:</th>
                                    <td>
                                        <?php if($order->order_status == 'pending'): ?>
                                            <span class="badge bg-warning">Pending</span>
                                        <?php elseif($order->order_status == 'processing'): ?>
                                            <span class="badge bg-info">Processing</span>
                                        <?php elseif($order->order_status == 'shipped'): ?>
                                            <span class="badge bg-primary">Shipped</span>
                                        <?php elseif($order->order_status == 'delivered'): ?>
                                            <span class="badge bg-success">Delivered</span>
                                        <?php elseif($order->order_status == 'cancelled'): ?>
                                            <span class="badge bg-danger">Cancelled</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Payment Status:</th>
                                    <td>
                                        <?php if($order->payment_status == 'pending'): ?>
                                            <span class="badge bg-warning">Pending</span>
                                        <?php elseif($order->payment_status == 'paid'): ?>
                                            <span class="badge bg-success">Paid</span>
                                        <?php elseif($order->payment_status == 'failed'): ?>
                                            <span class="badge bg-danger">Failed</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Payment Method:</th>
                                    <td><?php echo e(ucfirst(str_replace('_', ' ', $order->payment_method))); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Customer Information</h6>
                            <table class="table table-sm">
                                <tr>
                                    <th>Name:</th>
                                    <td><?php echo e($order->customer_name); ?></td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td><?php echo e($order->customer_email); ?></td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td><?php echo e($order->customer_phone); ?></td>
                                </tr>
                                <tr>
                                    <th>Shipping Address:</th>
                                    <td><?php echo e($order->shipping_address); ?></td>
                                </tr>
                                <?php if($order->billing_address && $order->billing_address != $order->shipping_address): ?>
                                <tr>
                                    <th>Billing Address:</th>
                                    <td><?php echo e($order->billing_address); ?></td>
                                </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                    
                    <?php if($order->notes): ?>
                    <div class="mt-3">
                        <h6>Order Notes:</h6>
                        <div class="alert alert-light">
                            <?php echo e($order->notes); ?>

                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Order Items -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if($item->product && $item->product->image): ?>
                                            <img src="<?php echo e($item->product->image_url); ?>" 
                                                 alt="<?php echo e($item->product_name); ?>"
                                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px; margin-right: 10px;">
                                            <?php endif; ?>
                                            <div>
                                                <strong><?php echo e($item->product_name); ?></strong>
                                                <?php if($item->product): ?>
                                                <br><small>Product ID: <?php echo e($item->product->id); ?></small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>$<?php echo e(number_format($item->price, 2)); ?></td>
                                    <td><?php echo e($item->quantity); ?></td>
                                    <td><strong>$<?php echo e(number_format($item->total, 2)); ?></strong></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Order Totals & Actions -->
        <div class="col-md-4">
            <!-- Order Totals -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Order Totals</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th>Subtotal:</th>
                            <td class="text-end">$<?php echo e(number_format($order->subtotal, 2)); ?></td>
                        </tr>
                        <tr>
                            <th>Shipping:</th>
                            <td class="text-end">$<?php echo e(number_format($order->shipping_cost, 2)); ?></td>
                        </tr>
                        <tr>
                            <th>Tax:</th>
                            <td class="text-end">$<?php echo e(number_format($order->tax, 2)); ?></td>
                        </tr>
                        <tr class="table-active">
                            <th><strong>Total:</strong></th>
                            <td class="text-end"><strong>$<?php echo e(number_format($order->total, 2)); ?></strong></td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <!-- Update Status -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Update Status</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.orders.updateStatus', $order->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label">Order Status</label>
                            <select name="order_status" class="form-select">
                                <option value="pending" <?php echo e($order->order_status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                                <option value="processing" <?php echo e($order->order_status == 'processing' ? 'selected' : ''); ?>>Processing</option>
                                <option value="shipped" <?php echo e($order->order_status == 'shipped' ? 'selected' : ''); ?>>Shipped</option>
                                <option value="delivered" <?php echo e($order->order_status == 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                                <option value="cancelled" <?php echo e($order->order_status == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Payment Status</label>
                            <select name="payment_status" class="form-select">
                                <option value="pending" <?php echo e($order->payment_status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                                <option value="paid" <?php echo e($order->payment_status == 'paid' ? 'selected' : ''); ?>>Paid</option>
                                <option value="failed" <?php echo e($order->payment_status == 'failed' ? 'selected' : ''); ?>>Failed</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-2"></i> Update Status
                        </button>
                    </form>
                    
                    <hr>
                    
                    <!-- Order Actions -->
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success" onclick="window.print()">
                            <i class="fas fa-print me-2"></i> Print Invoice
                        </button>
                        <a href="mailto:<?php echo e($order->customer_email); ?>" class="btn btn-outline-primary">
                            <i class="fas fa-envelope me-2"></i> Email Customer
                        </a>
                        <form action="<?php echo e(route('admin.orders.destroy', $order->id)); ?>" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this order?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i> Delete Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\blissbox_backup1\blissbox_backup\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>