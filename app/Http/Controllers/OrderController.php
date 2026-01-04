<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }
        
        $cartItems = [];
        $subtotal = 0;
        
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $itemPrice = $product->discount_price && $product->discount_price < $product->price 
                    ? $product->discount_price 
                    : $product->price;
                $item['product'] = $product;
                $item['total'] = $itemPrice * $item['quantity'];
                $cartItems[$productId] = $item;
                $subtotal += $item['total'];
            }
        }
        
        $shipping = $subtotal > 100 ? 0 : 10;
        $tax = $subtotal * 0.08;
        $total = $subtotal + $shipping + $tax;
        
        return view('pages.checkout', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    public function store(Request $request)
    {
        $rules = [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|string|in:cash_on_delivery,credit_card,paypal',
            'notes' => 'nullable|string'
        ];
        
        // Add credit card validation if payment method is credit_card
        if ($request->payment_method === 'credit_card') {
            $rules['card_number'] = 'required|string|regex:/^[\d\s]{13,19}$/';
            $rules['card_expiry'] = 'required|string|regex:/^\d{2}\/\d{2}$/';
            $rules['card_cvv'] = 'required|string|regex:/^\d{3,4}$/';
            $rules['card_name'] = 'required|string|max:255';
        }
        
        $request->validate($rules);
        
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }
        
        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $itemPrice = $product->discount_price && $product->discount_price < $product->price 
                    ? $product->discount_price 
                    : $product->price;
                $subtotal += $itemPrice * $item['quantity'];
            }
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
            'payment_status' => ($request->payment_method === 'credit_card') ? 'paid' : 'pending',
            'order_status' => 'pending',
            'notes' => $request->notes
        ]);
        
        // Create order items
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $itemPrice = $product->discount_price && $product->discount_price < $product->price 
                    ? $product->discount_price 
                    : $product->price;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'product_name' => $product->name,
                    'price' => $itemPrice,
                    'quantity' => $item['quantity'],
                    'total' => $itemPrice * $item['quantity']
                ]);
                
                // Update stock
                $product->decrement('stock_quantity', $item['quantity']);
                if ($product->stock_quantity <= 0) {
                    $product->update(['in_stock' => false]);
                }
            }
        }
        
        // Clear cart
        session()->forget('cart');
        
        return redirect()->route('order.thankyou', $order->id);
    }

    public function thankyou($id)
    {
        $order = Order::findOrFail($id);
        return view('pages.thankyou', compact('order'));
    }

    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        
        // Check if user is authorized to view this order
        // Allow if:
        // 1. User is not logged in (guest checkout - allow viewing)
        // 2. User owns the order
        // 3. User is an admin
        if (Auth::check()) {
            $user = Auth::user();
            $isAdmin = method_exists($user, 'is_admin') ? $user->is_admin : false;
            
            if ($order->user_id && Auth::id() != $order->user_id && !$isAdmin) {
                abort(403, 'Unauthorized. You can only view your own orders.');
            }
        }
        
        return view('pages.order-show', compact('order'));
    }

    public function history()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items')
            ->latest()
            ->paginate(10);
        
        return view('pages.order-history', compact('orders'));
    }
}