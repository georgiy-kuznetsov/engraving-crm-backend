<?php

namespace App\Http\Controllers\Billet;

use App\Http\Controllers\Controller;
use App\Models\Billet;
use Illuminate\Http\Request;

class BilletProductController extends Controller
{
    public function index(Request $request, $billetId)
    {
        $billet = Billet::findOrFail($billetId);
        return $billet->products;
    }
}
