<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected $guarded = [];
}
