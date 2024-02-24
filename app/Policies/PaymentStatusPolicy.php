<?php

namespace App\Policies;

use App\Models\PaymentStatus;
use App\Models\User;

class PaymentStatusPolicy
{
    public function viewAny(): bool
    {
        return true;
    }

    public function view(): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return ( in_array($user->role->guard_name, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function update(User $user): bool
    {
        return ( in_array($user->role->guard_name, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function delete(User $user): bool
    {
        return ( in_array($user->role->guard_name, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function restore(User $user): bool
    {
        return ( in_array($user->role->guard_name, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function forceDelete(User $user): bool
    {
        return ( in_array($user->role->guard_name, ['owner', 'admin']) )
                    ? true
                    : false;
    }
}
