<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Source extends Model
{
    use HasFactory;

    protected $table = 'order_sources';

    protected $fillable = [
        'name',
        'description',
        'index',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'source_id', 'id');
    }
}
