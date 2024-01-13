<?php

namespace App\Http\Controllers\Billet;

use App\Http\Controllers\BaseController;
use App\Models\Billet;
use Illuminate\Http\Request;

class BilletProductController extends BaseController
{
    public function index(Request $request, $billetId)
    {
        $billet = Billet::find($billetId);

        if (! $billet) {
            return $this->sendErrorResponse(['Billet not found'], 404);
        };

        $products = $billet->products;

        return $this->sendSuccessResponse($products, 200);
    }
}
