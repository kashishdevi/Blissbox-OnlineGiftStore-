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
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total') ?? 0;
        
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
            'order_status' => 'sometimes|required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'sometimes|required|in:pending,paid,failed',
            'notes' => 'nullable|string'
        ]);
        
        $order = Order::findOrFail($id);
        
        // Only update fields that are provided
        $updateData = [];
        if ($request->has('order_status')) {
            $updateData['order_status'] = $request->order_status;
        }
        if ($request->has('payment_status')) {
            $updateData['payment_status'] = $request->payment_status;
        }
        if ($request->has('notes')) {
            $updateData['notes'] = $request->notes;
        }
        
        if (!empty($updateData)) {
            $order->update($updateData);
            return redirect()->back()->with('success', 'Order status updated successfully!');
        }
        
        return redirect()->back()->with('error', 'No changes to update!');
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
