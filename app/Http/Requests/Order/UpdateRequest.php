<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'shipping_amount' => ['required', 'decimal:2', 'min: 0.00', 'max:99999999.99'],
            'gratuity_amount' => ['required', 'decimal:2', 'min: 0.00', 'max:99999999.99'],
            'coupon' => ['nullable', 'string', 'exists:coupons,promocode'],
            'shipping_method_id' => ['nullable', 'integer', 'exists:shipping_methods,id'],
            'payment_method_id' => ['nullable', 'integer', 'exists:payment_methods,id'],
            'status_id' => ['nullable', 'integer', 'exists:order_statuses,id'],
            'source_id' => ['nullable', 'integer', 'exists:order_sources,id'],
            'customer_id' => ['nullable', 'integer', 'exists:customers,id'],

            'products' => ['nullable', 'array'],
            'products.*.id' => ['required', 'integer', 'exists:products,id'],
            'products.*.quantity' => ['required', 'integer'],

            'billets' => ['nullable', 'array'],
            'billets.*.id' => ['required', 'integer', 'exists:products,id'],
            'billets.*.quantity' => ['required', 'integer'],
        ];
    }
}
