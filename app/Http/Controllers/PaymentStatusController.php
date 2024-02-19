<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentStatusRequest;
use App\Models\PaymentStatus;

class PaymentStatusController extends Controller
{
    public function index()
    {
        return PaymentStatus::orderBy('index')->get();
    }

    public function store(PaymentStatusRequest $request)
    {
        return PaymentStatus::create( $request->validated() );
    }

    public function show(int $id)
    {
        return PaymentStatus::findOrFail($id);
    }

    public function destroy(int $id)
    {
        if ( $paymentStatus = PaymentStatus::find($id) ) {
            $paymentStatus->delete();
        };

        return response()->json([], 204);
    }
}
