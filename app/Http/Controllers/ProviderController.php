<?php

namespace App\Http\Controllers;

use App\Http\Requests\Provider\StoreRequest;
use App\Http\Requests\Provider\UpdateRequest;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
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
        $validatedData = $request->validated();

        $userId = $request->user()->id;

        $provider = Provider::create([
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],

            'country' => $validatedData['country'],
            'region' => $validatedData['region'],
            'city' => $validatedData['city'],
            'adress' => $validatedData['adress'],
            'postcode' => $validatedData['postcode'],

            'store_link' => $validatedData['store_link'],
            'website' => $validatedData['website'],
            'telegram' => $validatedData['telegram'],
            'vkontakte' => $validatedData['vkontakte'],
            'instagram' => $validatedData['instagram'],

            'user_id' => $userId,
        ]);

        return $provider;
    }
    
    public function show(Request $request, string $id)
    {
        if (! $provider = Provider::find($id)) {
            // return $this->sendErrorResponse(['Provider not found'], 404);
        };
        return $provider;
    }
    
    public function update(UpdateRequest $request, string $id)
    {
        $validatedData = $request->validated();

        $provider = Provider::find($id);

        if (!$provider) {
            // return $this->sendErrorResponse(['Provider not found'], 404);
        };

        $provider->update($validatedData);

        return $provider;
    }
    
    public function destroy(string $id)
    {
        if ( ! $provider = Provider::find($id) ) {
            return response()->json([], 204);
        };

        $provider->delete();
        return response()->json([], 204);
    }
    
    public function getBillets(string $providerId) {
        if (! $provider = Provider::find($providerId)) {
            // return $this->sendErrorResponse(['Provider not found'], 404);
        };
    
        return $provider->billets()->get();
    }
}
