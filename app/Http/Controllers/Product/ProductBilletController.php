<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\BaseController;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductBilletController extends BaseController
{
    public function index(Request $request, $productId)
    {
        $product = Product::find($productId);

        if (! $product) {
            return $this->sendErrorResponse(['Product not found'], 404);
        };

        $billets = $product->billets;

        return $this->sendSuccessResponse($billets, 200);
    }
    
    public function store(Request $request)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
