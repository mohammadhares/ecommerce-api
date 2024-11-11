<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id', 'cart_id', 'address_id', 'total_amount',
        'delivery_date', 'delivery_time', 'delivery_fee', 'status', 'payment_status'
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function address()
    {
        return $this->belongsTo(CustomerAddress::class, 'address_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
