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
        $this->authorize('viewAny', GiftCertificate::class);
        return GiftCertificate::all();
    }

    public function store(GiftCertificateRequest $request)
    {
        return $this->service->store( $request, $request->validated() );
    }

    public function show(GiftCertificate $giftCertificate)
    {
        $this->authorize('view', $giftCertificate);
        return $giftCertificate;
    }

    public function destroy(GiftCertificate $giftCertificate)
    {
        $this->authorize('delete', $giftCertificate);
        $giftCertificate->delete();
        return response()->json([], 204);
    }
}
