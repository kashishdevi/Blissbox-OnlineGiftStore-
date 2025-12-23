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
    public function index()
    {
        $orders = Order::with('items')->latest()->paginate(10);
        $pendingOrders = Order::where('order_status', 'pending')->count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
        
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
        $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed'
        ]);
        
        $order = Order::findOrFail($id);
        $order->update([
            'order_status' => $request->order_status,
            'payment_status' => $request->payment_status
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