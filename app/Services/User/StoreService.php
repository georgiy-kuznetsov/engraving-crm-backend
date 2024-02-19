<?php
namespace App\Services\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;

class StoreService extends Controller {
    public function __invoke(array $data): User
    {
        return User::create([
            ...$data,
            'password' => bcrypt( $data['password'] ),
            'avatar_large' => null,
            'avatar_small' => null,
            'is_owner' => false,
            'active' => false,
        ]);
    }

    public function update(array $data, int $id): User
    {
        $user = User::findOrFail($id);
        $user->update( $data );
        return $user->fresh();
    }
}
