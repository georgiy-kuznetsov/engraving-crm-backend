<?php

namespace App\Http\Requests\Billet;

use App\Models\Billet;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('billet'));
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'decimal:2', 'min:0', 'max:99999999.99'],
            'description' => ['nullable', 'string'],
            'sku' => ['nullable', 'string', 'max:255'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'provider_id' => ['nullable', 'integer', 'exists:providers,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Название не может быть пустым',
            'name.string' => 'Название должно быть строкой',
            'name.max' => 'Название не может быть больше 255 символов',
            'price.required' => 'Цена не может быть пустой',
            'price.decimal' => 'Цена должна быть вещественным числом',
            'price.min' => 'Цена не может быть меньше нуля',
            'price.max' => 'Цена не может быть больше 99999999.99',
            'description.string' => 'Описание должно быть строкой',
            'sku.string' => 'Артикул должен быть строкой',
            'sku.max' => 'Артикул не может быть больше 255 символов',
            'stock_quantity.required' => 'Количество на складе не может быть пустым',
            'stock_quantity.integer' => 'Количество на складе должно быть целым числом',
            'stock_quantity.min' => 'Количество на складе не может быть меньше нуля',
            'provider_id.exists' => 'Поставщик с таким ID не существует',
            'provider_id.integer' => 'ID поставщика должен быть числом',
        ];
    }
}
