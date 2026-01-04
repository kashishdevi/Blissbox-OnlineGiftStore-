<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class AdminSidebarComposer
{
    public function compose(View $view)
    {
        $view->with([
            'totalProducts' => Product::count(),
            'totalCategories' => Category::count(),
            'totalOrders' => Order::count(),
            'pendingOrders' => Order::where('order_status', 'pending')->count(),
            'totalRevenue' => Order::where('payment_status', 'paid')->sum('total') ?? 0,
        ]);
    }
}

