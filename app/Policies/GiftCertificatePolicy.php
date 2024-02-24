<?php

namespace App\Policies;

use App\Models\GiftCertificate;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GiftCertificatePolicy
{
    public function viewAny(): bool
    {
        return true;
    }

    public function view(): bool
    {
        return true;
    }

    public function create(): bool
    {
        return true;
    }

    public function update(User $user): bool
    {
        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function delete(User $user): bool
    {
        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function restore(User $user): bool
    {
        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function forceDelete(User $user): bool
    {
        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }
}
