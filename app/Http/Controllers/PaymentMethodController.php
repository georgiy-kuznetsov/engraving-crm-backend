<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMethodRequest;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::all();
        return $paymentMethods;
    }

    public function store(PaymentMethodRequest $request)
    {
        $validatedData = $request->validated();

        $paymentMethod = PaymentMethod::create($validatedData);

        return $paymentMethod;
    }

    public function show(string $id)
    {
        if (! $paymentMethod = PaymentMethod::find($id)) {
            // return $this->sendErrorResponse(['Payment method not found'], 404);
        };
        return $paymentMethod;
    }

    public function destroy(string $id)
    {
        if ( ! $paymentMethod = PaymentMethod::find($id) ) {
            return response()->json([], 204);
        };

        $paymentMethod->delete();
        return response()->json([], 204);
    }
}
