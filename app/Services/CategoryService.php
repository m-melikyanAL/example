<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Arr;

class CategoryService
{
    public function create(array $data): Category
    {
        return Category::create([
            'name' => Arr::get($data, 'name'),
            'description' => Arr::get($data, 'description'),
            'is_active' => Arr::get($data, 'is_active', false),
        ]);
    }

    public function update(Category $category, array $data): bool
    {
        return $category->update($data);
    }

    /**
     * @throws \Throwable
     */
    public function delete(Category $category): void
    {
        $category->deleteOrFail();
    }
}
