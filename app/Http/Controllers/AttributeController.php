<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends BaseController
{
    public function index(Request $request)
    {
        $pageSize = (int) $request->input('pageSize') ?? env('API_ITEMS_PER_PAGE');
        $page = (int) $request->input('page') ?? 1;

        $providers = Attribute::orderBy('id')->paginate( $pageSize, ['*'], 'page', $page );

        return $this->sendSuccessResponse([
            'currentPage' => $providers->currentPage(),
            'lastPage' => $providers->lastPage(),
            'pageSize' => $providers->perPage(),
            'total' => $providers->total(),
            'items' => $providers->items(),
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:attributes'],
            'unit' => ['nullable', 'string', 'max:255'],
        ]);

        $attribute = Attribute::create([
            'name' => $validatedData['name'],
            'unit' => $validatedData['unit'],
        ]);

        return $this->sendSuccessResponse($attribute, 200);
    }

    public function show(string $id)
    {
        if (! $attribute = Attribute::find($id)) {
            return $this->sendErrorResponse(['Attribute not found'], 404);
        };
        return $this->sendSuccessResponse($attribute, 200);
    }

    public function update(Request $request, string $id)
    {
        if (! $attribute = Attribute::find($id)) {
            return $this->sendErrorResponse(['Attribute not found'], 404);
        };

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:attributes,name,' . $id],
            'unit' => ['nullable', 'string', 'max:255'],
        ]);

        $attribute->update($validatedData);
        return $this->sendSuccessResponse($attribute, 200);
    }

    public function destroy(string $id)
    {
        if ( ! $attribute = Attribute::find($id) ) {
            return $this->sendSuccessResponse([], 204);
        };

        $attribute->delete();
        return $this->sendSuccessResponse([], 204);
    }
}
