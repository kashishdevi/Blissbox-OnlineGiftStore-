<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category', 'name');
    }

    // Get active categories
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Get category with product count
    public function getProductCountAttribute()
    {
        return $this->products()->where('is_active', true)->count();
    }

    // Get image URL
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // Check if it's already a full URL
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
            // If it's stored locally
            return asset('storage/' . $this->image);
        }
        
        // Return a default image if none exists
        return 'https://images.unsplash.com/photo-1611224923853-80b023f02d71?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80';
    }
}