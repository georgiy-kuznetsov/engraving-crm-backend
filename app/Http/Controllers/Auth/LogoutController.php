<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        
        $request->attributes->set('message', 'Выход выполнен успешно.');
        return [];
    }
}
