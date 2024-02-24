<?php
namespace App\Services\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class UpdateService extends Controller {
    public function __invoke(array $data, User $user): User
    {
        $user->update( $data );
        return $user->fresh();
    }
}
