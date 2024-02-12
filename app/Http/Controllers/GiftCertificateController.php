<?php

namespace App\Http\Controllers;

use App\Models\GiftCertificate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GiftCertificateController extends Controller
{
    public function index()
    {
        return GiftCertificate::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'number' => ['nullable', 'string', 'max:255', 'unique:girt_certificates,number'],
            'balance' => ['required', 'decimal:2', 'max:99999999.99'],
            'expires_at' => ['required', 'date'],
        ]);

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
