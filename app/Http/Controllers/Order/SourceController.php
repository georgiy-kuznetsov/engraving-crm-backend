<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    public function index()
    {
        return Source::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'index' => ['nullable', 'integer', 'min:0'],
        ]);

        $status = Source::create($validatedData);

        return $status;
    }

    public function show(string $id)
    {
        return Source::findOrFail($id);
    }

    public function destroy(string $id)
    {
        if ( ! $source = Source::find($id) ) {
            return response()->json([], 204);
        };

        $source->delete();
        return response()->json([], 204);
    }

    public function getOrders(int $id)
    {
        return Source::findOrFail($id)->orders;
    }
}
