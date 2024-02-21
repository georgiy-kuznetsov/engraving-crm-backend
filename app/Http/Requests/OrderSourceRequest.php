<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderSourceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'index' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле обязательно для заполнения',
            'name.max' => 'Максимальное количество символов 255',
            'name.string' => 'Поле должно быть строкой',
            'description.string' => 'Поле должно быть строкой',
            'index.integer' => 'Поле должно быть целым числом',
            'index.min' => 'Индекс не может быть отрицательным',
        ];
    }
}
