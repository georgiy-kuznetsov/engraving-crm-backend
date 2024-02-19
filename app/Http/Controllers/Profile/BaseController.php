<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Services\Profile\ProfileService;

class BaseController extends Controller
{
    public $service;

    public function __counstruct(ProfileService $service) {
        $this->service = $service;
    }
}
