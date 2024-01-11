<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class LogoutController extends BaseController
{
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        
        return $this->sendSuccessResponse([], 200, ['Successfuly logged out.']);
    }
}
