<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;

class ShippingMethodController extends Controller
{
    public function index()
    {
        $shippingMethod = ShippingMethod::all();
        return $shippingMethod;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'index' => ['nullable', 'integer', 'min:0'],
        ]);

        $shippingMethod = ShippingMethod::create($validatedData);

        return $shippingMethod;
    }

    public function show(string $id)
    {
        if (! $shippingMethod = ShippingMethod::find($id)) {
            // return $this->sendErrorResponse(['Shipping method not found'], 404);
        };
        return $shippingMethod;
    }

    public function destroy(string $id)
    {
        if ( ! $shippingMethod = ShippingMethod::find($id) ) {
            return response()->json([], 204);
        };

        $shippingMethod->delete();
        return response()->json([], 204);
    }
}
