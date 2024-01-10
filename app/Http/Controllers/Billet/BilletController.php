<?php

namespace App\Http\Controllers\Billet;

use App\Http\Controllers\Controller;
use App\Models\Billet;
use Illuminate\Http\Request;

class BilletController extends Controller
{
    public function index(Request $request)
    {
        $page = (int) $request->input('page') ?? 1;
        $pageSize = (int) $request->input('pageSize') ?? env('API_ITEMS_PER_PAGE');

        $billetItems = Billet::paginate($pageSize, ['*'], 'page', $page);

        $data = [
            'page' => $billetItems->currentPage(),
            'pageSize' => $billetItems->perPage(),
            'total' => $billetItems->total(),
            'items' => $billetItems->items(),
            'success' => true,
            'statusCode' => 200,
        ];

        return response()->json($data, 200);
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
