<?php

namespace App\Models;

use App\Models\Order\Order;
use App\Models\Order\OrderBillet;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Billet extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'billets';

    protected $fillable = [
        'name',
        'price',
        'description',
        'sku',
        'stock_quantity',
        'user_id',
    ];

    protected $hidden = [
        'provider_id',
    ];

    protected $guarded = [
        'user_id',
        'photo_link',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_billet')
                    ->as('parts')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_billet')
                    ->using(OrderBillet::class)
                    ->as('in_orders')
                    ->withTimestamps();
    }
}
