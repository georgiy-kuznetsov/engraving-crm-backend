<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OrderSource;
use Illuminate\Http\Request;

class OrderSourceController extends Controller
{
    public function index()
    {
        return OrderSource::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'index' => ['nullable', 'integer', 'min:0'],
        ]);

        $status = OrderSource::create($validatedData);

        return $status;
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
