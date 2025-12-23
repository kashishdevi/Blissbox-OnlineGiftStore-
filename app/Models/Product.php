<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'price', 'discount_price', 
        'image', 'images', 'category', 'features', 'in_stock', 
        'stock_quantity', 'is_featured', 'is_active'
    ];

    protected $casts = [
        'features' => 'array',
        'images' => 'array',
        'in_stock' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
                
                // Make slug unique if it already exists
                $count = Product::where('slug', 'like', $product->slug . '%')->count();
                if ($count > 0) {
                    $product->slug .= '-' . ($count + 1);
                }
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
                
                // Make slug unique if it already exists
                $count = Product::where('slug', 'like', $product->slug . '%')
                    ->where('id', '!=', $product->id)
                    ->count();
                if ($count > 0) {
                    $product->slug .= '-' . ($count + 1);
                }
            }
        });
    }

    // Add this method for search functionality
    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function($q) use ($searchTerm) {
            $q->where('name', 'like', '%' . $searchTerm . '%')
              ->orWhere('category', 'like', '%' . $searchTerm . '%')
              ->orWhere('description', 'like', '%' . $searchTerm . '%');
        });
    }

   public function getImageUrlAttribute()
{
    if ($this->image) {
        // If it's already a full URL (like from Unsplash)
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        // If it's stored locally
        return asset('storage/' . $this->image);
    }
    // Default image
    return 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80';
}

    public function getDisplayPriceAttribute()
    {
        if ($this->discount_price && $this->discount_price < $this->price) {
            return '$' . number_format($this->discount_price, 2);
        }
        return '$' . number_format($this->price, 2);
    }

    public function getOriginalPriceAttribute()
    {
        if ($this->discount_price && $this->discount_price < $this->price) {
            return '$' . number_format($this->price, 2);
        }
        return null;
    }

    public function getDiscountedPercentAttribute()
    {
        if ($this->discount_price && $this->discount_price < $this->price) {
            $discount = (($this->price - $this->discount_price) / $this->price) * 100;
            return round($discount) . '% OFF';
        }
        return null;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('in_stock', true)->where('stock_quantity', '>', 0);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}