<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\LogoutService;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    protected $service;

    public function __construct(LogoutService $service) {
        $this->service = $service;
    }
    public function logout(Request $request) {
        $this->service->logout($request);
        return [];
    }
}
