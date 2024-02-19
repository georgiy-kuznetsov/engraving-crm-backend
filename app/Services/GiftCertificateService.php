<?php
namespace App\Services;

use App\Http\Controllers\Controller;
use App\Http\Requests\GiftCertificateRequest;
use App\Models\GiftCertificate;
use Carbon\Carbon;

class GiftCertificateService extends Controller {
    public function store(GiftCertificateRequest $request, array $data): GiftCertificate
    {
        $data['expires_at'] = Carbon::parse($data['expires_at']);

        $certificate = GiftCertificate::create([
            ...$data,
            'user_id' => $request->user()->id,
        ]);

        if ( ! $certificate->number) {
            $certificate->number = $certificate->getNumber();
            $certificate->save();
        }

        return $certificate;
    }
}
