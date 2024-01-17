<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public function index(Request $request)
    {
        $page = (int) $request->input('page') ?? 1;
        $pageSize = (int) $request->input('pageSize') ?? env('API_ITEMS_PER_PAGE');

        $orders = Order::paginate($pageSize, ['*'], 'page', $page);

        return $this->sendSuccessResponse([
            'page' => $orders->currentPage(),
            'pageSize' => $orders->perPage(),
            'total' => $orders->total(),
            'items' => $orders->items(),
        ], 200);
    }

    public function store(Request $request)
    {
        //
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
