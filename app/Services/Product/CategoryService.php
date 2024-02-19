<?php
namespace App\Services\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Category;

class CategoryService extends Controller {
    public function store(array $data): Category
    {
        return Category::create($data);
    }

    public function update(array $data, int $id): Category
    {
        $category = Category::findOrFail($id);
        $category->update($data);
        return $category;
    }
}
