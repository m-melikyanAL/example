<?php

namespace App\Http\Controllers;

use App\Http\Requests\DigitalAsset\BulkDeleteDigitalAssetsRequest;
use App\Http\Requests\DigitalAsset\BulkUpdateDigitalAssetsRequest;
use App\Http\Requests\DigitalAsset\UpdateDigitalAssetRequest;
use App\Http\Requests\DigitalAsset\UploadDigitalAssetRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\DigitalAssetResource;
use App\Http\Resources\TagResource;
use App\Models\Category;
use App\Models\DigitalAsset;
use App\Models\Tag;
use App\Services\DigitalAssetService;
use App\Traits\StoresDigitalAsset;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class DigitalAssetController
{
    use StoresDigitalAsset;

    public function index(Request $request): AnonymousResourceCollection
    {
        $assetQuery = DigitalAsset::query();
        $assetQuery->with(['categories', 'tags']);
        $assetQuery = $this->applyCategoriesFilter($request, $assetQuery);
        $assetQuery = $this->applyTagsFilter($request, $assetQuery);
        $assetQuery = $this->applyStatusFilter($request, $assetQuery);
        $assetQuery = $this->applyIdsFilter($request, $assetQuery);
        $assetQuery = $this->applySearchFilter($request, $assetQuery);
        $assetQuery->latest();

        return DigitalAssetResource::collection($assetQuery->paginate(30))
            ->additional([
                'meta' => [
                    'categories' => CategoryResource::collection(
                        Category::latest()->get()
                    ),
                    'tags' => TagResource::collection(
                        Tag::latest()->get()
                    ),
                ],
            ]);
    }

    public function store(
        UploadDigitalAssetRequest $request,
        DigitalAssetService $digitalAssetService
    ): DigitalAssetResource {
        $digitalAsset = $this->storeDigitalAsset($request, $digitalAssetService);

        $digitalAsset->categories()->save(Category::firstOrCreate(['name' => 'Events']));

        $digitalAsset->load(['categories', 'tags']);

        return DigitalAssetResource::make($digitalAsset);
    }

    public function show(DigitalAsset $digital_asset): DigitalAssetResource
    {
        $digital_asset->load(['categories', 'tags']);

        return (new DigitalAssetResource($digital_asset))->additional([
            'meta' => [
                'categories' => CategoryResource::collection(
                    Category::latest()->get()
                ),
                'tags' => TagResource::collection(
                    Tag::latest()->get()
                ),
            ],
        ]);
    }

    public function update(
        UpdateDigitalAssetRequest $request,
        DigitalAsset $digital_asset,
        DigitalAssetService $service
    ): DigitalAssetResource {
        $service->updateAsset($request->validated(), $digital_asset);

        $digital_asset = $digital_asset->fresh(['categories', 'tags']);

        return (new DigitalAssetResource($digital_asset))->additional([
            'meta' => [
                'categories' => CategoryResource::collection(
                    Category::latest()->get()
                ),
                'tags' => TagResource::collection(
                    Tag::latest()->get()
                ),
            ],
        ]);
    }

    public function destroy(DigitalAsset $digital_asset, DigitalAssetService $service): Response
    {
        $service->deleteAsset($digital_asset);

        return response()->noContent();
    }

    public function bulkUpdate(BulkUpdateDigitalAssetsRequest $request, DigitalAssetService $service): Response
    {
        if ($request->has('status')) {
            $service->bulkUpdateStatus(
                collect($request->input('assets')),
                $request->input('status')
            );
        }

        if ($request->has('category')) {
            $service->bulkUpdateCategory(
                collect($request->input('assets')),
                $request->input('category')
            );
        }

        if ($request->has('tags')) {
            $service->bulkUpdateTags(
                collect($request->input('assets')),
                $request->input('tags')
            );
        }

        return response()->noContent();
    }

    public function bulkDestroy(BulkDeleteDigitalAssetsRequest $request, DigitalAssetService $service): Response
    {
        $service->bulkDelete(DigitalAsset::find($request->input('assets')));

        return response()->noContent();
    }

    private function applyCategoriesFilter(Request $request, Builder $assetQuery): Builder
    {
        if ($request->has('categories') && $request->input('categories')) {
            $assetQuery->whereHas(
                'categories',
                fn (Builder $query) => $query->whereIn(
                    'name',
                    explode(',', $request->input('categories'))
                )
            );
        }

        return $assetQuery;
    }

    private function applyTagsFilter(Request $request, Builder $assetQuery): Builder
    {
        if ($request->has('tags') && $request->input('tags')) {
            $assetQuery->whereHas(
                'tags',
                fn (Builder $query) => $query->whereIn(
                    'name',
                    explode(',', $request->input('tags'))
                )
            );
        }

        return $assetQuery;
    }

    private function applyStatusFilter(Request $request, Builder $assetQuery): Builder
    {
        if ($request->has('status') && $request->input('status')) {
            $request->input('status') === DigitalAsset::STATUS_ACTIVE
                ? $assetQuery->where('status', 'active')
                : $assetQuery->where(function (Builder $query) {
                    $query->where(
                        'status',
                        '!=',
                        DigitalAsset::STATUS_ACTIVE
                    )
                        ->orWhereNull('status');
                });
        }

        return $assetQuery;
    }

    private function applyIdsFilter(Request $request, Builder $query): Builder
    {
        if (!$request->has('assets')) {
            return $query;
        }

        if (!$request->input('assets')) {
            return $query;
        }

        return $query->whereIn('id', explode(',', $request->input('assets')));
    }

    private function applySearchFilter(Request $request, Builder $query): Builder
    {
        if (!$request->has('search')) {
            return $query;
        }

        if (!$request->input('search')) {
            return $query;
        }

        return $query->where(
            'name',
            'like',
            '%' . $request->input('search') . '%'
        );
    }
}
