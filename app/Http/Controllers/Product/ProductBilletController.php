<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\BaseController;
use App\Models\Billet;
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
    
    public function store(Request $request, $productId, $billetId)
    {
        $product = Product::find($productId);
        if (! $product) {
            return $this->sendErrorResponse(['Product not found'], 404);
        };

        $billet = Billet::find($billetId);
        if (! $billet) {
            return $this->sendErrorResponse(['Billet not found'], 404);
        };

        $product->billets()->attach($billet);
        return $this->sendSuccessResponse([], 200);
    }

    public function destroy(Request $request, $productId, $billetId)
    {
        $product = Product::find($productId);
        if (! $product) {
            return $this->sendErrorResponse(['Product not found'], 404);
        };

        $billet = Billet::find($billetId);
        if (! $billet) {
            return $this->sendErrorResponse(['Billet not found'], 404);
        };

        $product->billets()->detach($billet);
        return $this->sendSuccessResponse([], 200);
    }
}
