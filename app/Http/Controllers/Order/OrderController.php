<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreRequest;
use App\Http\Requests\Order\UpdateRequest;
use App\Models\Order\Order;
use App\Service\Order\StoreService;
use App\Service\Order\UpdateService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $storeService;
    protected $updateService;

    public function __construct(StoreService $storeService, UpdateService $updateService) {
        $this->storeService = $storeService;
        $this->updateService = $updateService;
    }

    public function index(Request $request)
    {
        $page = (int) $request->input('page') ?? 1;
        $pageSize = (int) $request->input('pageSize') ?? env('API_ITEMS_PER_PAGE');

        $orders = Order::with(['status', 'paymentStatus', 'coupon', 'paymentMethod', 'shippingMethod', 'customer', 'products', 'billets', 'source'])
                        ->paginate($pageSize, ['*'], 'page', $page);

        return [
            'page' => $orders->currentPage(),
            'pageSize' => $orders->perPage(),
            'total' => $orders->total(),
            'items' => $orders->items(),
        ];
    }

    public function store(StoreRequest $request)
    {
        return ($this->storeService)($request, $request->validated());
    }

    public function show(Request $request, string $id)
    {
        return Order::with(['status', 'paymentStatus', 'coupon', 'paymentMethod', 'shippingMethod', 'customer', 'products', 'billets', 'source'])
                    ->findOrFail($id);
    }

    public function update(UpdateRequest $request, int $id)
    {
        return ($this->updateService)($request, $request->validated(), $id);
    }

    public function destroy(string $id)
    {
        if ( ! $order = Order::find($id) ) {
            return response()->json([], 204);
        };

        $order->delete();
        return response()->json([], 204);
    }
}
