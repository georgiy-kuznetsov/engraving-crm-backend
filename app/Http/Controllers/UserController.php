<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\IndexRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use App\Services\User\IndexService;
use App\Services\User\StoreService;
use App\Services\User\UpdateService;

class UserController extends Controller
{
    protected $indexService;
    protected $storeService;
    protected $updateService;

    public function __construct(IndexService $indexService, StoreService $storeService, UpdateService $updateService) {
        $this->indexService = $indexService;
        $this->storeService = $storeService;
        $this->updateService = $updateService;
    }

    public function index(IndexRequest $request)
    {
        $this->authorize('viewAny', User::class);
        return ( $this->indexService ) ( $request->validated() );
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', User::class);
        return ( $this->storeService ) ( $request->validated() );
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);
        return $user;
    }

    public function update(UpdateRequest $request, User $user)
    {
        $this->authorize('update', $user);
        return ( $this->updateService ) ( $request->validated(), $user );
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete($user);
        return response()->json([], 204);
    }

    public function getProviders(User $user) {
        $this->authorize('view', $user);
        return $user->provider()->get();
    }

    public function getProducts(User $user) {
        $this->authorize('view', $user);
        return $user->product()->get();
    }

    public function getBillets(User $user) {
        $this->authorize('view', $user);
        return $user->billet()->get();
    }

    public function getCustomers(User $user) {
        $this->authorize('view', $user);
        return $user->customers()->get();
    }

    public function getOrders(User $user) {
        $this->authorize('view', $user);
        return $user->orders()->get();
    }

    public function getGiftCertificates(User $user) {
        $this->authorize('view', $user);
        return $user->giftCertificates()->get();
    }
}
