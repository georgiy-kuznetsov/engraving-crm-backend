<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_description',
        'description',
        'price',
        'sale_price',
        'sku',
        'onsale',
        'photo',
        'user_id',
    ];
    
    protected $guarded = [
        'user_id',
        'photo',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function billets(): BelongsToMany
    {
        return $this->belongsToMany(Billet::class, 'product_billet')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
