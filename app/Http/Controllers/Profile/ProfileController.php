<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Profile\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateRequest;
use App\Http\Resources\Profile\ProfileResource;
use App\Service\Profile\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends BaseController
{
    public function index()
    {
        $user = $this->service->get();
        return ProfileResource::make($user);
    }

    public function update(UpdateRequest $request)
    {
        $validatedData = $request->validated();
        $user = $this->service->update($validatedData);
        return ProfileResource::make($user);
    }

    public function destroy()
    {
        $user = $this->service->delete();
        return response()->json([
            'success' => true,
            'status' => 200,
        ], 200);
    }
}
