<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStatusRequest;
use App\Models\OrderStatus;

class OrderStatusController extends Controller
{
    public function index()
    {
        return OrderStatus::all();
    }

    public function store(OrderStatusRequest $request)
    {
        return OrderStatus::create(  $request->validated());
    }

    public function show(int $id)
    {
        return OrderStatus::findOrFail($id);
    }

    public function destroy(int $id)
    {
        if ( $status = OrderStatus::find($id) ) {
            $status->delete();
        }
        return response()->json([], 204);
    }
}
