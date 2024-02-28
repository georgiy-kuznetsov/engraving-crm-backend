<?php

namespace App\Models;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiftCertificate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gift_certificates';

    protected $fillable = [
        'number',
        'balance',
        'is_used_up',
        'expires_at',
        'user_id',
    ];

    protected $hidden = [
        'deleted_at',
        'user_id',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used_up' => 'boolean',
    ];

    public function getNumber(): string
    {
        $prefix = 'cert-';
        $year = now()->parse()->year;
        $dayOfYear = str_pad( now()->parse()->dayOfYear, 3, 0, STR_PAD_LEFT );
        $id = str_pad( $this->id, 5, 0, STR_PAD_LEFT);
        return  $prefix . $year . $dayOfYear . $id;
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
