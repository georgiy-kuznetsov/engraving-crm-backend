<?php

namespace App\Models;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipts extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_receipts';

    protected $fillable = [
        'link',
        'type',
        'order_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
