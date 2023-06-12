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
use Althinect\FilamentSpatieRolesPermissions\Concerns\HasSuperAdmin;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    use SoftDeletes, HasRoles, HasSuperAdmin, HasFactory;
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

    /**
     * Get the unit that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get all of the tickets for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'responsible_id');
    }

    /**
     * Determine who has access
     *
     * All users can access
     *
     * @return bool
     */
    public function canAccessFilament(): bool
    {
        return true;
    }

    /**
     * Add scope to display users based on their role
     *
     * If the role is as an admin unit, then display the user based on their unit ID.
     */
    public function scopeByRole($query)
    {
        if (auth()->user()->hasRole('Admin Unit')) {
            return $query->where('users.unit_id', auth()->user()->unit_id);
        }
    }
}
