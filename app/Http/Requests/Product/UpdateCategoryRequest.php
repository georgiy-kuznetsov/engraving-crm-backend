<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $this->id],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле обязательно для заполнения',
            'name.string' => 'Поле должно быть строкой',
            'name.max' => 'Имя должно быть не более 255 символов',
            'name.unique' => 'Такая категория уже существует',
            'description.string' => 'Поле должно быть строкой',
        ];
    }
}
