<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\BaseController;
use App\Models\Billet;
use App\Models\Order\Order;
use Illuminate\Http\Request;

class OrderBilletController extends BaseController
{
    public function index(int $orderId)
    {
        if (! $order = Order::find($orderId) ) {
            // return $this->sendErrorResponse(['Order not found'], 404);
        };
        return $order->billets;
    }

    public function store(Request $request, int $orderId, int $billetId)
    {
        if ( ! $order = Order::find($orderId) ) {
            // return $this->sendErrorResponse(['Order not found'], 404);
        };
        
        if ( ! $billet = Billet::find($billetId) ) {
            // return $this->sendErrorResponse(['Billet not found'], 404);
        };

        if ( $order->billets->contains($billet) ) {
            // return $this->sendErrorResponse(['Billet already exists'], 409);
        };

        $validatedData = $request->validate([
            'quantity' => ['required', 'integer', 'max:255'],
        ]);

        $billetData = [
            ...$validatedData,
            'name' => $billet->name,
            'price' => $billet->price,
            'photo' => $billet->photo,
            'total_amount' => $validatedData['quantity'] * $billet->price,
        ];

        $order->billets()->attach($billet, $billetData);
        return response()->json([], 200);
    }

    public function update(Request $request, int $orderId, int $billetId)
    {
        if ( ! $order = Order::find($orderId) ) {
            // return $this->sendErrorResponse(['Order not found'], 404);
        };

        if ( ! $order->billets->contains($billetId) ) {
            // return $this->sendErrorResponse(['Billet does not already exists'], 404);
        };

        $billet = $order->billets()->where('billets.id', $billetId)->first();

        $validatedData = $request->validate([
            'quantity' => ['required', 'integer', 'max:255'],
        ]);

        $billetData = [
            ...$validatedData,
            'total_amount' => $validatedData['quantity'] * $billet->price,
        ];

        $order->billets()->updateExistingPivot($billet->id, $billetData);
        return [];
    }

    public function destroy(int $orderId, int $billetId)
    {
        if (! $order = Order::find($orderId)) {
            // return $this->sendErrorResponse(['Order not found'], 404);
        };
        
        $billet = Billet::find($billetId);
        if (! $billet) {
            // return $this->sendErrorResponse(['Billet not found'], 404);
        };

        $order->billets()->detach($billet);
        return response()->json([], 204);
    }
}
