<?php

namespace App\Models\Order;

use App\Models\Billet;
use App\Models\Customer;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'status_id',
        'coupon_id',
        'shipping_method_id',
        'payment_method_id',
        'user_id',
        'customer_id',
    ];

    protected $hidden = [
        'status_id',
        'coupon_id',
        'shipping_method_id',
        'payment_method_id',
    ];

    protected $guarded = [
        'total_amount',
        'user_id',
    ];

    public function getNumber() {
        $prefix = now()->parse()->year . '-';
        $number = str_pad( $this->id, 5, 0, STR_PAD_LEFT);
        return  $prefix . $number;
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
                    ->using(OrderProduct::class)
                    ->withPivot('name', 'photo', 'price', 'sale_price', 'quantity', 'amount')
                    ->as('order_items')
                    ->withTimestamps();
    }

    public function billets(): BelongsToMany
    {
        return $this->belongsToMany(Billet::class, 'order_billet', 'order_id', 'billet_id')
                    ->using(OrderBillet::class)
                    ->withPivot('name', 'photo', 'price', 'quantity', 'total_amount')
                    ->as('order_items')
                    ->withTimestamps();
    }
}