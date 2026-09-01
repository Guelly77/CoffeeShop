<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'subtotal',
        'tax',
        'discount',
        'total',
        'payment_method',
        'amount_received',
        'change',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(OrderItems::class);
    }
}
