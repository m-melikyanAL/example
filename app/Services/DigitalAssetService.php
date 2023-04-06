<?php

namespace App\Services;

use App\Models\Category;
use App\Models\DigitalAsset;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class DigitalAssetService
{
    public const VISIBILITY_PUBLIC = 'public';
    public const VISIBILITY_PRIVATE = 'private';
    public const VISIBILITIES = [
        self::VISIBILITY_PUBLIC,
        self::VISIBILITY_PRIVATE,
    ];

    public function uploadAsset($file, string $path = '', string $visibility = 'public'): bool|string
    {
        return Storage::putFile($path, $file, $visibility);
    }

    public function generatePrivateUrl(DigitalAsset $asset, Carbon $expire): string
    {
        return Storage::temporaryUrl($asset->path, $expire);
    }

    public function setAssetVisibility(DigitalAsset $asset, string $visibility): bool
    {
        if (!in_array($visibility, self::VISIBILITIES, true)) {
            return false;
        }

        return Storage::setVisibility($asset->path, $visibility);
    }

    public function createAssetFromPath(
        string $path,
        bool $isVideo = false,
        bool $isActive = false,
        string $name = ''
    ): DigitalAsset {
        return DigitalAsset::create([
            'name' => $name ?? Arr::get(
                explode('/', $path),
                1
            ),
            'path' => $path,
            'extension' => File::extension($path),
            'type' => $isVideo ? DigitalAsset::TYPE_VIDEO : DigitalAsset::TYPE_IMAGE,
            'status' => $isActive ? DigitalAsset::STATUS_ACTIVE : DigitalAsset::STATUS_INACTIVE,
        ]);
    }

    public function updateAsset(array $data, DigitalAsset $asset): void
    {
        if (Arr::has($data, 'categories')) {
            $asset->categories()->detach();

            $asset->categories()
                ->saveMany(
                    Category::whereIn(
                        'id',
                        Arr::get($data, 'categories')
                    )->get()
                );
        }

        if (Arr::has($data, 'tags')) {
            $asset->tags()->detach();

            $tags = collect(Arr::get($data, 'tags'));

            $tags = $tags->map(
                fn (string $tag) => Tag::firstOrCreate(
                    [
                        'name' => $tag,
                        'is_active' => true,
                    ]
                )
            );

            $asset->tags()->saveMany($tags);
        }

        $asset->status = Arr::get($data, 'status', $asset->status);
        $asset->name = Arr::get($data, 'name', $asset->name);
        $asset->save();
    }

    public function deleteAsset(DigitalAsset $asset): void
    {
        $this->removeMediaFromStorageDisk($asset);
        $asset->delete();
    }

    public function bulkDelete(Collection $assets): void
    {
        $assets->each(function ($asset) {
            $this->deleteAsset($asset);
        });
    }

    public function bulkUpdateStatus(Collection $assetsIds, string $status): void
    {
        DigitalAsset::whereIn('id', $assetsIds)
            ->update(['status' => $status]);
    }

    public function bulkUpdateCategory(Collection $assetIds, string $category): void
    {
        DigitalAsset::whereIn('id', $assetIds)
            ->each(function (DigitalAsset $asset) use ($category) {
                $asset->categories()->detach();

                $asset->categories()
                    ->saveMany(
                        Category::where(
                            'name',
                            $category
                        )->get()
                    );
            });
    }

    public function bulkUpdateTags(Collection $assetIds, array $tags): void
    {
        DigitalAsset::whereIn('id', $assetIds)
            ->each(function (DigitalAsset $asset) use ($tags) {
                $asset->tags()->detach();

                $tags = collect($tags)->map(
                    fn (string $tag) => Tag::firstOrCreate(
                        [
                            'name' => $tag,
                            'is_active' => true,
                        ]
                    )
                );

                $asset->tags()->saveMany($tags);
            });
    }

    private function removeMediaFromStorageDisk(DigitalAsset $asset): void
    {
        Storage::delete($asset->path);
    }

    public function resizeImage(string $path, int $width = 600): void
    {
        Image::make($path)->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        })
            ->save($path);
    }

    public static function getAssetUrl(DigitalAsset $asset): string
    {
        return Storage::url($asset->path);
    }
}
