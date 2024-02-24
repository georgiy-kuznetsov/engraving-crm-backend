<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStatusRequest;
use App\Models\OrderStatus;

class OrderStatusController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', OrderStatus::class);
        return OrderStatus::all();
    }

    public function store(OrderStatusRequest $request)
    {
        $this->authorize('create', OrderStatus::class);
        return OrderStatus::create(  $request->validated());
    }

    public function show(OrderStatus $status)
    {
        $this->authorize('view', $status);
        return $status;
    }

    public function destroy(OrderStatus $status)
    {
        $this->authorize('delete', $status);
        $status->delete();
        return response()->json([], 204);
    }
}
