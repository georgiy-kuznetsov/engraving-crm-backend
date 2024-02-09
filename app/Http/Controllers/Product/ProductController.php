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

        $productList = Product::with(['category', 'attributes', 'billets'])->paginate($pageSize, ['*'], 'page', $page);

        return [
            'page' => $productList->currentPage(),
            'pageSize' => $productList->perPage(),
            'total' => $productList->total(),
            'items' => $productList->items(),
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

            'billets' => ['nullable', 'array'],
            'billets.*' => ['required', 'integer', 'exists:billets,id'],
            'billet_quantity' => ['nullable', 'array'],
            'billet_quantity.*' => ['required', 'integer'],

            'attributes' => ['nullable', 'array'],
            'attributes.*' => ['required', 'integer', 'exists:attributes,id'],
            'attribute_value' => ['nullable', 'array'],
            'attribute_value.*' => ['required', 'decimal:2', 'max:99999999.99'],
        ]);

        $billets = getArrForAttach($validatedData['billets'], $validatedData['billet_quantity'], 'quantity');
        $attributes = getArrForAttach($validatedData['attributes'], $validatedData['attribute_value'], 'value');

        unset(
            $validatedData['billets'], 
            $validatedData['attributes'],
            $validatedData['billet_quantity'],
            $validatedData['attribute_value'],
        );
        
        $product = Product::create([
            ...$validatedData,
            'photo' => null,
            'user_id' => $request->user()->id,
        ]);

        $product->attributes()->attach($attributes);
        $product->billets()->attach($billets);
        $product->fresh();

        return response()->json(
            $product->load(['category', 'attributes', 'billets'])
        );
    }

    public function show(string $id)
    {
        $product = Product::with(['category', 'attributes', 'billets'])->find($id);
        
        return $product;
    }

    public function update(Request $request, string $id)
    {
        $product = Product::with(['category', 'attributes', 'billets'])->find($id);

        if (!$product) {
            // return $this->sendErrorResponse(['Billet not found'], 404);
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

            'billets' => ['nullable', 'array'],
            'billets.*' => ['required', 'integer', 'exists:products,id'],
            'billet_quantity' => ['nullable', 'array'],
            'billet_quantity.*' => ['required', 'integer'],

            'attributes' => ['nullable', 'array'],
            'attributes.*' => ['required', 'integer', 'exists:attributes,id'],
            'attribute_value' => ['nullable', 'array'],
            'attribute_value.*' => ['required', 'decimal:2', 'max:99999999.99'],
        ]);

        $billets = getArrForAttach($validatedData['billets'], $validatedData['billet_quantity'], 'quantity');
        $attributes = getArrForAttach($validatedData['attributes'], $validatedData['attribute_value'], 'value');

        unset(
            $validatedData['billets'], 
            $validatedData['attributes'],
            $validatedData['billet_quantity'],
            $validatedData['attribute_value'],
        );
        
        $product->update($validatedData);

        $product->attributes()->attach($attributes);
        $product->billets()->attach($billets);
        $product->fresh();

        return response()->json( 
            $product->load(['category', 'attributes', 'billets']) 
        );
    }

    public function destroy(string $id)
    {
        if (!$product = Product::find($id)) {
            return response()->json([], 204);
        };

        $product->delete();
        return response()->json([], 204);
    }
}

function getArrForAttach(array $items, array $pivotValues, string $pivotKey) {
    $pivots = array_map( function($pivotValue) use ($pivotKey) {
        return [$pivotKey => $pivotValue];
    }, $pivotValues);
    return array_combine($items, $pivots);
}
