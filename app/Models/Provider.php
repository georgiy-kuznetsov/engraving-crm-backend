<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Provider extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',

        'country',
        'region',
        'city',
        'adress',
        'postcode',

        'strore_link',
        'website',
        'telegram',
        'vkontakte',
        'instagram',
    ];

    protected $hidden = [
        'user_id',
    ];

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
