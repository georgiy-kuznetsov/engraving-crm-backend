<?php
namespace App\Service\Profile;

use App\Models\User;
use App\Policies\Profile\ProfilePolicy;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class ProfileService extends Controller
{
    static function get() {
        $user = auth()->user();
        return $user;
    }

    static function update($data) {
        $userId = auth()->user()->id;
        $user = User::findOrFail($userId);
        $user->update($data);
        return $user;
    }

    static function delete()
    {
        $userId = auth()->user()->id;
        User::findOrFail($userId)->delete();
        return true;
    }
}