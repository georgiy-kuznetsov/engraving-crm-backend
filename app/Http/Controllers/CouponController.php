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
        return Coupon::all();
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
