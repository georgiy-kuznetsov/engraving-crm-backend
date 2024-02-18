<?php

namespace App\Http\Controllers\Billet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Billet\StoreRequest;
use App\Http\Requests\Billet\UpdateRequest;
use App\Models\Billet;
use App\Service\Billet\BilletService;
use Illuminate\Http\Request;

class BilletController extends Controller
{
    protected $service;

    public function __construct(BilletService $service) {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $page = (int) $request->input('page') ?? 1;
        $pageSize = (int) $request->input('pageSize') ?? env('API_ITEMS_PER_PAGE');

        $billetItems = Billet::paginate($pageSize, ['*'], 'page', $page);

        return [
            'page' => $billetItems->currentPage(),
            'pageSize' => $billetItems->perPage(),
            'total' => $billetItems->total(),
            'items' => $billetItems->items(),
        ];
    }

    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();
        return $this->service->store($request, $validatedData);
    }

    public function show(string $id)
    {
        return Billet::findOrFail($id);
    }

    public function update(UpdateRequest $request, int $id)
    {
        $validatedData = $request->validated();
        return $this->service->update($validatedData, $id);
    }

    public function destroy(string $id)
    {
        if ( ! $billet = Billet::find($id) ) {
            return response()->json([], 200);
        };

        $billet->delete();
        return response()->json([], 200);
    }
}
