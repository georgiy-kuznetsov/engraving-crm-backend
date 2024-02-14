<?php

namespace App\Models;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentStatus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_payment_statuses';

    protected $fillable = [
        'name',
        'description',
        'index',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
