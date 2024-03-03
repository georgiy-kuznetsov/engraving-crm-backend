<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentStatusRequest;
use App\Models\PaymentStatus;

class PaymentStatusController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', PaymentStatus::class);
        return PaymentStatus::orderBy('index')->get();
    }

    public function store(PaymentStatusRequest $request)
    {
        return PaymentStatus::create( $request->validated() );
    }

    public function show(PaymentStatus $paymentStatus)
    {
        $this->authorize('view', $paymentStatus);
        return $paymentStatus;
    }

    public function destroy(PaymentStatus $paymentStatus)
    {
        $this->authorize('delete', $paymentStatus);
        $paymentStatus->delete();
        return response()->json([], 204);
    }
}
