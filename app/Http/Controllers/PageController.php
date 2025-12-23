<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

use App\Models\Category;

class PageController extends Controller
{
    public function home()
    {
        $featuredProducts = Product::getFeaturedProducts();
        $categories = Category::getAllCategories();

        return view('pages.home', compact('featuredProducts', 'categories'));
    }

    public function products(Request $request)
    {
        $allProducts = Product::getAllProducts();
        $categories = Category::getCategoryNames();

        // Search functionality
        $search = $request->get('search');
        $category = $request->get('category', 'All Categories');

        $filteredProducts = collect($allProducts);

        if ($search) {
            $filteredProducts = $filteredProducts->filter(function ($product) use ($search) {
                return stripos($product['name'], $search) !== false || 
                       stripos($product['description'], $search) !== false ||
                       stripos($product['category'], $search) !== false;
            });
        }

        if ($category !== 'All Categories') {
            $filteredProducts = $filteredProducts->where('category', $category);
        }

        return view('pages.products', compact('filteredProducts', 'categories', 'search', 'category'));
    }

    public function category($category)
    {
        $allProducts = Product::getAllProducts();
        $categoryProducts = collect($allProducts)->where('category', urldecode($category));
        $categories = Category::getCategoryNames();

        return view('pages.products', [
            'filteredProducts' => $categoryProducts,
            'categories' => $categories,
            'category' => urldecode($category),
            'search' => null
        ]);
    }

    public function show($id)
    {
        $product = Product::getProductById($id);
        
        if (!$product) {
            abort(404);
        }

        $relatedProducts = Product::getProductsByCategory($product['category']);
        // Remove current product from related products
        $relatedProducts = array_filter($relatedProducts, function($related) use ($id) {
            return $related['id'] != $id;
        });
        $relatedProducts = array_slice($relatedProducts, 0, 4);

        return view('pages.product-show', compact('product', 'relatedProducts'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function cart()
    {
        return view('pages.cart');
    }

    public function checkout()
    {
        return view('pages.checkout');
    }

    public function thankyou()
    {
        return view('pages.thankyou');
    }

}