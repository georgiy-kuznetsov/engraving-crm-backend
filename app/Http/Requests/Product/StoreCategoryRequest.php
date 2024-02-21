<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:categories'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Имя категории не может быть пустым',
            'name.unique' => 'Такая категория уже существует',
            'name.max' => 'Имя категории не может быть больше 255 символов',
            'name.string' => 'Поле должно быть строкой',
            'description.string' => 'Поле должно быть строкой',
            'description.max' => 'Описание не может быть больше 255 символов',
        ];
    }
}
