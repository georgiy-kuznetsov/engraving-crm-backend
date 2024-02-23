<?php
namespace App\Services;

use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\StoreRequest;
use App\Models\Provider;

class ProviderService extends Controller {
    public function index(array $data): array
    {
        $pageSize = $data['pageSize'] ?? env('API_ITEMS_PER_PAGE');
        $page = $data['page'] ?? 1;

        $userRole = auth()->user()->role->guard_name;
        if ( in_array($userRole, ['owner', 'admin', 'manager']) ) {
            $providers = Provider::orderBy('id')->paginate( $pageSize, ['*'], 'page', $page );
        }
        else {
            $providers = Provider::where('user_id', auth()->user()->id)->paginate( $pageSize, ['*'], 'page', $page );
        }


        return [
            'currentPage' => $providers->currentPage(),
            'lastPage' => $providers->lastPage(),
            'pageSize' => $providers->perPage(),
            'total' => $providers->total(),
            'items' => $providers->items(),
        ];
    }
    public function store(StoreRequest $request, array $data): Provider
    {
        return Provider::create([
            ...$data,
            'user_id' => $request->user()->id,
        ]);
    }

    public function update(array $data, Provider $provider): Provider
    {
        $provider->update($data);
        return $provider->fresh();
    }
}
