<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMethodRequest;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function index()
    {
        return PaymentMethod::all();
    }

    public function store(PaymentMethodRequest $request)
    {
        return PaymentMethod::create( $request->validated() );
    }

    public function show(int $id)
    {
        return PaymentMethod::findOrFail($id);
    }

    public function destroy(int $id)
    {
        if ( $paymentMethod = PaymentMethod::find($id) ) {
            $paymentMethod->delete();
        };
        return response()->json([], 204);
    }
}
