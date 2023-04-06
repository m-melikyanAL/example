<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $username
 * @property string $name
 * @property string|null $last_name
 * @property string $email
 * @property string|null $phone_number
 * @property string|null $phone_country_code
 * @property string $password
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Support\Collection|\Spatie\Permission\Models\Role[] $roles
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasRoles;
    use SoftDeletes;

    protected $fillable = [
        'username',
        'name',
        'last_name',
        'email',
        'phone_number',
        'phone_country_code',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function approved_vouchers(): HasMany
    {
        return $this->hasMany(Voucher::class, 'approved_by');
    }
}
