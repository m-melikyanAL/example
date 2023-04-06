<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property int $id
 * @property int|null $guest_id
 * @property string $type
 * @property float|null $value
 * @property bool $is_percentage
 * @property \Carbon\Carbon|null $expires_at
 * @property int|null $approved_by
 * @property string|null $room_number
 * @property string|null $qr_data
 * @property string|null $qr_image_path
 * @property string|null $first_name
 * @property string|null $last_name
 * @property int|null $booking_id
 * @property int|null $booking_room_id
 * @property string|null $phone_number
 * @property string|null $phone_country_code
 * @property string|null $title
 * @property string|null $description
 * @property \Carbon\Carbon|null $used_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Support\Collection|Tag[] $tags
 * @property-read User|null $approver
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Voucher extends Model
{
    public const VOUCHER_TYPE_PHONE = 'phone';
    public const VOUCHER_TYPE_ROOM = 'room';
    public const VOUCHER_TYPES = [
        self::VOUCHER_TYPE_PHONE,
        self::VOUCHER_TYPE_ROOM,
    ];

    protected $fillable = [
        'guest_id',
        'type',
        'value',
        'expires_at',
        'approved_by',
        'room_number',
        'qr_data',
        'qr_image_path',
        'first_name',
        'last_name',
        'booking_id',
        'booking_room_id',
        'phone_number',
        'phone_country_code',
        'title',
        'description',
        'used_at',
        'is_percentage',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'expires_at' => 'datetime',
        'is_percentage' => 'boolean',
    ];

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
