<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::all();
        return $paymentMethods;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'index' => ['nullable', 'integer', 'min:0'],
        ]);

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
