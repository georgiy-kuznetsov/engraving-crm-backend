<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\BaseController;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function index(Request $request)
    {
        
        $page = (int) $request->input('page') ?? 1;
        $pageSize = (int) $request->input('pageSize') ?? env('API_ITEMS_PER_PAGE');

        $productItems = Product::paginate($pageSize, ['*'], 'page', $page);

        $data = [
            'page' => $productItems->currentPage(),
            'pageSize' => $productItems->perPage(),
            'total' => $productItems->total(),
            'items' => $productItems->items(),
        ];

        return $this->sendSuccessResponse($data, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'decimal:2', 'max:99999999.99'],
            'sale_price' => ['nullable', 'decimal:2', 'max:99999999.99'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'sku' => ['nullable', 'string', 'max:255'],
            'onsale' => ['required', 'boolean'],
        ]);

        $billet = Product::create([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'sale_price' => $validatedData['sale_price'],
            'short_description' => $validatedData['short_description'],
            'description' => $validatedData['description'],
            'sku' => $validatedData['sku'],
            'onsale' => $validatedData['onsale'],
            'photo' => null,
            'user_id' => $request->user()->id,
        ]);

        return $this->sendSuccessResponse($billet, 201);
    }

    public function show(string $id)
    {
        //
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
