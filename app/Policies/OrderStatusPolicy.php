<?php

namespace App\Policies;

use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderStatusPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, OrderStatus $orderStatus): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function update(User $user, OrderStatus $orderStatus): bool
    {
        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function delete(User $user, OrderStatus $orderStatus): bool
    {
        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function restore(User $user, OrderStatus $orderStatus): bool
    {
        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function forceDelete(User $user, OrderStatus $orderStatus): bool
    {
        return ( in_array($user->role, ['owner', 'admin']) )
                    ? true
                    : false;
    }
}
