<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
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
        $validatedData = $request->validated();

        $user = User::create([
            'login' => $validatedData['login'],
            'email' => $validatedData['email'],
            'password' => bcrypt( $validatedData['password'] ),

            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],

            'avatar_large' => null,
            'avatar_small' => null,

            'is_owner' => false,
            'active' => false,
        ]);

        return $user;
    }

    public function show(User $user)
    {
        $user = User::find($user);

        return $user;
    }

    public function update(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $validatedData = $request->validate([
            'email' => ['sometimes', 'required', 'string', 'email', 'unique:users,email,' . $userId],
            'last_name' => ['nullable', 'string', 'max:100'],
            'first_name' => ['nullable', 'string', 'max:100'],
        ]);
    
        $user->update($validatedData);

        return $validatedData;
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([], 204);
    }

    public function getProviders($userId) {
        if (! $user = User::find($userId)) {
            // return $this->sendErrorResponse(['User not found'], 404);
        };
        return $user->provider()->get();
    }

    public function getProducts($userId) {
        if (! $user = User::find($userId)) {
            // return $this->sendErrorResponse(['User not found'], 404);
        };
        return $user->product()->get();
    }

    public function getBillets($userId) {
        if (! $user = User::find($userId)) {
            // return $this->sendErrorResponse(['User not found'], 404);
        };
    
        return $user->billet()->get();
    }

    public function getCustomers($userId) {
        if (! $user = User::find($userId)) {
            // return $this->sendErrorResponse(['User not found'], 404);
        };
    
        return $user->customers()->get();
    }

    public function getOrders($userId) {
        if (! $user = User::find($userId)) {
            // return $this->sendErrorResponse(['User not found'], 404);
        };
    
        return $user->orders()->get();
    }

    public function getGiftCertificates(int $userId) {
        $user = User::findOrFail($userId);    
        return $user->giftCertificates()->get();
    }
}
