<?php
namespace App\Services\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegistrationService extends Controller {
    public function registration(array $data): string
    {
        $user = User::create([
            ... $data,
            'password' => bcrypt( $data['password'] ),
            'avatar_large' => null,
            'avatar_small' => null,
            'is_owner' => false,
            'active' => false,
        ]);
        return $user->createToken('api-token')->plainTextToken;
    }
}
