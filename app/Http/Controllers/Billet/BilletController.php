<?php

namespace App\Http\Controllers\Billet;

use App\Http\Controllers\BaseController;
use App\Models\Billet;
use Illuminate\Http\Request;

class BilletController extends BaseController
{
    public function index(Request $request)
    {
        $page = (int) $request->input('page') ?? 1;
        $pageSize = (int) $request->input('pageSize') ?? env('API_ITEMS_PER_PAGE');

        $billetItems = Billet::paginate($pageSize, ['*'], 'page', $page);

        return $this->sendSuccessResponse([
            'page' => $billetItems->currentPage(),
            'pageSize' => $billetItems->perPage(),
            'total' => $billetItems->total(),
            'items' => $billetItems->items(),
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'decimal:2', 'max:99999999.99'],
            'description' => ['nullable', 'string'],
            'sku' => ['nullable', 'string', 'max:255'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'provider_id' => ['nullable', 'integer', 'exists:providers,id'],
        ]);

        $billet = Billet::create([
            ...$validatedData,
            'user_id' => $request->user()->id,
            'photo' => null,
        ]);

        return $this->sendSuccessResponse($billet, 201);
    }

    public function show(string $id)
    {
        if ( ! $billet = Billet::find($id) ) {
            return $this->sendErrorResponse(['Billet not found'], 404);
        };
        
        return $this->sendSuccessResponse($billet, 200);
    }

    public function update(Request $request, string $id)
    {
        if ( ! $billet = Billet::find($id) ) {
            return $this->sendErrorResponse(['Billet not found'], 404);
        };

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'decimal:2', 'max:99999999.99'],
            'description' => ['nullable', 'string'],
            'sku' => ['nullable', 'string', 'max:255'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'provider_id' => ['nullable', 'integer', 'exists:providers,id'],
        ]);

        $billet->update($validatedData);

        return $this->sendSuccessResponse($billet, 200);
    }

    public function destroy(string $id)
    {
        if ( ! $billet = Billet::find($id) ) {
            return $this->sendSuccessResponse([], 204);
        };

        $billet->delete();
        return $this->sendSuccessResponse([], 204);
    }
}
