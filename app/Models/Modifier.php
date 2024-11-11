<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modifier extends Model
{
    protected $fillable = ['product_id', 'name', 'description', 'price', 'image', 'type'];

    // Relationship to Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
