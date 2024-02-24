<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMethodRequest;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', PaymentMethod::class);
        return PaymentMethod::all();
    }

    public function store(PaymentMethodRequest $request)
    {
        $this->authorize('create', PaymentMethod::class);
        return PaymentMethod::create( $request->validated() );
    }

    public function show(PaymentMethod $paymentMethod)
    {
        $this->authorize('view', $paymentMethod);
        return $paymentMethod;
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $this->authorize('delete', $paymentMethod);
        $paymentMethod->delete();
        return response()->json([], 204);
    }
}
