<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return ( in_array( auth()->user()->role->guard_name, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function view(User $user): bool
    {
        $currentUser = auth()->user();
        if ($currentUser->id === $user->id ) {
            return true;
        }

        return ( in_array($currentUser->role->guard_name, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function create(): bool
    {
        return ( in_array( auth()->user()->role->guard_name, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function update(User $user, User $model): bool
    {
        $currentUser = auth()->user();
        if ( $currentUser->id === $user->id ) {
            return true;
        }
        if ( $user->role->guard_name === 'owner' && $currentUser->role->guard_name !== 'owner' ) {
            return false;
        }
        return ( in_array($currentUser->role->guard_name, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function delete(User $user, User $model): bool
    {
        $currentUser = auth()->user();
        if ( $currentUser->id === $user->id ) {
            return true;
        }

        if ( $user->role->guard_name === 'owner' && $currentUser->role->guard_name !== 'owner' ) {
            return false;
        }

        return ( in_array($currentUser->role->guard_name, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function restore(User $user, User $model): bool
    {
        $currentUser = auth()->user();
        if ( $currentUser->id === $user->id ) {
            return true;
        }

        if ( $user->role->guard_name === 'owner' && $currentUser->role->guard_name !== 'owner' ) {
            return false;
        }

        return ( in_array($currentUser->role->guard_name, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function forceDelete(User $user, User $model): bool
    {
        $currentUser = auth()->user();
        if ( $user->role->guard_name === 'owner' && $currentUser->role->guard_name !== 'owner' ) {
            return false;
        }

        return ( in_array($currentUser->role->guard_name, ['owner', 'admin']) )
                    ? true
                    : false;
    }
}
