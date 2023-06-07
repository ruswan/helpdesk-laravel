<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @property int $id
 * @property int|null $unit_id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property Carbon|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $identity
 * @property string|null $phone
 * @property int|null $user_level_id
 * @property bool $is_active
 * @property string|null $deleted_at
 *
 * @property Unit|null $unit
 * @property Collection|Comment[] $comments
 * @property Collection|Ticket[] $tickets
 *
 * @package App\Models
 */
class User extends Authenticatable implements FilamentUser
{
    use SoftDeletes,   HasRoles;
    protected $table = 'users';

    protected $casts = [
        'unit_id' => 'int',
        'email_verified_at' => 'datetime',
        'two_factor_confirmed_at' => 'datetime',
        'user_level_id' => 'int',
        'is_active' => 'bool'
    ];

    protected $hidden = [
        'password',
        'two_factor_secret',
        'remember_token'
    ];

    protected $fillable = [
        'unit_id',
        'name',
        'email',
        'email_verified_at',
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
        'remember_token',
        'identity',
        'phone',
        'user_level_id',
        'is_active'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'responsible_id');
    }

    public function canAccessFilament(): bool
    {
        return true;
    }
}
