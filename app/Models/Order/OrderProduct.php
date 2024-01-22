<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
    use HasFactory;

    public $incrementing = true;

    protected $fillable = [
        'name',
        'photo',
        'price',
        'sale_price',
        'quantity',
        'amount',
        'order_id',
        'product_id',
    ];
}
