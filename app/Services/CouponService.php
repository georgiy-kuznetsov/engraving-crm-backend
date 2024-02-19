<?php
namespace App\Services;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponService extends Controller {
    public function store(CouponRequest $request, array $data): Coupon
    {
        $data['expires_at'] = Carbon::parse($data['expires_at']);
        return Coupon::create([
                ...$data,
                'user_id' => $request->user()->id,
            ]);
    }
}
