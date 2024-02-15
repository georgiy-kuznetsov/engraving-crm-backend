<?php

namespace App\Http\Controllers;

use App\Http\Requests\GiftCertificateRequest;
use App\Models\GiftCertificate;
use Carbon\Carbon;

class GiftCertificateController extends Controller
{
    public function index()
    {
        return GiftCertificate::all();
    }

    public function store(GiftCertificateRequest $request)
    {
        $validatedData = $request->validated();

        $validatedData['expires_at'] = Carbon::parse($validatedData['expires_at']);

        $giftCertificate = GiftCertificate::create([
            ...$validatedData,
            'user_id' => $request->user()->id,
        ]);

        if ( ! $giftCertificate->number) {
            $giftCertificate->number = $giftCertificate->getNumber();
            $giftCertificate->save();
        }

        return $giftCertificate;
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
