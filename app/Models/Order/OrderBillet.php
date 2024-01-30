<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderBillet extends Pivot
{
    use HasFactory;

    protected $table = 'order_billet';

    public $incrementing = true;

    protected $fillable = [
        'name',
        'price',
        'photo',
        'quantity',
        'order_id',
        'billet_id',
        'total_amount',
    ];
}
