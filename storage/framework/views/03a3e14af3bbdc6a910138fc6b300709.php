

<?php $__env->startSection('title', 'Revenue Report - BlissBox Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-layout">
    <?php echo $__env->make('admin.layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <div class="admin-content">
        <div class="content-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold mb-1">Revenue Report</h1>
                    <p class="text-muted mb-0">Total revenue from paid orders</p>
                </div>
            </div>
        </div>

        <div class="content-body">
            <!-- Revenue Summary Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="text-uppercase text-muted small fw-bold mb-2">Total Revenue</h6>
                            <h2 class="mb-0 fw-bold text-success">$<?php echo e(number_format($totalRevenue, 2)); ?></h2>
                            <small class="text-muted">All time</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="text-uppercase text-muted small fw-bold mb-2">This Month</h6>
                            <h2 class="mb-0 fw-bold text-info">$<?php echo e(number_format($monthlyRevenue, 2)); ?></h2>
                            <small class="text-muted"><?php echo e(now()->format('F Y')); ?></small>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="text-uppercase text-muted small fw-bold mb-2">Paid Orders</h6>
                            <h2 class="mb-0 fw-bold text-primary"><?php echo e($totalOrders); ?></h2>
                            <small class="text-muted">Total paid orders</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Orders Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">Paid Orders</h5>
                </div>
                <div class="card-body p-0">
                    <?php if($revenueOrders->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Order #</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th class="pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $revenueOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="ps-4">
                                        <strong><?php echo e($order->order_number); ?></strong>
                                    </td>
                                    <td><?php echo e($order->customer_name); ?></td>
                                    <td class="fw-bold text-success">$<?php echo e(number_format($order->total, 2)); ?></td>
                                    <td><?php echo e($order->created_at->format('M d, Y')); ?></td>
                                    <td>
                                        <span class="badge bg-success">Paid</span>
                                    </td>
                                    <td class="pe-4">
                                        <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="card-footer bg-white border-0 py-3">
                        <?php echo e($revenueOrders->links()); ?>

                    </div>
                    <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-dollar-sign fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No paid orders yet</p>
                    </div>
                    <?php endif; ?>
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

.card {
    border-radius: 12px;
}

@media (max-width: 768px) {
    .admin-content {
        margin-left: 0;
        padding: 1rem;
    }
}
</style>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\blissbox_backup1\blissbox_backup\resources\views/admin/revenue.blade.php ENDPATH**/ ?>