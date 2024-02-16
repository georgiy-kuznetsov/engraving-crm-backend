<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Service\Auth\LoginService;

class LoginController extends Controller
{
    protected $service;
    
    public function __construct(LoginService $service)
    {
        $this->service = $service;
    }
    
    public function login(LoginRequest $request) {
        $validatedData = $request->validated();

        return [
            'token' => $this->service->login($validatedData),
        ];
    }
}
