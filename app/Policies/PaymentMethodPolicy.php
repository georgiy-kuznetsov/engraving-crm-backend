<?php

namespace App\Policies;

use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PaymentMethodPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, PaymentMethod $paymentMethod): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function update(User $user, PaymentMethod $paymentMethod): bool
    {
        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function delete(User $user, PaymentMethod $paymentMethod): bool
    {
        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function restore(User $user, PaymentMethod $paymentMethod): bool
    {
        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function forceDelete(User $user, PaymentMethod $paymentMethod): bool
    {
        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }
}
