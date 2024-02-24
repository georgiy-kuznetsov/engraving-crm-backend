<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pageSize' => ['nullable', 'integer', 'max:100'],
            'page' => ['nullable', 'integer', 'max:999'],
        ];
    }

    public function messages(): array
    {
        return [
            'pageSize.max' => 'Поле должно быть не больше 100',
            'pageSize.integer' => 'Поле должно быть числом',
            'page.max' => 'Поле должно быть не больше 999',
            'page.integer' => 'Поле должно быть числом',
        ];
    }
}
