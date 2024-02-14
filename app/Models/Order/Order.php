<?php

namespace App\Models\Order;

use App\Models\Billet;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\GiftCertificate;
use App\Models\OrderSource;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\PaymentStatus;
use App\Models\Product\Product;
use App\Models\Receipts;
use App\Models\ShippingMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';
    
    protected $fillable = [
        'number',
        'price_amount',
        'price_discount',
        'discount_amount',
        'shipping_amount',
        'gratuity_amount',
        'total_amount',
        'status_id',
        'payment_status_id',
        'source_id',
        'coupon_id',
        'gift_certificate_id',
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
        $prefix = now()->parse()->year;
        $number = str_pad( $this->id, 5, 0, STR_PAD_LEFT);
        return  $prefix . $number;
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function paymentStatus(): BelongsTo
    {
        return $this->belongsTo(PaymentStatus::class);
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

    public function source(): BelongsTo
    {
        return $this->belongsTo(OrderSource::class, 'source_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
                    ->using(OrderProduct::class)
                    ->withPivot('name', 'photo', 'price', 'sale_price', 'quantity', 'amount')
                    ->withTimestamps();
    }

    public function billets(): BelongsToMany
    {
        return $this->belongsToMany(Billet::class, 'order_billet', 'order_id', 'billet_id')
                    ->using(OrderBillet::class)
                    ->withPivot('name', 'photo', 'price', 'quantity', 'amount')
                    ->withTimestamps();
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipts::class);
    }

    public function giftCertificate(): BelongsTo
    {
        return $this->belongsTo(GiftCertificate::class);
    }
}
