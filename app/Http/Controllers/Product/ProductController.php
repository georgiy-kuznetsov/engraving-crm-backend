<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        
        $page = (int) $request->input('page') ?? 1;
        $pageSize = (int) $request->input('pageSize') ?? env('API_ITEMS_PER_PAGE');

        $productItems = Product::with('category')->paginate($pageSize, ['*'], 'page', $page);

        return [
            'page' => $productItems->currentPage(),
            'pageSize' => $productItems->perPage(),
            'total' => $productItems->total(),
            'items' => $productItems->items(),
        ];
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
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'onsale' => ['required', 'boolean'],
        ]);

        $product = Product::create([
            ...$validatedData,
            'photo' => null,
            'user_id' => $request->user()->id,
        ]);

        return $product;
    }

    public function show(string $id)
    {
        $product = Product::with('category')->find($id);
        
        return $product;
    }

    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return $this->sendErrorResponse(['Billet not found'], 404);
        };

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'decimal:2', 'max:99999999.99'],
            'sale_price' => ['nullable', 'decimal:2', 'max:99999999.99'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'sku' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'onsale' => ['required', 'boolean'],
        ]);

        $product->update($validatedData);

        return $product;
    }

    public function destroy(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([], 204);
        };

        $product->delete();
        return response()->json([], 204);
    }
}
