<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'login',
        'email',
        'password',

        'first_name',
        'last_name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'is_owner',
        'active',
        'email_verified_at',
    ];

    protected $garded = [
        'avatar_large',
        'avatar_small',
        'is_owner',
        'active',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function provider(): hasMany
    {
        return $this->hasMany(Provider::class);
    }
    
    public function billet(): hasMany
    {
        return $this->hasMany(Billet::class);
    }

    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
