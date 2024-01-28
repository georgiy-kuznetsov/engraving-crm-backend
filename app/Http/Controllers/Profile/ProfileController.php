<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Profile\ProfileResource;
use App\Service\Profile\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = ProfileService::getUserProfile();
        return ProfileResource::make($user);
    }

    public function update(Request $request)
    {
        
    }

    public function destroy(string $id)
    {
        //
    }
}
