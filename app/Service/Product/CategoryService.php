<?php
namespace App\Service\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreCategoryRequest;
use App\Models\Product\Category;

class CategoryService extends Controller {
    public function store(array $data): Category
    {
        return Category::create($data);
    }
}
