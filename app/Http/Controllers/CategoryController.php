<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Throwable;

class CategoryController
{
    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection(Category::query()->latest()->paginate());
    }

    public function store(StoreCategoryRequest $request, CategoryService $service): CategoryResource
    {
        $category = $service->create($request->validated());

        return new CategoryResource($category);
    }

    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }

    public function update(
        UpdateCategoryRequest $request,
        Category $category,
        CategoryService $service
    ): CategoryResource {
        $service->update($category, $request->validated());

        return new CategoryResource($category->fresh());
    }

    public function destroy(Category $category, CategoryService $service): Response
    {
        try {
            $service->delete($category);
        } catch (Throwable) {
            return abort(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->noContent();
    }
}
