<?php

namespace App\Models;

use App\Services\DigitalAssetService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property int $id
 * @property string $name
 * @property string $path
 * @property string $extension
 * @property int $type
 * @property string $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Support\Collection|Category[] $categories
 * @property-read \Illuminate\Support\Collection|Promotion[] $promotions
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class DigitalAsset extends Model
{
    public const UPLOAD_FOLDER = 'digital_assets';
    public const TYPE_IMAGE = 1;
    public const TYPE_VIDEO = 2;
    public const TYPES = [
        self::TYPE_IMAGE,
        self::TYPE_VIDEO,
    ];
    public const TYPE_NAMES = [
        self::TYPE_IMAGE => 'image',
        self::TYPE_VIDEO => 'video',
    ];

    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    public const STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
    ];

    public const VIDEO_EXTENSIONS = [
        'mp4',
    ];
    public const IMAGE_EXTENSIONS = [
        'jpeg',
        'jpg',
        'png',
    ];

    protected $fillable = [
        'name',
        'path',
        'extension',
        'type',
        'status',
    ];

    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotion::class);
    }

    public function getUrl(): string
    {
        return DigitalAssetService::getAssetUrl($this);
    }
}
