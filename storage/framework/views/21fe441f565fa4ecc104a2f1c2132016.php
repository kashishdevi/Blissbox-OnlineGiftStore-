

<?php $__env->startSection('title', 'Orders Management - BlissBox Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <?php echo $__env->make('admin.partials.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-bold">Orders Management</h1>
            <p class="text-muted mb-0">Manage customer orders</p>
        </div>
    </div>
    
    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6>Total Orders</h6>
                    <h3><?php echo e($totalOrders); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6>Pending Orders</h6>
                    <h3><?php echo e($pendingOrders); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6>Total Revenue</h6>
                    <h3>$<?php echo e(number_format($totalRevenue ?? 0, 2)); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6>Average Order</h6>
                    <h3>$<?php echo e(($totalOrders > 0 && ($totalRevenue ?? 0) > 0) ? number_format(($totalRevenue ?? 0) / $totalOrders, 2) : '0.00'); ?></h3>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Orders Table -->
    <div class="card">
        <div class="card-body">
            <?php if($orders->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Amount</th>
                            <th>Order Status</th>
                            <th>Payment</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <strong><?php echo e($order->order_number); ?></strong>
                            </td>
                            <td>
                                <div><?php echo e($order->customer_name); ?></div>
                                <small class="text-muted"><?php echo e($order->customer_email); ?></small>
                            </td>
                            <td>
                                <?php echo e($order->items->sum('quantity')); ?> items
                            </td>
                            <td>
                                <strong>$<?php echo e(number_format($order->total, 2)); ?></strong>
                            </td>
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
                            <td>
                                <?php if($order->payment_status == 'pending'): ?>
                                    <span class="badge bg-warning">Pending</span>
                                <?php elseif($order->payment_status == 'paid'): ?>
                                    <span class="badge bg-success">Paid</span>
                                <?php elseif($order->payment_status == 'failed'): ?>
                                    <span class="badge bg-danger">Failed</span>
                                <?php endif; ?>
                                <br>
                                <small><?php echo e(ucfirst(str_replace('_', ' ', $order->payment_method))); ?></small>
                            </td>
                            <td>
                                <?php echo e($order->created_at->format('M d, Y')); ?>

                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" 
                                            data-bs-target="#statusModal<?php echo e($order->id); ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="<?php echo e(route('admin.orders.destroy', $order->id)); ?>" method="POST" 
                                          class="d-inline" onsubmit="return confirm('Are you sure you want to delete this order?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Status Update Modal -->
                        <div class="modal fade" id="statusModal<?php echo e($order->id); ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="<?php echo e(route('admin.orders.updateStatus', $order->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="modal-header">
                                            <h5 class="modal-title">Update Order Status</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
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
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Update Status</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                <?php echo e($orders->links()); ?>

            </div>
            <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h4>No orders found</h4>
                <p class="text-muted">When customers place orders, they'll appear here</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\blissbox_backup1\blissbox_backup\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>