<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Order\ShippingMethod;
use Illuminate\Http\Request;

class ShippingMethodController extends BaseController
{
    public function index()
    {
        $shippingMethod = ShippingMethod::all();
        return $this->sendSuccessResponse($shippingMethod, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'index' => ['nullable', 'integer', 'min:0'],
        ]);

        $shippingMethod = ShippingMethod::create($validatedData);

        return $this->sendSuccessResponse($shippingMethod, 200);
    }

    public function show(string $id)
    {
        if (! $shippingMethod = ShippingMethod::find($id)) {
            return $this->sendErrorResponse(['Shipping method not found'], 404);
        };
        return $this->sendSuccessResponse($shippingMethod, 200);
    }

    public function destroy(string $id)
    {
        if ( ! $shippingMethod = ShippingMethod::find($id) ) {
            return $this->sendSuccessResponse([], 204);
        };

        $shippingMethod->delete();
        return $this->sendSuccessResponse([], 204);
    }
}
