<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingMethod extends Model
{
    use HasFactory, SoftDeletes;

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
