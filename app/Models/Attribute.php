<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'unit',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_attribute', 'product_id', 'attribute_id')
                    ->withPivot('value')
                    ->withTimestamps();
    }
}
