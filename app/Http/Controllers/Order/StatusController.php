<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\BaseController;
use App\Models\Order\Status;
use Illuminate\Http\Request;

class StatusController extends BaseController
{
    public function index()
    {
        $status = Status::all();
        return $this->sendSuccessResponse($status, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'index' => ['nullable', 'integer', 'min:0'],
        ]);

        $status = Status::create($validatedData);

        return $this->sendSuccessResponse($status, 200);
    }

    public function show(string $id)
    {
        if (! $status = Status::find($id)) {
            return $this->sendErrorResponse(['Status not found'], 404);
        };
        return $this->sendSuccessResponse($status, 200);
    }

    public function destroy(string $id)
    {
        if ( ! $status = Status::find($id) ) {
            return $this->sendSuccessResponse([], 204);
        };

        $status->delete();
        return $this->sendSuccessResponse([], 204);
    }
}