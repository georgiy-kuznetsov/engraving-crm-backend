<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
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

    public function store(StoreProductRequest $request)
    {
        $validatedData = $request->validated();

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

    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::with(['category', 'attributes', 'billets'])->find($id);

        if (!$product) {
            // return $this->sendErrorResponse(['Billet not found'], 404);
        };

        $validatedData = $request->validated();

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
