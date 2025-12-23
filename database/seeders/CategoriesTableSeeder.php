<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'For Him',
                'description' => 'Perfect gifts for men - wallets, watches, gadgets and more',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'For Her',
                'description' => 'Beautiful gifts for women - jewelry, perfume, accessories and more',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Birthday',
                'description' => 'Birthday specials - cakes, gifts, surprises for all ages',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Anniversary',
                'description' => 'Romantic gifts for anniversaries - dinner packages, flowers, personalized items',
                'image' => null,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }
    }
}