<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
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


    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfuly logged out.'
        ]);
    }
}
