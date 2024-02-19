<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Profile\BaseController;
use App\Http\Requests\Profile\UpdateRequest;
use App\Http\Resources\Profile\ProfileResource;

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
        return [];
    }
}
