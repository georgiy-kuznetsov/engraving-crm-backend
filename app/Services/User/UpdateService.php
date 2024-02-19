<?php
namespace App\Services\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class UpdateService extends Controller {
    public function __invoke(array $data, int $id): User
    {
        $user = User::findOrFail($id);
        $user->update( $data );
        return $user->fresh();
    }
}
