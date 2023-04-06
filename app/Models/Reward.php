<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property float $amount_from
 * @property float $amount_to
 * @property string $type
 * @property float $value
 * @property \Carbon\Carbon|null $create_at
 * @property \Carbon\Carbon|null $updated_at
 */
class Reward extends Model
{
    public const TYPE_PERCENTAGE = 'percentage';
    public const TYPE_AMOUNT = 'amount';
    public const REWARD_TYPES = [
        self::TYPE_AMOUNT,
        self::TYPE_PERCENTAGE,
    ];

    protected $fillable = [
        'amount_from',
        'amount_to',
        'type',
        'value',
    ];

    protected $casts = [
        'amount_from' => 'decimal:2',
        'amount_to' => 'decimal:2',
        'value' => 'decimal:2',
    ];
}
