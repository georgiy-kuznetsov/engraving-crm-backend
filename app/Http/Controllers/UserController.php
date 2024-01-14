<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\BaseController;

class UserController extends BaseController
{
    public function index(Request $request)
    {  
        $pageSize = (int) $request->input('pageSize') ?? env('API_ITEMS_PER_PAGE');
        $page = (int) $request->input('page') ?? 1;

        $usersData = User::orderBy('id')->paginate( $pageSize, ['*'], 'page', $page );

        return $this->sendSuccessResponse([
            'users' => $usersData->items(),
            'currentPage' => $usersData->currentPage(),
            'lastPage' => $usersData->lastPage(),
            'pageSize' => $usersData->perPage(),
            'total' => $usersData->total(),
            'nextPageUrl' => $usersData->nextPageUrl(),
            'previousPageUrl' => $usersData->previousPageUrl(),
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'login' => ['required', 'unique:users', 'min:7', 'max:50'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', 'min:6', 'max:50'],

            'first_name' => ['nullable', 'string', 'max:100'],
            'last_name' => ['nullable', 'string', 'max:100'],
        ]);

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

        return $this->sendSuccessResponse($user, 200);
    }

    public function show(User $user)
    {
        $data = User::find($user);

        return $this->sendSuccessResponse($data, 200);
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

        return $this->sendSuccessResponse($validatedData, 200);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return $this->sendSuccessResponse([], 204);
    }

    public function getProviders($userId) {
        if (! $user = User::find($userId)) {
            return $this->sendErrorResponse(['User not found'], 404);
        };
        return $this->sendSuccessResponse( $user->provider()->get(), 200 );
    }

    public function getProducts($userId) {
        if (! $user = User::find($userId)) {
            return $this->sendErrorResponse(['User not found'], 404);
        };
        return $this->sendSuccessResponse( $user->product()->get(), 200 );
    }

    public function getBillets($userId) {
        if (! $user = User::find($userId)) {
            return $this->sendErrorResponse(['User not found'], 404);
        };
    
        return $this->sendSuccessResponse( $user->billet()->get(), 200 );
    }
}
