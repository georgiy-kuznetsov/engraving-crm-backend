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

        $data = [
            'page' => $billetItems->currentPage(),
            'pageSize' => $billetItems->perPage(),
            'total' => $billetItems->total(),
            'items' => $billetItems->items(),
            'success' => true,
            'statusCode' => 200,
        ];

        return $this->sendSuccessResponse($data, 200);
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
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'description' => $validatedData['description'],
            'sku' => $validatedData['sku'],
            'stock_quantity' => $validatedData['stock_quantity'],
            'provider_id' => $validatedData['provider_id'],
            'user_id' => $request->user()->id,
            'photo' => null,
        ]);

        return $this->sendSuccessResponse($billet, 201);
    }

    public function show(string $id)
    {
        $billet = Billet::find($id);

        if (!$billet) {
            return $this->sendErrorResponse(['Billet not found'], 404);
        };
        
        return $this->sendSuccessResponse($billet, 200);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
