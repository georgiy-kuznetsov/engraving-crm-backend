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

    public function show(int $id)
    {
        $this->authorize('view', Provider::class);
        return Provider::findOrFail($id);
    }

    public function update(UpdateRequest $request, string $id)
    {
        $this->authorize('update', Provider::class);
        return $this->service->update( $request->validated(), $id );
    }

    public function destroy(int $id)
    {
        $this->authorize('delete', Provider::class);
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
