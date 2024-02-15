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

    public function show(int $id)
    {
        return Customer::findOrFail($id);
    }

    public function update(UpdateRequest $request, int $id)
    {
        $customer = Customer::findOrFail($id);

        $validatedData = $request->validated();

        $customer->update($validatedData);

        return $customer;
    }

    public function destroy(int $customerId)
    {
        if ( ! $customer = Customer::find($customerId) ) {
            return response()->json([], 204);
        };

        $customer->delete();
        return response()->json([], 204);
    }

    public function getOrders(int $id) {
        $customer = Customer::findOrFail($id);

        $orders = $customer->orders()
                    ->with(['status', 'coupon', 'paymentMethod', 'shippingMethod'])
                    ->get();

        return $orders;
    }
}
