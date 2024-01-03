<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
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

        return response()->json([
            'token' => $user->createToken('api-token')->plainTextToken,
        ]);
    }

    public function login(Request $request) {
        $validatedData = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('login', $validatedData['login'])->first();

        if (!$user) {
            $user = User::where('email', $validatedData['login'])->first();
        }
        
        if ( !$user || !Hash::check($validatedData['password'], $user->password) ) {
            throw ValidationException::withMessages([
                'login' => 'Invalid username or password.',
            ]);
        };

        return response()->json([
            'token' => $user->createToken('api-token')->plainTextToken,
        ]);
    }
}
