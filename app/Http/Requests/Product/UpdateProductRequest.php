<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'decimal:2', 'max:99999999.99'],
            'sale_price' => ['nullable', 'decimal:2', 'max:99999999.99'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'sku' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'onsale' => ['required', 'boolean'],

            'billets' => ['nullable', 'array'],
            'billets.*' => ['required', 'integer', 'exists:billets,id'],
            'billet_quantity' => ['nullable', 'array'],
            'billet_quantity.*' => ['required', 'integer'],

            'attributes' => ['nullable', 'array'],
            'attributes.*' => ['required', 'integer', 'exists:attributes,id'],
            'attribute_value' => ['nullable', 'array'],
            'attribute_value.*' => ['required', 'decimal:2', 'max:99999999.99'],
        ];
    }
}
