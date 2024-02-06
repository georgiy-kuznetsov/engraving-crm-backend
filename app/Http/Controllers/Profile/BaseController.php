<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Service\Profile\ProfileService;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $service;

    public function __counstruct(ProfileService $service) {
        $this->service = $service;
    }
}
