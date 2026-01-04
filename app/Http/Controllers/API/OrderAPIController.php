<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderAPIController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items', 'items.product');
        
        // Filter by user (non-admin users can only see their own orders)
        $user = Auth::user();
        if (!isset($user->is_admin) || !$user->is_admin) {
            $query->where('user_id', Auth::id());
        } elseif ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        // Filter by status
        if ($request->has('status')) {
            $query->where('order_status', $request->status);
        }
        
        // Filter by payment status
        if ($request->has('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        
        $perPage = $request->get('per_page', 15);
        $orders = $query->latest()->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $orders,
        ], 200);
    }

    public function show($id)
    {
        $order = Order::with('items', 'items.product', 'user')->findOrFail($id);
        
        // Check authorization
        $user = Auth::user();
        if ((!isset($user->is_admin) || !$user->is_admin) && $order->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }
        
        return response()->json([
            'success' => true,
            'data' => $order,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'billing_address' => 'nullable|string',
            'payment_method' => 'required|string|in:cash_on_delivery,credit_card,paypal',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Calculate totals
        $subtotal = 0;
        $items = [];
        
        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            
            if (!$product->in_stock || $product->stock_quantity < $item['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => "Product {$product->name} is out of stock or insufficient quantity",
                ], 400);
            }
            
            $itemPrice = $product->discount_price && $product->discount_price < $product->price 
                ? $product->discount_price 
                : $product->price;
            
            $items[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $itemPrice,
                'quantity' => $item['quantity'],
                'total' => $itemPrice * $item['quantity'],
            ];
            
            $subtotal += $items[count($items) - 1]['total'];
        }
        
        $shipping = $subtotal > 100 ? 0 : 10;
        $tax = $subtotal * 0.08;
        $total = $subtotal + $shipping + $tax;
        
        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'shipping_address' => $request->shipping_address,
            'billing_address' => $request->billing_address ?? $request->shipping_address,
            'subtotal' => $subtotal,
            'shipping_cost' => $shipping,
            'tax' => $tax,
            'total' => $total,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'notes' => $request->notes,
        ]);
        
        // Create order items
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['product_name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total' => $item['total'],
            ]);
            
            // Update stock
            $product = Product::find($item['product_id']);
            $product->decrement('stock_quantity', $item['quantity']);
            if ($product->stock_quantity <= 0) {
                $product->update(['in_stock' => false]);
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'data' => $order->load('items', 'items.product'),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        // Only admin can update orders
        $user = Auth::user();
        if (!isset($user->is_admin) || !$user->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only admins can update orders.',
            ], 403);
        }
        
        $validator = Validator::make($request->all(), [
            'order_status' => 'sometimes|string|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'sometimes|string|in:pending,paid,failed',
            'shipping_address' => 'sometimes|string',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $order->update($request->only(['order_status', 'payment_status', 'shipping_address', 'notes']));

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully',
            'data' => $order->load('items', 'items.product'),
        ], 200);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        
        // Only admin can delete orders
        $user = Auth::user();
        if (!isset($user->is_admin) || !$user->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only admins can delete orders.',
            ], 403);
        }
        
        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully',
        ], 200);
    }
}

