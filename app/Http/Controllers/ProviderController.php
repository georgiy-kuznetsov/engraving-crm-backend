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
        $this->authorize('viewAny', Provider::class);

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
        $this->authorize('create', Provider::class);
        return $this->service->store( $request, $request->validated() );
    }

    public function show(Provider $provider)
    {
        $this->authorize('view', $provider);
        return $provider;
    }

    public function update(UpdateRequest $request, Provider $provider)
    {
        $this->authorize('update', $provider);
        return $this->service->update( $request->validated(), $provider );
    }

    public function destroy(Provider $provider)
    {
        $this->authorize('delete', $provider);
        $provider->delete();
        return response()->json([], 204);
    }

    public function getBillets(int $id) {
        $provider = Provider::findOrFail($id);

        $this->authorize('view', $provider);

        return $provider->billets()->get();
    }
}
