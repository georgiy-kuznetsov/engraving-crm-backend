<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Services\Auth\RegistrationService;

class RegistrationController extends Controller
{
    protected $service;

    public function __construct(RegistrationService $service) {
        $this->service = $service;
    }

    public function registration(RegistrationRequest $request) {
        $validatedData = $request->validated();
        return [
            'token' => $this->service->registration($validatedData),
        ];
    }
}
