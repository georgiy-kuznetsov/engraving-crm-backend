<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    private $fillable = [
        'promocode',
        'term',
        'discount_size',
        'type',
        'user_id'
    ];

    protected $guarded = [
        'user_id',
    ];
}
