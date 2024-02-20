<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'login.required' => 'Логин не может быть пустым',
            'password.required' => 'Пароль не может быть пустым',
            'password.string' => 'Пароль должен быть строкой',
            'login.string' => 'Логин должен быть строкой',
        ];
    }
}
