<?php

namespace App\Models;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'country',
        'region',
        'city',
        'address',
        'postcode',
        'website', 
        'telegram',
        'vkontakte',
        'instagram',
        'whatsapp',
        'is_baned',
        'is_regular',
        'user_id',
    ];

    protected $gaurded = [
        'is_baned',
        'is_regular',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}