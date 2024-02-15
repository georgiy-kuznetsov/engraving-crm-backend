<?php

namespace App\Http\Requests\Billet;

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
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'decimal:2', 'max:99999999.99'],
            'description' => ['nullable', 'string'],
            'sku' => ['nullable', 'string', 'max:255'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'provider_id' => ['nullable', 'integer', 'exists:providers,id'],
        ];
    }
}
