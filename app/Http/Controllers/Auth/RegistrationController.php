<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;

class RegistrationController extends BaseController
{
    public function registration(Request $request) {
        $validatedData = $request->validate([
            'login' => ['required', 'unique:users', 'min:7', 'max:50'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', 'min:6', 'max:50'],
            'first_name' => ['nullable', 'string', 'max:100'],
            'last_name' => ['nullable', 'string', 'max:100'],
        ]);

        $user = User::create([
            'login' => $validatedData['login'],
            'email' => $validatedData['email'],
            'password' => bcrypt( $validatedData['password'] ),

            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'avatar_large' => null,
            'avatar_small' => null,

            'is_owner' => false,
            'active' => false,
        ]);

        return $this->sendSuccessResponse([
            'token' => $user->createToken('api-token')->plainTextToken,
        ], 201);
    }
}
