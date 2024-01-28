<?php
namespace App\Service\Profile;

use App\Policies\Profile\ProfilePolicy;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class ProfileService extends Controller
{
    static function getUserProfile() {
        $user = auth()->user();
        return $user;
    }
}