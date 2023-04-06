<?php

namespace App\Services;

use App\Models\Tag;
use Illuminate\Support\Arr;

class TagService
{
    public function create(array $data): Tag
    {
        return Tag::create([
            'name' => Arr::get($data, 'name'),
            'description' => Arr::get($data, 'description'),
            'is_active' => Arr::get($data, 'is_active', false),
        ]);
    }

    public function update(Tag $category, array $data): bool
    {
        return $category->update($data);
    }

    /**
     * @throws \Throwable
     */
    public function delete(Tag $category): void
    {
        $category->deleteOrFail();
    }
}
