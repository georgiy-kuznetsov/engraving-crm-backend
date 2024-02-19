<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use App\Services\User\StoreService;
use App\Services\User\UpdateService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $storeService;
    protected $updateService;

    public function __construct(StoreService $storeService, UpdateService $updateService) {
        $this->storeService = $storeService;
        $this->updateService = $updateService;
    }

    public function index(Request $request)
    {
        $pageSize = (int) $request->input('pageSize') ?? env('API_ITEMS_PER_PAGE');
        $page = (int) $request->input('page') ?? 1;

        $usersData = User::orderBy('id')->paginate( $pageSize, ['*'], 'page', $page );

        return [
            'users' => $usersData->items(),
            'currentPage' => $usersData->currentPage(),
            'lastPage' => $usersData->lastPage(),
            'pageSize' => $usersData->perPage(),
            'total' => $usersData->total(),
            'nextPageUrl' => $usersData->nextPageUrl(),
            'previousPageUrl' => $usersData->previousPageUrl(),
        ];
    }

    public function store(StoreRequest $request)
    {
        return ( $this->storeService ) ( $request->validated() );
    }

    public function show(User $user)
    {
        return User::findOrFail($user);
    }

    public function update(UpdateRequest $request, $userId)
    {
        return ( $this->updateService ) ( $request->validated(), $userId );
    }

    public function destroy(int $id)
    {
        if ( $user = User::find($id) ) {
            $user->delete();
        }
        return response()->json([], 204);
    }

    public function getProviders($userId) {
        $user = User::findOrFail($userId);
        return $user->provider()->get();
    }

    public function getProducts($userId) {
        $user = User::findOrFail($userId);
        return $user->product()->get();
    }

    public function getBillets($userId) {
        $user = User::findOrFail($userId);
        return $user->billet()->get();
    }

    public function getCustomers($userId) {
        $user = User::findOrFail($userId);
        return $user->customers()->get();
    }

    public function getOrders($userId) {
        $user = User::findOrFail($userId);
        return $user->orders()->get();
    }

    public function getGiftCertificates(int $userId) {
        $user = User::findOrFail($userId);
        return $user->giftCertificates()->get();
    }
}
