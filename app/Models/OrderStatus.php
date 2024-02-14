<?php

namespace App\Models;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_statuses';

    protected $fillable = [
        'name',
        'description',
        'index',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
