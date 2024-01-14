<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends BaseController
{
    public function index(Request $request)
    {
        $pageSize = (int) $request->input('pageSize') ?? env('API_ITEMS_PER_PAGE');
        $page = (int) $request->input('page') ?? 1;

        $providers = Provider::orderBy('id')->paginate( $pageSize, ['*'], 'page', $page );

        return $this->sendSuccessResponse([
            'currentPage' => $providers->currentPage(),
            'lastPage' => $providers->lastPage(),
            'pageSize' => $providers->perPage(),
            'total' => $providers->total(),
            'items' => $providers->items(),
        ], 200);
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:providers'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:providers'],

            'country' => ['nullable', 'string', 'max:255'],
            'region' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'adress' => ['nullable', 'string', 'max:255'],
            'postcode' => ['nullable', 'int', 'max:100'],

            'store_link' => ['nullable', 'string'],
            'website' => ['nullable', 'string', 'unique:providers', 'max:256'],
            'telegram' => ['nullable', 'string', 'unique:providers', 'max:256'],
            'vkontakte' => ['nullable', 'string', 'unique:providers', 'max:256'],
            'instagram' => ['nullable', 'string', 'unique:providers', 'max:256'],
        ]);

        $userId = $request->user()->id;

        $user = Provider::create([
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

        return $this->sendSuccessResponse($user, 200);
    }
    
    public function show(Request $request, string $id)
    {
        if (! $provider = Provider::find($id)) {
            return $this->sendErrorResponse(['Provider not found'], 404);
        };
        return $this->sendSuccessResponse($provider, 200);
    }
    
    public function update(Request $request, string $id)
    {
        $provider = Provider::find($id);

        if (!$provider) {
            return $this->sendErrorResponse(['Provider not found'], 404);
        };

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:providers'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:providers'],

            'country' => ['nullable', 'string', 'max:255'],
            'region' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'adress' => ['nullable', 'string', 'max:255'],
            'postcode' => ['nullable', 'int', 'max:100'],

            'store_link' => ['nullable', 'string'],
            'website' => ['nullable', 'string', 'unique:providers', 'max:256'],
            'telegram' => ['nullable', 'string', 'unique:providers', 'max:256'],
            'vkontakte' => ['nullable', 'string', 'unique:providers', 'max:256'],
            'instagram' => ['nullable', 'string', 'unique:providers', 'max:256'],
        ]);

        $provider->update($validatedData);

        return $this->sendSuccessResponse($provider, 200);
    }
    
    public function destroy(string $id)
    {
        if ( ! $provider = Provider::find($id) ) {
            return $this->sendSuccessResponse([], 204);
        };

        $provider->delete();
        return $this->sendSuccessResponse([], 204);
    }
    
    public function getBillets(string $providerId) {
        if (! $provider = Provider::find($providerId)) {
            return $this->sendErrorResponse(['Provider not found'], 404);
        };
    
        return $this->sendSuccessResponse( $provider->billets()->get(), 200 );
    }
}
