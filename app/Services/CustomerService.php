<?php
namespace App\Services;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreRequest;
use App\Models\Customer;

class CustomerService extends Controller {
    public function store(StoreRequest $request, array $data): Customer
    {
        return Customer::create([
            ...$data,
            'user_id' => $request->user()->id,
            'is_banned' => false,
            'is_regular' => false,
        ]);
    }

    public function update(array $data, int $id): Customer
    {
        $customer = Customer::findOrFail($id);
        $customer->update($data);
        return $customer;
    }
}
