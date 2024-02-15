<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\StoreRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $page = (int) $request->input('page') ?? 1;
        $pageSize = (int) $request->input('pageSize') ?? env('API_ITEMS_PER_PAGE');

        $customerItems = Customer::paginate($pageSize, ['*'], 'page', $page);

        return [
            'page' => $customerItems->currentPage(),
            'pageSize' => $customerItems->perPage(),
            'total' => $customerItems->total(),
            'items' => $customerItems->items(),
        ];
    }

    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();

        $customer = Customer::create([
            ...$validatedData,
            'user_id' => $request->user()->id,
            'is_banned' => false,
            'is_regular' => false,
        ]);

        return $customer;
    }

    public function show(string $id)
    {
        if (! $customer = Customer::find($id)) {
            // return $this->sendErrorResponse(['Customer not found'], 404);
        };
        return $customer;
    }

    public function update(UpdateRequest $request, string $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            // return $this->sendErrorResponse(['Customer not found'], 404);
        };

        $validatedData = $request->validated();

        $customer->update($validatedData);

        return $customer;
    }

    public function destroy(string $customerId)
    {
        if ( ! $customer = Customer::find($customerId) ) {
            return response()->json([], 204);
        };

        $customer->delete();
        return response()->json([], 204);
    }

    public function getOrders(int $id) {
        if (! $customer = Customer::find($id)) {
            // return $this->sendErrorResponse(['Customer not found'], 404);
        };

        $orders = $customer->orders()
                    ->with(['status', 'coupon', 'paymentMethod', 'shippingMethod'])
                    ->get();

        return $orders;
    }
}
