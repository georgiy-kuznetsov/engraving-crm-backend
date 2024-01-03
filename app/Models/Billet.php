<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'sku',
        'quantity_stock',
    ];

    protected $hidden = [
        'user_id',
        'provider_id',
    ];

    protected $guarded = [
        'photo_link',
    ];


    
}
