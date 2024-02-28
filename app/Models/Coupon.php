<?php

namespace App\Models;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'coupons';

    protected $fillable = [
        'promocode',
        'discount_size',
        'type',
        'expires_at',
        'user_id',
    ];

    protected $guarded = [
        'user_id',
    ];

    protected $hidden = [
        'user_id',
    ];

    protected $casts = [
        'expires_at' => 'date',
    ];

    public static function getPossibleTypes() {
        return [
            'fixed',
            'percent',
        ];
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
