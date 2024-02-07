<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index()
    {
        $status = Status::all();
        return $status;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'index' => ['nullable', 'integer', 'min:0'],
        ]);

        $status = Status::create($validatedData);

        return $status;
    }

    public function show(string $id)
    {
        if (! $status = Status::find($id)) {
            // return $this->sendErrorResponse(['Status not found'], 404);
        };
        return $status;
    }

    public function destroy(string $id)
    {
        if ( ! $status = Status::find($id) ) {
            return response()->json([], 204);
        };

        $status->delete();
        return response()->json([], 204);
    }
}
