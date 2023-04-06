<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property bool $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Support\Collection|DigitalAsset[] $digital_assets
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function digital_assets(): MorphToMany
    {
        return $this->morphedByMany(DigitalAsset::class, 'categorizable');
    }
}
