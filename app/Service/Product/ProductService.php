<?php
namespace App\Service\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Models\Product\Product;

class ProductService extends Controller {
    public function store(StoreProductRequest $request, array $data): Product
    {
        $billets = $this->getArrForAttach($data['billets'], $data['billet_quantity'], 'quantity');
        $attributes = $this->getArrForAttach($data['attributes'], $data['attribute_value'], 'value');

        unset(
            $data['billets'],
            $data['attributes'],
            $data['billet_quantity'],
            $data['attribute_value'],
        );

        $product = Product::create([
            ...$data,
            'photo' => null,
            'user_id' => $request->user()->id,
        ]);

        $product->attributes()->attach($attributes);
        $product->billets()->attach($billets);
        $product->fresh();

        return $product->load(['category', 'attributes', 'billets']);
    }

    private function getArrForAttach(array $items, array $pivotValues, string $pivotKey) {
        $pivots = array_map( function($pivotValue) use ($pivotKey) {
            return [$pivotKey => $pivotValue];
        }, $pivotValues);
        return array_combine($items, $pivots);
    }
}
