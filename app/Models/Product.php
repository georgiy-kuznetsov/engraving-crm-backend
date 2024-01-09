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
        'title',
        'short_description',
        'description',
        'price',
        'sale_price',
        'sku',
        'photo',
        'onsale',
    ];

    protected $hidden = [
        'user_id',
    ];

    protected $guarded = [
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function billets(): BelongsToMany
    {
        return $this->belongsToMany(Billet::class)->withPivot('quantity');
    }
}
