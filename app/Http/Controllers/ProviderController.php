<?php

namespace App\Http\Controllers;

use App\Http\Requests\Provider\StoreRequest;
use App\Http\Requests\Provider\UpdateRequest;
use App\Models\Provider;
use App\Services\ProviderService;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    protected $service;

    public function __construct(ProviderService $service) {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $pageSize = (int) $request->input('pageSize') ?? env('API_ITEMS_PER_PAGE');
        $page = (int) $request->input('page') ?? 1;

        $providers = Provider::orderBy('id')->paginate( $pageSize, ['*'], 'page', $page );

        return [
            'currentPage' => $providers->currentPage(),
            'lastPage' => $providers->lastPage(),
            'pageSize' => $providers->perPage(),
            'total' => $providers->total(),
            'items' => $providers->items(),
        ];
    }

    public function store(StoreRequest $request)
    {
        return $this->service->store( $request, $request->validated() );
    }

    public function show(int $id)
    {
        return Provider::findOrFail($id);
    }

    public function update(UpdateRequest $request, string $id)
    {
        return $this->service->update( $request->validated(), $id );
    }

    public function destroy(int $id)
    {
        if ( $provider = Provider::find($id) ) {
            $provider->delete();
        };
        return response()->json([], 204);
    }

    public function getBillets(int $providerId) {
        $provider = Provider::findOrFail($providerId);
        return $provider->billets()->get();
    }
}
