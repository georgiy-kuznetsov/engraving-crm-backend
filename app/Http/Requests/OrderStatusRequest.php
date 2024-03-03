<?php

namespace App\Http\Requests;

use App\Models\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;

class OrderStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->authorize('create', OrderStatus::class);
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
            'name.string' => 'Поле должно быть строкой',
            'name.max' => 'Максимальная длина 255 символов',
            'description.string' => 'Поле должно быть строкой',
            'index.integer' => 'Поле должно быть целым числом',
            'index.min' => 'Индекс не может быть отрицательным',
        ];
    }
}
