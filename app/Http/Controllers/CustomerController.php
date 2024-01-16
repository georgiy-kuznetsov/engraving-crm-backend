<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends BaseController
{
    public function index(Request $request)
    {
        $page = (int) $request->input('page') ?? 1;
        $pageSize = (int) $request->input('pageSize') ?? env('API_ITEMS_PER_PAGE');

        $customerItems = Customer::paginate($pageSize, ['*'], 'page', $page);

        return $this->sendSuccessResponse([
            'page' => $customerItems->currentPage(),
            'pageSize' => $customerItems->perPage(),
            'total' => $customerItems->total(),
            'items' => $customerItems->items(),
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'unique:customers', 'max:100'],
            'phone' => ['nullable', 'string', 'max:255'],
            
            'country' => ['nullable', 'string', 'max:255'],
            'region' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'adress' => ['nullable', 'string', 'max:255'],
            'postcode' => ['nullable', 'string', 'max:20'],

            'website' => ['nullable', 'string', 'unique:providers', 'max:256'],
            'telegram' => ['nullable', 'string', 'unique:providers', 'max:256'],
            'vkontakte' => ['nullable', 'string', 'unique:providers', 'max:256'],
            'instagram' => ['nullable', 'string', 'unique:providers', 'max:256'],
            'whatsapp' => ['nullable', 'string', 'unique:providers', 'max:256'],
        ]);

        $customer = Customer::create([
            ...$validatedData,
            'user_id' => $request->user()->id,
            'is_banned' => false,
            'is_regular' => false,
        ]);

        return $this->sendSuccessResponse($customer, 201);
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
