<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentStatus;
use Illuminate\Http\Request;

class PaymentStatusController extends Controller
{
    public function index()
    {
        return PaymentStatus::orderBy('index')->get();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'index' => ['nullable', 'integer', 'min:0'],
        ]);

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
