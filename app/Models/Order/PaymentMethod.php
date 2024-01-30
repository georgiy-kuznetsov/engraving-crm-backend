<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';   

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
