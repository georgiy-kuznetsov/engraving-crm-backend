<?php
namespace App\Services\Billet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Billet\StoreRequest;
use App\Models\Billet;

class BilletService extends Controller {
    public function index(array $data): array
    {
        $page = $data['page'] ?? 1;
        $pageSize = $data['pageSize'] ?? env('API_ITEMS_PER_PAGE');

        $billetItems = Billet::paginate($pageSize, ['*'], 'page', $page);

        return [
            'page' => $billetItems->currentPage(),
            'pageSize' => $billetItems->perPage(),
            'total' => $billetItems->total(),
            'items' => $billetItems->items(),
        ];
    }

    public function store(StoreRequest $request, array $data): Billet
    {
        return Billet::firstOrCreate([
            ...$data,
            'user_id' => $request->user()->id,
            'photo' => null,
        ]);
    }

    public function update(array $data, Billet $billet): Billet
    {
        $billet->update($data);
        return $billet->fresh();
    }


}
