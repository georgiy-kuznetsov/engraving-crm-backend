<?php
namespace App\Services\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginService extends Controller {
    public function login($data) {
        if ( ! $user = User::where('login', $data['login'])->first() ) {
            $user = User::where('email', $data['login'])->first();
        }

        if ( !$user || !Hash::check($data['password'], $user->password) ) {
            throw ValidationException::withMessages([
                'login' => 'Invalid username or password.',
            ]);
        };

        return $user->createToken('api-token')->plainTextToken;
    }
}
