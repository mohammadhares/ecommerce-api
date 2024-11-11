<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentCard extends Model
{
    protected $fillable = ['company', 'card_number', 'card_owner', 'expire_date'];

    // Relationship to Payment
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
