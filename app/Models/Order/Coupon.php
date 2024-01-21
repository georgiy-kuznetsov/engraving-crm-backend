<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'promocode',
        'term',
        'discount_size',
        'type',
        'user_id'
    ];

    protected $guarded = [
        'user_id',
    ];

    public static function getPossibleTypes() {
        return [
            'fixed',
            'percent',
        ];
    }
}
