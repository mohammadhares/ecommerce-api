<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['order_id', 'payment_card_id', 'payment_method', 'amount', 'payment_date'];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function paymentCard()
    {
        return $this->belongsTo(PaymentCard::class);
    }
}
