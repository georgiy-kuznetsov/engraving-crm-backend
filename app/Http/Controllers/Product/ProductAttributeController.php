<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Product\Attribute;
use App\Models\Product\Product;
use Illuminate\Http\Request;

class ProductAttributeController extends BaseController
{
    public function index(Request $request, $productId)
    {
        if (! $product = Product::find($productId)) {
            return $this->sendErrorResponse(['Product not found'], 404);
        };
        $attributes = $product->attributes;
        return $this->sendSuccessResponse($attributes, 200);
    }
    
    public function store(Request $request, $productId, $attributeId)
    {
        if ( ! $product = Product::find($productId) ) {
            return $this->sendErrorResponse(['Product not found'], 404);
        };

        if ( ! $attribute = Attribute::find($attributeId) ) {
            return $this->sendErrorResponse(['Attribute not found'], 404);
        };

        if ( $product->attributes->contains($attributeId) ) {
            return $this->sendErrorResponse(['Attribute already exists'], 409);
        };

        $validatedData = $request->validate([
            'value' => ['required', 'numeric', 'max:255'],
        ]);

        $product->attributes()->attach($attribute, ['value' => $validatedData['value']]);
        return $this->sendSuccessResponse([], 200);
    }

    public function destroy(Request $request, $productId, $attributeId)
    {
        if ( ! $product = Product::find($productId) ) {
            return $this->sendErrorResponse(['Product not found'], 404);
        };

        if ( ! $attribute = Attribute::find($attributeId) ) {
            return $this->sendErrorResponse(['Attribute not found'], 404);
        };

        $product->attributes()->detach($attribute);
        return $this->sendSuccessResponse([], 200);
    }
}
