<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderSourceRequest;
use App\Models\OrderSource;

class OrderSourceController extends Controller
{
    public function index()
    {
        return OrderSource::all();
    }

    public function store(OrderSourceRequest $request)
    {
        return OrderSource::create( $request->validated() );
    }

    public function show(string $id)
    {
        return OrderSource::findOrFail($id);
    }

    public function destroy(string $id)
    {
        if ( ! $source = OrderSource::find($id) ) {
            return response()->json([], 204);
        };

        $source->delete();
        return response()->json([], 204);
    }

    public function getOrders(int $id)
    {
        return OrderSource::findOrFail($id)->orders;
    }
}
