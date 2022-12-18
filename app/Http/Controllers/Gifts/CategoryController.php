<?php

namespace App\Http\Controllers\Gifts;

use Usoft\Categories\Jobs\CategoryUpdateJobs;
use Usoft\Categories\Resources\CategoryResource;
use App\Http\Controllers\Controller;
use App\Policies\CategoryPolicy;
use Illuminate\Http\Request;
use Usoft\Categories\Jobs\CategoryJobs;
use Usoft\Categories\Models\Category;
use Usoft\Categories\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $this->authorize(CategoryPolicy::VIEW, Category::class);

        $category = Category::query()->get();

        return  CategoryResource::collection($category)->all();
    }

    public function store(CategoryRequest $request)
    {
        $this->authorize(CategoryPolicy::CREATE, Category::class);

        $category = CategoryJobs::dispatchNow($request);

        return (new CategoryResource($category))->response()->setStatusCode(201);
    }

    public function update(Category $category,CategoryRequest $request)
    {
        if ($request->isMethod('get')) {

            $this->authorize(CategoryPolicy::VIEW, Category::class);

            return new CategoryResource($category);
        }

        $this->authorize(CategoryPolicy::UPDATE, Category::class);

        CategoryUpdateJobs::dispatchNow($request,$category);

        $category->refresh();

        return (new CategoryResource($category))->response()->setStatusCode(202);
    }

    public function destroy(Category $category){

        $this->authorize(CategoryPolicy::DELETE, Category::class);

        $category->delete();

        return response()->json()->setStatusCode(204);
    }
}
