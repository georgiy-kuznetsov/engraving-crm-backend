<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingMethod extends Model
{
    use HasFactory;

    protected $table = 'shipping_methods';

    protected $fillable = [
        'name',
        'description',
        'index',
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
