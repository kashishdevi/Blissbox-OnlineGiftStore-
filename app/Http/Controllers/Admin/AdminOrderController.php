<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index(Request $request)
    {
        $query = Order::with('items');
        
        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('order_status', $request->status);
        }
        
        $orders = $query->latest()->paginate(10);
        $pendingOrders = Order::where('order_status', 'pending')->count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total') ?? 0;
        
        // Share sidebar variables
        view()->share([
            'totalProducts' => \App\Models\Product::count(),
            'totalCategories' => \App\Models\Category::count(),
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'totalRevenue' => $totalRevenue,
        ]);
        
        return view('admin.orders.index', compact('orders', 'pendingOrders', 'totalOrders', 'totalRevenue'));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the order status.
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed',
            'notes' => 'nullable|string|max:1000'
        ]);
        
        $order = Order::findOrFail($id);
        
        // Update order with validated data
        $order->update([
            'order_status' => $validated['order_status'],
            'payment_status' => $validated['payment_status'],
            'notes' => $validated['notes'] ?? $order->notes
        ]);
        
        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        
        // Delete order items first
        OrderItem::where('order_id', $id)->delete();
        
        // Delete the order
        $order->delete();
        
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully!');
    }
}
