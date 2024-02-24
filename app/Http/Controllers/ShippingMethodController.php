<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingMethodRequest;
use App\Models\ShippingMethod;

class ShippingMethodController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', ShippingMethod::class);
        return ShippingMethod::all();
    }

    public function store(ShippingMethodRequest $request)
    {
        $this->authorize('create', ShippingMethod::class);
        return ShippingMethod::create( $request->validated() );
    }

    public function show(ShippingMethod $shippingMethod)
    {
        $this->authorize('view', $shippingMethod);
        return $shippingMethod;
    }

    public function destroy(ShippingMethod $shippingMethod)
    {
        $this->authorize('delete', $shippingMethod);
        $shippingMethod->delete();
        return response()->json([], 204);
    }
}
