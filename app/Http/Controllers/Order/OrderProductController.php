<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\BaseController;
use App\Models\Order\Order;
use App\Models\Product\Product;
use Illuminate\Http\Request;

class OrderProductController extends BaseController
{
    public function index(Request $request, int $orderId)
    {
        if (! $order = Order::find($orderId) ) {
            return $this->sendErrorResponse(['Order not found'], 404);
        };

        $products = $order->products;

        return $this->sendSuccessResponse($products, 200);
    }

    public function store(Request $request, int $orderId, int $productId)
    {
        if ( ! $order = Order::find($orderId) ) {
            return $this->sendErrorResponse(['Order not found'], 404);
        };
        
        if ( ! $product = Product::find($productId) ) {
            return $this->sendErrorResponse(['Product not found'], 404);
        };

        if ( $order->products->contains($productId) ) {
            return $this->sendErrorResponse(['Product already exists'], 409);
        };

        $validatedData = $request->validate([
            'quantity' => ['required', 'integer', 'max:255'],
        ]);

        $salePrice = ($product->onsale)
                        ? $product->sale_price
                        : null;

        $actualPrice = $salePrice ?? $product->price;

        $productData = [
            ...$validatedData,
            'name' => $product->name,
            'photo' => $product->photo,
            'price' => $product->price,
            'sale_price' => $salePrice,
            'amount' => $validatedData['quantity'] * $actualPrice,
        ];

        $order->products()->attach($product, $productData);
        return $this->sendSuccessResponse([], 200);
    }

    public function update(Request $request, int $orderId, int $productId)
    {
        if ( ! $order = Order::find($orderId) ) {
            return $this->sendErrorResponse(['Order not found'], 404);
        };

        if ( ! $order->products->contains($productId) ) {
            return $this->sendErrorResponse(['Product does not already exists'], 404);
        };

        $product = $order->products()->where('products.id', $productId)->first();

        $validatedData = $request->validate([
            'quantity' => ['required', 'integer', 'max:255'],
        ]);

        $actualPrice = $product->sale_price ?? $product->price;

        $productData = [
            ...$validatedData,
            'amount' => $validatedData['quantity'] * $actualPrice,
        ];

        $order->products()->updateExistingPivot($product->id, $productData);
        return $this->sendSuccessResponse([], 200);
    }

    public function destroy(int $orderId, int $productId)
    {
        if (! $order = Order::find($orderId)) {
            return $this->sendErrorResponse(['Order not found'], 404);
        };
        
        $product = Product::find($productId);
        if (! $product) {
            return $this->sendErrorResponse(['Product not found'], 404);
        };

        $order->products()->detach($product);
        return $this->sendSuccessResponse([], 204);
    }
}
