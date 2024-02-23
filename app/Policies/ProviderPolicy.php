<?php

namespace App\Policies;

use App\Models\Provider;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProviderPolicy
{
    public function viewAny(User $user): Response
    {
        return ($user->role->guard_name === 'user')
                    ? Response::deny('У вас нет доступа для выполнения запроса')
                    : Response::allow();
    }

    public function view(User $user, Provider $provider): bool
    {
        if ($provider->user->id === $user->id) {
            return true;
        }

        if ( in_array($user->role->guard_name, ['owner', 'admin', 'manager']) ) {
            return true;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Provider $provider): bool
    {
        if ($provider->user->id === $user->id) {
            return true;
        }

        if ($user->role === 'owner' || $user->role === 'admin' || $user->role === 'manager') {
            return true;
        }

        return false;
    }

    public function delete(User $user, Provider $provider): bool
    {
        if ($provider->user->id === $user->id) {
            return true;
        }

        if ($user->role === 'owner' || $user->role === 'admin' || $user->role === 'manager') {
            return true;
        }

        return false;
    }

    public function restore(User $user, Provider $provider): bool
    {
        if ($provider->user->id === $user->id) {
            return true;
        }

        if ($user->role === 'owner' || $user->role === 'admin') {
            return true;
        }

        return false;
    }

    public function forceDelete(User $user, Provider $provider): bool
    {
        return ($user->role === 'owner' || $user->role === 'admin')
                    ? true
                    : false;
    }
}
