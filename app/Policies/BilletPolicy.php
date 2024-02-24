<?php

namespace App\Policies;

use App\Models\Billet;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BilletPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Billet $billet): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function update(User $user, Billet $billet): bool
    {
        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function delete(User $user, Billet $billet): bool
    {
        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function restore(User $user, Billet $billet): bool
    {
        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function forceDelete(User $user, Billet $billet): bool
    {
        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }
}
