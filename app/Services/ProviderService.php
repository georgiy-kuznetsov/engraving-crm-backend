<?php
namespace App\Services;

use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\StoreRequest;
use App\Http\Requests\Provider\UpdateRequest;
use App\Models\Provider;

class ProviderService extends Controller {
    public function store(StoreRequest $request, array $data): Provider
    {
        return Provider::create([
            ...$data,
            'user_id' => $request->user()->id,
        ]);
    }

    public function update(array $data, int $id): Provider
    {
        $provider = Provider::findOrFail($id);
        $provider->update($data);
        return $provider->fresh();
    }
}
