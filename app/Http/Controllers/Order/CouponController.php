<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order\Coupon;
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

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'promocode' => ['required', 'string', 'max:255', 'unique:coupons,promocode'],
            'discount_size' => ['required', 'decimal:2', 'max:99999999.99'],
            'type' => ['required', 'string', Rule::in( Coupon::getPossibleTypes() ), 'max:255'],
            'expires_at' => ['required', 'date'],
        ]);

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
