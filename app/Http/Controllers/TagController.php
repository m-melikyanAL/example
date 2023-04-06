<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tag\StoreTagRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Throwable;

class TagController
{
    public function index(): AnonymousResourceCollection
    {
        return TagResource::collection(Tag::query()->latest()->paginate());
    }

    public function store(StoreTagRequest $request, TagService $service)
    {
        $tag = $service->create($request->validated());

        return new TagResource($tag);
    }

    public function show(Tag $tag): TagResource
    {
        return new TagResource($tag);
    }

    public function update(UpdateTagRequest $request, Tag $tag, TagService $service): TagResource
    {
        $service->update($tag, $request->validated());

        return new TagResource($tag->fresh());
    }

    public function destroy(Tag $tag, TagService $service)
    {
        try {
            $service->delete($tag);
        } catch (Throwable) {
            return abort(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->noContent();
    }
}
