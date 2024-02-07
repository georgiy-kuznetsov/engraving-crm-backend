<?php

namespace App\Http\Controllers\Billet;

use App\Http\Controllers\Controller;
use App\Models\Billet;
use Illuminate\Http\Request;

class BilletProductController extends Controller
{
    public function index(Request $request, $billetId)
    {
        $billet = Billet::find($billetId);

        if (! $billet) {
            // return $this->sendErrorResponse(['Billet not found'], 404);
        };

        $products = $billet->products;

        return $products;
    }
}
