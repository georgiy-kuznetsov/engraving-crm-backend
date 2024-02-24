<?php

namespace App\Http\Controllers\Billet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Billet\IndexRequest;
use App\Http\Requests\Billet\StoreRequest;
use App\Http\Requests\Billet\UpdateRequest;
use App\Models\Billet;
use App\Services\Billet\BilletService;
use Illuminate\Http\Request;

class BilletController extends Controller
{
    protected $service;

    public function __construct(BilletService $service) {
        $this->service = $service;
    }

    public function index(IndexRequest $request)
    {
        $this->authorize('viewAny', Billet::class);
        return $this->service->index( $request->validated() );
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Billet::class);
        return $this->service->store($request, $request->validated());
    }

    public function show(Billet $billet)
    {
        $this->authorize('view', $billet);
        return $billet;
    }

    public function update(UpdateRequest $request, Billet $billet)
    {
        $this->authorize('update', $billet);
        return $this->service->update($request->validated(), $billet);
    }

    public function destroy(Billet $billet)
    {
        $this->authorize('delete', $billet);
        $billet->delete();
        return response()->json([], 204);
    }
}
