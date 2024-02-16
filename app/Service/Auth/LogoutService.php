<?php
namespace App\Service\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LogoutService extends Controller {
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        $request->attributes->set('message', 'Выход выполнен успешно.');
        return true;
    }
}