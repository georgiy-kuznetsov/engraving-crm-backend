<?php

namespace App\Http\Controllers;

use App\Http\Requests\GiftCertificateRequest;
use App\Models\GiftCertificate;
use App\Services\GiftCertificateService;

class GiftCertificateController extends Controller
{
    protected $service;

    public function __construct(GiftCertificateService $service) {
        $this->service = $service;
    }

    public function index()
    {
        return GiftCertificate::all();
    }

    public function store(GiftCertificateRequest $request)
    {
        return $this->service->store( $request, $request->validated() );
    }

    public function show(int $id)
    {
        return GiftCertificate::findOrFail($id);
    }

    public function destroy(int $id)
    {
        if ( ! $giftCertificate = GiftCertificate::find($id) ) {
            return response()->json([], 204);
        };

        $giftCertificate->delete();
        return response()->json([], 204);
    }
}
