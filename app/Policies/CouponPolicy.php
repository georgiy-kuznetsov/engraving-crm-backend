<?php

namespace App\Policies;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CouponPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Coupon $coupon): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return ( in_array($user->role->guard_name, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function update(User $user, Coupon $coupon): bool
    {
        return ( in_array($user->role->guard_name, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function delete(User $user, Coupon $coupon): bool
    {
        return ( in_array($user->role->guard_name, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function restore(User $user, Coupon $coupon): bool
    {
        return ( in_array($user->role->guard_name, ['owner', 'admin']) )
                    ? true
                    : false;
    }

    public function forceDelete(User $user, Coupon $coupon): bool
    {
        return ( in_array($user->role->guard_name, ['owner', 'admin']) )
                    ? true
                    : false;
    }
}
