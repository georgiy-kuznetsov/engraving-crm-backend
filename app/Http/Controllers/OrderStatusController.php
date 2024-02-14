<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    public function index()
    {
        $status = OrderStatus::all();
        return $status;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'index' => ['nullable', 'integer', 'min:0'],
        ]);

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
