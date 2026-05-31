<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Role;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property Collection<int, Role> $roles
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    
    protected $fillable = [
        'username',
        'password',
        'guru_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            'user_roles',
            'user_id',
            'role_id'
        );
    }
    public function hasRole(int $roleId): bool
    {
        return $this->roles->contains('id', $roleId);
    }

    public function hasAnyRole(array $roleIds): bool
    {
        return $this->roles->pluck('id')->intersect($roleIds)->isNotEmpty();
    }
    public function canEditPresensiRombel($rombel): bool
    {
        return $this->hasRole(UserRole::WALI_KELAS)
            && $this->guru_id === $rombel->wali_kelas_id;
    }


}
