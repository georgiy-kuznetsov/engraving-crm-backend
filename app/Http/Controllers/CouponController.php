<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CouponController extends BaseController
{
    public function index()
    {
        $coupons = Coupon::all();
        return $this->sendSuccessResponse($coupons, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'promocode' => ['required', 'string', 'max:255'],
            'term' => ['required', 'date'],
            'discount_size' => ['required', 'decimal:2', 'max:99999999.99'],
            'type' => ['required', 'string', Rule::in( Coupon::getPossibleTypes() ), 'max:255'],
        ]);

        $validatedData['term'] = Carbon::parse($validatedData['term']);

        $coupon = Coupon::create([
            ...$validatedData,
            'user_id' => $request->user()->id,
        ]);

        return $this->sendSuccessResponse($coupon, 201);
    }

    public function show(string $id)
    {
        if ( ! $coupon = Coupon::find($id) ) {
            return $this->sendErrorResponse(['Coupon not found'], 404);
        };
        
        return $this->sendSuccessResponse($coupon, 200);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
