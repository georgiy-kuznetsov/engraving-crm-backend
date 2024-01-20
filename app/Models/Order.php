<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'number',
        'price_amount',
        'discount_amount',
        'shipping_amount',
        'gratuity_amount',
        'total_amount',
    ];

    protected $hidden = [
        'status_id',
        'coupon_id',
        'shipping_method_id',
        'payment_method_id',
        'user_id',
        'customer_id',
    ];

    protected $guarded = [
        'total_amount',
        'status_id',
        'coupon_id',
        'shipping_method_id',
        'payment_method_id',
        'user_id',
        'customer_id',
    ];

    public function getNumber() {
        $prefix = now()->parse()->year . '-';
        $number = str_pad( $this->id, 5, 0, STR_PAD_LEFT);
        return  $prefix . $number;
    }
}