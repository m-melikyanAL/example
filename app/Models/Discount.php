<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $type
 * @property float $value
 * @property string $status
 * @property \Carbon\Carbon|null $started_at
 * @property \Carbon\Carbon|null $ended_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Discount extends Model
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';

    public const TYPE_AMOUNT = 'amount';
    public const TYPE_PERCENTAGE = 'percentage';
    public const DISCOUNT_TYPES = [
        self::TYPE_PERCENTAGE,
        self::TYPE_AMOUNT,
    ];

    protected $fillable = [
        'name',
        'code',
        'type',
        'value',
        'status',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function getDisplayValue(): string
    {
        return number_format($this->value, 2) . $this->type;
    }
}
