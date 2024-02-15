<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreCategoryRequest;
use App\Http\Requests\Product\UpdateCategoryRequest;
use App\Models\Product\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return $categories;
    }

    public function store(StoreCategoryRequest $request)
    {
        $validatedData = $request->validated();

        $category = Category::create($validatedData);

        return $category;
    }

    public function show(string $id)
    {
        return Category::findOrFail($id);
    }

    public function update(UpdateCategoryRequest $request, string $id)
    {
        $category = Category::findOrFail($id);

        $validatedData = $request->validated();

        $category->update($validatedData);

        return $category;
    }

    public function destroy(string $id)
    {
        if ( ! $category = Category::find($id) ) {
            return response()->json([], 204);
        };

        $category->delete();
        return response()->json([], 204);
    }

    public function getProducts(string $id) {
        $category = Category::findOrFail($id);
        return $this->sendSuccessResponse($category->products, 200);
    }
}
