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

    public function messages(): array
    {
        return [
            'promocode.required' => 'Поле обязательно для заполнения',
            'promocode.unique' => 'Купон с таким кодом уже существует',
            'promocode.string' => 'Поле должно быть строкой',
            'promocode.max' => 'Максимальная длина 255 символов',
            'discount_size.required' => 'Поле обязательно для заполнения',
            'discount_size.decimal' => 'Поле должно быть числом',
            'discount_size.max' => 'Максимальное значение 99999999.99',
            'type.required' => 'Поле обязательно для заполнения',
            'type.string' => 'Поле должно быть строкой',
            'type.in' => 'Недопустимое значение',
            'type.string' => 'Поле должно быть строкой',
            'expires_at.required' => 'Поле обязательно для заполнения',
            'expires_at.date' => 'Поле должно быть датой',
        ];
    }
}
