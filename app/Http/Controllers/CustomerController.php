<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\IndexRequest;
use App\Http\Requests\Customer\StoreRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $service;

    public function __construct(CustomerService $service)
    {
        $this->service = $service;
    }

    public function index(IndexRequest $request)
    {
        $this->authorize('viewAny', Customer::class);
        return $this->service->index( $request->validated() );
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Customer::class);
        return $this->service->store( $request, $request->validated() );
    }

    public function show(int $id)
    {
        $this->authorize('view', Customer::class);
        return Customer::findOrFail($id);
    }

    public function update(UpdateRequest $request, int $id)
    {
        $this->authorize('update', Customer::class);
        return $this->service->update($request->validated(), $id);
    }

    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);
        $customer->delete();
        return response()->json([], 204);
    }

    public function getOrders(Customer $customer) {
        $this->authorize('view', $customer);
        return $customer->orders()
                    ->with(['status', 'coupon', 'paymentMethod', 'shippingMethod'])
                    ->get();
    }
}
