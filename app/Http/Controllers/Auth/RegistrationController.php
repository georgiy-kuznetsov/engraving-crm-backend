<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\User;

class RegistrationController extends Controller
{
    public function registration(RegistrationRequest $request) {
        $validatedData = $request->validated();

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

        return [ 'token' => $user->createToken('api-token')->plainTextToken ];
    }
}
