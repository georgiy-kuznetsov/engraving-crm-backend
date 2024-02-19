<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingMethodRequest;
use App\Models\ShippingMethod;

class ShippingMethodController extends Controller
{
    public function index()
    {
        return ShippingMethod::all();
    }

    public function store(ShippingMethodRequest $request)
    {
        return ShippingMethod::create( $request->validated() );
    }

    public function show(int $id)
    {
        return ShippingMethod::findOrFail($id);
    }

    public function destroy(int $id)
    {
        if ( $shippingMethod = ShippingMethod::find($id) ) {
            $shippingMethod->delete();
        };
        return response()->json([], 204);
    }
}
