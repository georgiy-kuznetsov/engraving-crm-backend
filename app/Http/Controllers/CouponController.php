<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use App\Services\CouponService;

class CouponController extends Controller
{
    protected $service;

    public function __construct(CouponService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $this->authorize('viewAny', Coupon::class);
        return Coupon::all();
    }

    public function store(CouponRequest $request)
    {
        $this->authorize('create', Coupon::class);
        return $this->service->store( $request, $request->validated() );
    }

    public function show(int $id)
    {
        $this->authorize('view', Coupon::class);
        return Coupon::findOrFail($id);
    }

    public function destroy(Coupon $coupon)
    {
        $this->authorize('delete', $coupon);
        $coupon->delete();
        return response()->json([], 204);
    }
}
