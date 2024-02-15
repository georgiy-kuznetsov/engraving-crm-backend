<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all();
        return $coupons;
    }

    public function store(CouponRequest $request)
    {
        $validatedData = $request->validated();

        $validatedData['expires_at'] = Carbon::parse($validatedData['expires_at']);

        $coupon = Coupon::create([
            ...$validatedData,
            'user_id' => $request->user()->id,
        ]);

        return $coupon;
    }

    public function show(string $id)
    {
        if ( ! $coupon = Coupon::find($id) ) {
            // return $this->sendErrorResponse(['Coupon not found'], 404);
        };
        
        return $coupon;
    }

    public function destroy(string $id)
    {
        if ( ! $coupon = Coupon::find($id) ) {
            return response()->json([], 204);
        };

        $coupon->delete();
        return response()->json([], 204);
    }
}
