<?php
namespace App\Services;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreRequest;
use App\Models\Customer;

class CustomerService extends Controller {
    public function index(array $data): array
    {
        $page = $data['page'] ?? 1;
        $pageSize = $data['pageSize'] ?? env('API_ITEMS_PER_PAGE');

        $customerItems = Customer::paginate($pageSize, ['*'], 'page', $page);

        return [
            'page' => $customerItems->currentPage(),
            'pageSize' => $customerItems->perPage(),
            'total' => $customerItems->total(),
            'items' => $customerItems->items(),
        ];
    }

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
