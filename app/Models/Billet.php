<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Billet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'sku',
        'stock_quantity',
        'user_id',
    ];

    protected $hidden = [
        'provider_id',
    ];

    protected $guarded = [
        'user_id',
        'photo_link',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_billet')
                    ->as('parts')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }}
