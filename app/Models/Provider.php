<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use SoftDeletes;
    
    protected $table = 'providers';
    
    protected $fillable = [
        'name',
        'phone',
        'email',

        'country',
        'region',
        'city',
        'adress',
        'postcode',

        'store_link',
        'website',
        'telegram',
        'vkontakte',
        'instagram',
        'user_id',
    ];

    protected $gaurded = [
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function billets(): hasMany
    {
        return $this->hasMany(Billet::class); 
    }
}
