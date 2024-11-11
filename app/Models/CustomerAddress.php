<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $fillable = ['customer_id', 'address_line', 'city', 'state', 'zip_code', 'country'];

    // Relationship to Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
