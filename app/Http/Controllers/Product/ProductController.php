<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product\Product;
use App\Service\Product\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $service;

    public function __construct(ProductService $service) {
        $this->service = $service;
    }

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
        return $this->service->store($request, $request->validated());
    }

    public function show(string $id)
    {
        return Product::with(['category', 'attributes', 'billets'])->findOrFail($id);
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        $validatedData = $request->validated();

        $product = Product::with(['category', 'attributes', 'billets'])->findOrFail($id);

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
