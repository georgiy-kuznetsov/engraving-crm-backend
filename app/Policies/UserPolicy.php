<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function view(User $user): bool
    {
        if ( auth()->user->id === $user->id ) {
            return true;
        }

        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function create(User $user): bool
    {
        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function update(User $user, User $model): bool
    {
        if ( auth()->user->id === $user->id ) {
            return true;
        }

        if ( $user->role === 'owner' && auth()->user->role !== 'owner' ) {
            return false;
        }

        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function delete(User $user, User $model): bool
    {
        if ( auth()->user->id === $user->id ) {
            return true;
        }

        if ( $user->role === 'owner' && auth()->user->role !== 'owner' ) {
            return false;
        }

        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function restore(User $user, User $model): bool
    {
        if ( auth()->user->id === $user->id ) {
            return true;
        }

        if ( $user->role === 'owner' && auth()->user->role !== 'owner' ) {
            return false;
        }

        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function forceDelete(User $user, User $model): bool
    {
        if ( $user->role === 'owner' && auth()->user->role !== 'owner' ) {
            return false;
        }

        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }
}
