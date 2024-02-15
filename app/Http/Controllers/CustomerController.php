<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\StoreRequest;
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

    public function update(Request $request, string $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            // return $this->sendErrorResponse(['Customer not found'], 404);
        };

        $validatedData = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255', 'unique:customers,phone,' . $customer->id, 'max:100'],
            'email' => ['required', 'string', 'email', 'unique:customers,email,' . $customer->id, 'max:100'],

            'country' => ['nullable', 'string', 'max:255'],
            'region' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'adress' => ['nullable', 'string', 'max:255'],
            'postcode' => ['nullable', 'string', 'max:20'],

            'store_link' => ['nullable', 'string'],
            'website' => ['nullable', 'string', 'unique:customers,website,' . $customer->id, 'max:255'],
            'telegram' => ['nullable', 'string', 'unique:customers,telegram,' . $customer->id, 'max:255'],
            'vkontakte' => ['nullable', 'string', 'unique:customers,vkontakte,' . $customer->id, 'max:255'],
            'instagram' => ['nullable', 'string', 'unique:customers,instagram,' . $customer->id, 'max:255'],
        ]);

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
