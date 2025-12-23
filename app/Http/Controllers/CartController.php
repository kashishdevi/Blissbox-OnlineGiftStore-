<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return view('pages.cart', ['cartItems' => [], 'subtotal' => 0, 'shipping' => 0, 'tax' => 0, 'total' => 0]);
        }
        
        $cartItems = [];
        $subtotal = 0;
        
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $price = $item['price'] ?? $product->price;
                $quantity = $item['quantity'] ?? 1;
                $itemTotal = $price * $quantity;
                
                $cartItems[] = [
                    'id' => $productId,
                    'product' => $product,
                    'name' => $item['name'] ?? $product->name,
                    'price' => $price,
                    'quantity' => $quantity,
                    'total' => $itemTotal,
                    'image' => $product->image_url,
                    'category' => $product->category
                ];
                
                $subtotal += $itemTotal;
            }
        }
        
        $shipping = $subtotal > 100 ? 0 : 10;
        $tax = $subtotal * 0.08;
        $total = $subtotal + $shipping + $tax;
        
        return view('pages.cart', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    public function add(Request $request, $id)
    {
        // Simple debug
        // \Log::info('Add to cart called', ['id' => $id, 'request' => $request->all()]);
        
        $product = Product::find($id);
        
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found!');
        }
        
        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity', 1);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->discount_price && $product->discount_price < $product->price 
                    ? $product->discount_price 
                    : $product->price,
                'image' => $product->image,
                'category' => $product->category
            ];
        }
        
        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', $product->name . ' added to cart!');
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if ($request->has('quantity')) {
            foreach ($request->quantity as $productId => $quantity) {
                if (isset($cart[$productId])) {
                    if ($quantity <= 0) {
                        unset($cart[$productId]);
                    } else {
                        $cart[$productId]['quantity'] = $quantity;
                    }
                }
            }
        }
        
        session()->put('cart', $cart);
        
        return redirect()->route('cart')->with('success', 'Cart updated!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->route('cart')->with('success', 'Item removed!');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart')->with('success', 'Cart cleared!');
    }
}