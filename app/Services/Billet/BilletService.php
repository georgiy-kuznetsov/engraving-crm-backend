<?php
namespace App\Services\Billet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Billet\StoreRequest;
use App\Models\Billet;

class BilletService extends Controller {
    public function store(StoreRequest $request, array $data): Billet
    {
        return Billet::firstOrCreate([
            ...$data,
            'user_id' => $request->user()->id,
            'photo' => null,
        ]);
    }

    public function update(array $data, int $id): Billet
    {
        $billet = Billet::findOrFail($id);
        return $billet->update($data);
    }


}
