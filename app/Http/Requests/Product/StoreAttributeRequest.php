<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttributeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:attributes'],
            'unit' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Имя атрибута не может быть пустым',
            'name.unique' => 'Такой атрибут уже существует',
            'name.string' => 'Поле должно быть строкой',
            'name.max' => 'Максимальная длина 255 символов',
            'unit.string' => 'Поле должно быть строкой',
            'unit.max' => 'Максимальная длина 255 символов',
        ];
    }
}
