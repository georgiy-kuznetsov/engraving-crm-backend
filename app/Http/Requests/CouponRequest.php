<?php

namespace App\Http\Requests;

use App\Models\Coupon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'promocode' => ['required', 'string', 'max:255', 'unique:coupons,promocode'],
            'discount_size' => ['required', 'decimal:2', 'max:99999999.99'],
            'type' => ['required', 'string', Rule::in( Coupon::getPossibleTypes() ), 'max:255'],
            'expires_at' => ['required', 'date'],
        ];
    }
}
