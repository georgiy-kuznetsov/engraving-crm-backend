<?php

namespace App\Http\Requests;

use App\Models\GiftCertificate;
use Illuminate\Foundation\Http\FormRequest;

class GiftCertificateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', GiftCertificate::class);
    }

    public function rules(): array
    {
        return [
            'number' => ['nullable', 'string', 'max:255', 'unique:girt_certificates,number'],
            'balance' => ['required', 'decimal:2', 'max:99999999.99'],
            'expires_at' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'number.unique' => 'Подарочный сертификат с таким номером уже существует',
            'number.string' => 'Поле должно быть строкой',
            'number.max' => 'Номер сертификата не должен превышать 255 символов',
            'balance.required' => 'Поле обязательно для заполнения',
            'balance.decimal' => 'Поле должно быть числовым',
            'balance.max' => 'Сумма подарочного сертификата не должна превышать 99999999.99',
            'expires_at.required' => 'Поле обязательно для заполнения',
            'expires_at.date' => 'Поле должно быть датой',
        ];
    }
}
