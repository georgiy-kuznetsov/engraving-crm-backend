<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreCategoryRequest;
use App\Http\Requests\Product\UpdateCategoryRequest;
use App\Models\Product\Category;
use App\Service\Product\CategoryService;

class CategoryController extends Controller
{
    protected $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return Category::all();
    }

    public function store(StoreCategoryRequest $request)
    {
        return $this->service->store( $request->validated() );
    }

    public function show(string $id)
    {
        return Category::findOrFail($id);
    }

    public function update(UpdateCategoryRequest $request, int $id)
    {
        return $this->service->update($request->validated(), $id);
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
        return $category->products;
    }
}
