<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStatusRequest;
use App\Models\OrderStatus;

class OrderStatusController extends Controller
{
    public function index()
    {
        $status = OrderStatus::all();
        return $status;
    }

    public function store(OrderStatusRequest $request)
    {
        $validatedData = $request->validated();

        $status = OrderStatus::create($validatedData);

        return $status;
    }

    public function show(string $id)
    {
        if (! $status = OrderStatus::find($id)) {
            // return $this->sendErrorResponse(['Status not found'], 404);
        };
        return $status;
    }

    public function destroy(string $id)
    {
        if ( ! $status = OrderStatus::find($id) ) {
            return response()->json([], 204);
        };

        $status->delete();
        return response()->json([], 204);
    }
}
