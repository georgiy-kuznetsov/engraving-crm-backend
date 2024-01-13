<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\BaseController;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function index(Request $request)
    {
        
        $page = (int) $request->input('page') ?? 1;
        $pageSize = (int) $request->input('pageSize') ?? env('API_ITEMS_PER_PAGE');

        $productItems = Product::paginate($pageSize, ['*'], 'page', $page);

        $data = [
            'page' => $productItems->currentPage(),
            'pageSize' => $productItems->perPage(),
            'total' => $productItems->total(),
            'items' => $productItems->items(),
        ];

        return $this->sendSuccessResponse($data, 200);
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
