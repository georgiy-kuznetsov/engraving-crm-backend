<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Order\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends BaseController
{
    public function index()
    {
        $paymentMethods = PaymentMethod::all();
        return $this->sendSuccessResponse($paymentMethods, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'index' => ['nullable', 'integer', 'min:0'],
        ]);

        $paymentMethod = PaymentMethod::create($validatedData);

        return $this->sendSuccessResponse($paymentMethod, 200);
    }

    public function show(string $id)
    {
        if (! $paymentMethod = PaymentMethod::find($id)) {
            return $this->sendErrorResponse(['Payment method not found'], 404);
        };
        return $this->sendSuccessResponse($paymentMethod, 200);
    }

    public function destroy(string $id)
    {
        if ( ! $paymentMethod = PaymentMethod::find($id) ) {
            return $this->sendSuccessResponse([], 204);
        };

        $paymentMethod->delete();
        return $this->sendSuccessResponse([], 204);
    }
}
