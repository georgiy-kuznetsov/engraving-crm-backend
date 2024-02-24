<?php
namespace App\Services\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class StoreService extends Controller {
    public function __invoke(array $data): array
    {
        $page = $data['page'] ?? 1;
        $pageSize = $data['pageSize'] ?? env('API_ITEMS_PER_PAGE');

        $usersData = User::orderBy('id')->paginate( $pageSize, ['*'], 'page', $page );

        return [
            'users' => $usersData->items(),
            'currentPage' => $usersData->currentPage(),
            'lastPage' => $usersData->lastPage(),
            'pageSize' => $usersData->perPage(),
            'total' => $usersData->total(),
        ];
    }
}
