<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = (int) $request->input('pageSize') ?? env('API_ITEMS_PER_PAGE');
        $page = (int) $request->input('page') ?? 1;

        $usersData = User::orderBy('id')->paginate( $pageSize, ['*'], 'page', $page );

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'messages' => [],
            'data' => array(
                'users' => $usersData->items(),
                'currentPage' => $usersData->currentPage(),
                'lastPage' => $usersData->lastPage(),
                'pageSize' => $usersData->perPage(),
                'total' => $usersData->total(),
                'nextPageUrl' => $usersData->nextPageUrl(),
                'previousPageUrl' => $usersData->previousPageUrl(),
            ),
        ]);
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

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'messages' => [],
            'data' => $user,
        ]);
    }

    public function show(User $user)
    {
        $data = User::find($user);

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'messages' => [],
            'data' => $data,
        ]);
    }

    public function update(Request $request, User $user)
    {
        //
    }

    public function destroy(User $user)
    {
        //
    }
}
