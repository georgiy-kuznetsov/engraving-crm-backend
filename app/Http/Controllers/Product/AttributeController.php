<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreAttributeRequest;
use App\Http\Requests\Product\UpdateAttributeRequest;
use App\Models\Product\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = (int) $request->input('pageSize') ?? env('API_ITEMS_PER_PAGE');
        $page = (int) $request->input('page') ?? 1;

        $providers = Attribute::orderBy('id')->paginate( $pageSize, ['*'], 'page', $page );

        return [
            'currentPage' => $providers->currentPage(),
            'lastPage' => $providers->lastPage(),
            'pageSize' => $providers->perPage(),
            'total' => $providers->total(),
            'items' => $providers->items(),
        ];
    }

    public function store(StoreAttributeRequest $request)
    {
        $validatedData = $request->validated();
        return Attribute::create($validatedData);
    }

    public function show(string $id)
    {
        return Attribute::findOrFail($id);
    }

    public function update(UpdateAttributeRequest $request, string $id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->update( $request->validated() );
        return $attribute;
    }

    public function destroy(string $id)
    {
        if ( ! $attribute = Attribute::find($id) ) {
            return response()->json([], 204);
        };

        $attribute->delete();
        return response()->json([], 204);
    }
}
