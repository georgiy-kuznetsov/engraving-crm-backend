<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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

    public function messages(): array
    {
        return [
            'name.required' => 'Наименование продукта не может быть пустым',
            'name.string' => 'Поле должно быть строкой',
            'name.max' => 'Наименование продукта не может быть больше 255 символов',
            'price.required' => 'Поле обязательно для заполнения',
            'price.decimal' => 'Поле должно быть числом',
            'price.max' => 'Цена не может быть больше 99999999.99',
            'sale_price.decimal' => 'Поле должно быть числом',
            'sale_price.max' => 'Цена не может быть больше 99999999.99',
            'short_description.string' => 'Поле должно быть строкой',
            'description.string' => 'Поле должно быть строкой',
            'sku.string' => 'Поле должно быть строкой',
            'sku.max' => 'SKU не может быть больше 255 символов',
            'category_id.integer' => 'Поле должно быть числом',
            'category_id.exists' => 'Категория не существует',
            'onsale.required' => 'Поле не может быть пустым',
            'billets.array' => 'Поле должно быть массивом',
            'billets.*.integer' => 'Поле должно быть числом',
            'billets.*.exists' => 'Заготовка не существует',
            'billet_quantity.array' => 'Поле должно быть массивом',
            'billet_quantity.*.required' => 'Поле не может быть пустым',
            'billet_quantity.*.integer' => 'Поле должно быть числом',
            'attributes.array' => 'Поле должно быть массивом',
            'attribute_value.array' => 'Поле должно быть массивом',
            'attribute_value.*.required' => 'Поле не может быть пустым',
            'attribute_value.*.decimal' => 'Поле должно быть числом',
            'attribute_value.*.max' => 'Цена не может быть больше 99999999.99',
        ];
    }
}
