<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
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

        return [ 'token' => $user->createToken('api-token')->plainTextToken ];
    }
}
