<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\BaseController;
use App\Models\Order\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public function index(Request $request)
    {
        $page = (int) $request->input('page') ?? 1;
        $pageSize = (int) $request->input('pageSize') ?? env('API_ITEMS_PER_PAGE');

        $orders = Order::with(['status', 'coupon', 'paymentMethod', 'shippingMethod'])
                        ->paginate($pageSize, ['*'], 'page', $page);

        return $this->sendSuccessResponse([
            'page' => $orders->currentPage(),
            'pageSize' => $orders->perPage(),
            'total' => $orders->total(),
            'items' => $orders->items(),
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'number' => ['nullable', 'string', 'max:255', 'unique:orders'],
            'price_amount' => ['required', 'decimal:2', 'max:99999999.99'],
            'discount_amount' => ['required', 'decimal:2', 'max:99999999.99'],
            'shipping_amount' => ['required', 'decimal:2', 'max:99999999.99'],
            'gratuity_amount' => ['required', 'decimal:2', 'max:99999999.99'],

            'coupon_id' => ['nullable', 'integer', 'exists:coupons,id'],
            'shipping_method_id' => ['nullable', 'integer', 'exists:shipping_methods,id'],
            'payment_method_id' => ['nullable', 'integer', 'exists:payment_methods,id'],
            'status_id' => ['nullable', 'integer', 'exists:order_statuses,id'],
            'customer_id' => ['nullable', 'integer', 'exists:customers,id'],
        ]);

        $discountPrice = $validatedData['price_amount'] - $validatedData['discount_amount'];
        $totalAmount = $discountPrice + $validatedData['shipping_amount'] + $validatedData['gratuity_amount'];
        
        $order = Order::create([
            ...$validatedData,
            $totalAmount,
        ]);

        if ( ! $order->number) {
            $order->number = $order->getNumber();
            $order->save();
        }

        return $this->sendSuccessResponse($order, 201);
    }

    public function show(Request $request, string $id)
    {
        $order = Order::with(['status', 'coupon', 'paymentMethod', 'shippingMethod'])
                        ->find($id);
        if (! $order ) {
            return $this->sendErrorResponse(['Order not found'], 404);
        };
        return $this->sendSuccessResponse($order, 200);
    }

    public function update(Request $request, string $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return $this->sendErrorResponse(['Order not found'], 404);
        };

        $validatedData = $request->validate([
            'price_amount' => ['required', 'decimal:2', 'min: 0.00', 'max:99999999.99'],
            'discount_amount' => ['required', 'decimal:2', 'min: 0.00', 'max:99999999.99'],
            'shipping_amount' => ['required', 'decimal:2', 'min: 0.00', 'max:99999999.99'],
            'gratuity_amount' => ['required', 'decimal:2', 'min: 0.00', 'max:99999999.99'],

            'coupon_id' => ['nullable', 'integer', 'exists:coupons,id'],
            'shipping_method_id' => ['nullable', 'integer', 'exists:shipping_methods,id'],
            'payment_method_id' => ['nullable', 'integer', 'exists:payment_methods,id'],
            'status_id' => ['nullable', 'integer', 'exists:order_statuses,id'],
            'customer_id' => ['nullable', 'integer', 'exists:customers,id'],
        ]);

        $discountPrice = $validatedData['price_amount'] - $validatedData['discount_amount'];
        $totalAmount = $discountPrice + $validatedData['shipping_amount'] + $validatedData['gratuity_amount'];
        
        $order->update([
            ...$validatedData,
            'total_amount' => $totalAmount,
        ]);
        
        return $this->sendSuccessResponse($order, 200);
    }

    public function destroy(string $id)
    {
        if ( ! $order = Order::find($id) ) {
            return $this->sendSuccessResponse([], 204);
        };

        $order->delete();
        return $this->sendSuccessResponse([], 204);
    }
}
