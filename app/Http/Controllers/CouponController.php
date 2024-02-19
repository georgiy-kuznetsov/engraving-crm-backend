<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use App\Service\CouponService;

class CouponController extends Controller
{
    protected $service;

    public function __construct(CouponService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return Coupon::all();
    }

    public function store(CouponRequest $request)
    {
        return $this->service->store( $request, $request->validated() );
    }

    public function show(int $id)
    {
        return Coupon::findOrFail($id);
    }

    public function destroy(int $id)
    {
        if ( ! $coupon = Coupon::find($id) ) {
            return response()->json([], 204);
        };

        $coupon->delete();
        return response()->json([], 204);
    }
}
