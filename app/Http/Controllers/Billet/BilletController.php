<?php

namespace App\Http\Controllers\Billet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Billet\StoreRequest;
use App\Http\Requests\Billet\UpdateRequest;
use App\Models\Billet;
use Illuminate\Http\Request;

class BilletController extends Controller
{
    public function index(Request $request)
    {
        $page = (int) $request->input('page') ?? 1;
        $pageSize = (int) $request->input('pageSize') ?? env('API_ITEMS_PER_PAGE');

        $billetItems = Billet::paginate($pageSize, ['*'], 'page', $page);

        return [
            'page' => $billetItems->currentPage(),
            'pageSize' => $billetItems->perPage(),
            'total' => $billetItems->total(),
            'items' => $billetItems->items(),
        ];
    }

    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();

        $billet = Billet::create([
            ...$validatedData,
            'user_id' => $request->user()->id,
            'photo' => null,
        ]);

        return response()->json($billet, 201);
    }

    public function show(string $id)
    {
        if ( ! $billet = Billet::find($id) ) {
            // return $this->sendErrorResponse(['Billet not found'], 404);
        };
        
        return $billet;
    }

    public function update(UpdateRequest $request, string $id)
    {
        if ( ! $billet = Billet::find($id) ) {
            // return $this->sendErrorResponse(['Billet not found'], 404);
        };

        $validatedData = $request->validated();

        $billet->update($validatedData);

        return $billet;
    }

    public function destroy(string $id)
    {
        if ( ! $billet = Billet::find($id) ) {
            return response()->json([], 200);
        };

        $billet->delete();
        return response()->json([], 200);
    }
}
