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
        $validatedData = $request->validated();

        return PaymentStatus::create($validatedData);
    }

    public function show(int $id)
    {
        return PaymentStatus::findOrFail($id);
    }

    public function destroy(int $id)
    {
        if ( ! $paymentStatus = PaymentStatus::find($id) ) {
            return response()->json([], 204);
        };

        $paymentStatus->delete();
        return response()->json([], 204);
    }
}
