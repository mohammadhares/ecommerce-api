<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'description', 'base_price',
        'quantity', 'discount', 'image', 'is_available'
    ];

    // Relationship to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship to Gallery
    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    // Relationship to Modifiers
    public function modifiers()
    {
        return $this->hasMany(Modifier::class);
    }

        // Relationship to Variations
    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function review()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Review::class);
    }
}
