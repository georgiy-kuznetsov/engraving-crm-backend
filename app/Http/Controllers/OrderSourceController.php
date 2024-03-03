<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderSourceRequest;
use App\Models\OrderSource;

class OrderSourceController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', OrderSource::class);
        return OrderSource::all();
    }

    public function store(OrderSourceRequest $request)
    {
        return OrderSource::create( $request->validated() );
    }

    public function show(OrderSource $orderSource)
    {
        $this->authorize('view', $orderSource);
        return $orderSource;
    }

    public function destroy(OrderSource $orderSource)
    {
        $this->authorize('delete', $orderSource);
        $orderSource->delete();
        return response()->json([], 204);
    }

    public function getOrders(OrderSource $orderSource)
    {
        $this->authorize('view', $orderSource);
        return $orderSource->orders;
    }
}
