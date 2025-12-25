<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Personalized Leather Wallet',
                'description' => 'Premium genuine leather wallet with multiple card slots and money pocket',
                'price' => 49.99,
                'category' => 'For Him',
                'image' => 'https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
                'features' => json_encode(['Genuine Leather', 'Multiple Card Slots', 'ID Window', 'RFID Protection']),
                'slug' => Str::slug('Personalized Leather Wallet'),
                'stock_quantity' => 100,
                'in_stock' => true,
                'is_featured' => false,
                'is_active' => true
            ],
            [
                'name' => 'Custom Jewelry Set',
                'description' => 'Beautiful silver necklace with matching earrings, customizable with birthstone',
                'price' => 89.99,
                'category' => 'For Her',
                'image' => 'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
                'features' => json_encode(['Sterling Silver', 'Birthstone Option', 'Gift Box Included', 'Custom Engraving']),
                'slug' => Str::slug('Custom Jewelry Set'),
                'stock_quantity' => 50,
                'in_stock' => true,
                'is_featured' => true,
                'is_active' => true
            ],
            [
                'name' => 'Birthday Surprise Box',
                'description' => 'Curated birthday gift box with chocolates, candles, and personalized items',
                'price' => 59.99,
                'category' => 'Birthday',
                'image' => 'https://images.unsplash.com/photo-1559620192-032c64bc86af?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
                'features' => json_encode(['Premium Chocolates', 'Birthday Candles', 'Personalized Card', 'Gift Wrapping']),
              'slug' => Str::slug('Heavy Sweet'),
                'stock_quantity' => 50,
                'in_stock' => true,
                'is_featured' => true,
                'is_active' => true
            ],
            [
                'name' => 'Romantic Dinner Package',
                'description' => 'Complete romantic dinner setup for two with wine and dessert',
                'price' => 129.99,
                'category' => 'Anniversary',
                'image' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
                'features' => json_encode(['Gourmet Dinner', 'Premium Wine', 'Dessert Platter', 'Candle Setup']),
                  'slug' => Str::slug('Romantic Dinner Package'),
                'stock_quantity' => 50,
                'in_stock' => true,
                'is_featured' => true,
                'is_active' => true
            ],
            [
                'name' => 'Smart Watch Series 5',
                'description' => 'Latest smartwatch with fitness tracking and heart rate monitor',
                'price' => 199.99,
                'category' => 'For Him',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
                'features' => json_encode(['Fitness Tracking', 'Heart Rate Monitor', 'Water Resistant', 'Long Battery']),
                  'slug' => Str::slug('Smart Watch Series 5'),
                'stock_quantity' => 50,
                'in_stock' => true,
                'is_featured' => true,
                'is_active' => true
            ],
            [
                'name' => 'Designer Perfume Set',
                'description' => 'Luxury perfume collection with three different fragrances',
                'price' => 79.99,
                'category' => 'For Her',
                'image' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
                'features' => json_encode(['3 Fragrances', 'Elegant Packaging', 'Long Lasting', 'Premium Quality']),
                'slug' => Str::slug('Designer Perfume Set'),
                'stock_quantity' => 50,
                'in_stock' => true,
                'is_featured' => true,
                'is_active' => true
            ],
            [
                'name' => 'Chocolate Cake Deluxe',
                'description' => 'Custom designed chocolate cake with personal message and decorations',
                'price' => 39.99,
                'category' => 'Birthday',
                'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
                'features' => json_encode(['Custom Design', 'Personal Message', 'Fresh Ingredients', 'Free Delivery']),
                  'slug' => Str::slug('Chocolate Cake Deluxe'),
                'stock_quantity' => 50,
                'in_stock' => true,
                'is_featured' => true,
                'is_active' => true
            ],
            [
                'name' => 'Love Memory Book',
                'description' => 'Custom photo album for anniversary with space for memories and photos',
                'price' => 45.99,
                'category' => 'Anniversary',
                'image' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
                'features' => json_encode(['Custom Photos', 'Memory Pages', 'Premium Cover', 'Personalized Text']),
                'slug' => Str::slug('Love Memory Book'),
                'stock_quantity' => 50,
                'in_stock' => true,
                'is_featured' => true,
                'is_active' => true
            ]
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}