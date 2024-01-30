<?php

namespace App\Models\Product;

use App\Models\Billet;
use App\Models\Order\Order;
use App\Models\Order\OrderProduct;
use App\Models\Product\Attribute;
use App\Models\Product\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'short_description',
        'description',
        'price',
        'sale_price',
        'sku',
        'onsale',
        'photo',
        'user_id',
        'category_id',
    ];
    
    protected $guarded = [
        'user_id',
        'photo',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'product_attribute', 'product_id', 'attribute_id')
                    ->withPivot('value')
                    ->withTimestamps();
    }

    public function billets(): BelongsToMany
    {
        return $this->belongsToMany(Billet::class, 'product_billet')
                    ->as('parts')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)
                    ->using(OrderProduct::class)
                    ->as('in_orders')
                    ->withTimestamps();

    }
}
