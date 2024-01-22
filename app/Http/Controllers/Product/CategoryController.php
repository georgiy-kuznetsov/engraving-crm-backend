<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\BaseController;
use App\Models\Product\Category;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function index()
    {
        $categories = Category::all();
        return $this->sendSuccessResponse($categories, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $category = Category::create($validatedData);

        return $this->sendSuccessResponse($category, 201);
    }

    public function show(string $id)
    {
        if ( ! $category = Category::find($id) ) {
            return $this->sendErrorResponse(['Category not found'], 404);
        };
        
        return $this->sendSuccessResponse($category, 200);
    }

    public function update(Request $request, string $id)
    {
        if ( ! $category = Category::find($id) ) {
            return $this->sendErrorResponse(['Category not found'], 404);
        };

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $category->update($validatedData);

        return $this->sendSuccessResponse($category, 200);
    }

    public function destroy(string $id)
    {
        if ( ! $category = Category::find($id) ) {
            return $this->sendSuccessResponse([], 204);
        };

        $category->delete();
        return $this->sendSuccessResponse([], 204);
    }

    public function getProducts(string $id) {
        if ( ! $category = Category::find($id) ) {
            return $this->sendErrorResponse(['Category not found'], 404);
        };

        return $this->sendSuccessResponse($category->products, 200);
    }
}
