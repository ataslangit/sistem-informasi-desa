<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Auditable;
use App\Traits\HasRoles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Auditable, HasApiTokens, HasFactory, HasRoles, Notifiable, SoftDeletes;

    /**
     * Kolom yang dikecualikan dari audit log.
     *
     * @var array<int, string>
     */
    protected array $auditExclude = [
        'password',
        'password_hash',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'password_hash',
        'is_active',
        'metadata',
    ];

    /**
     * Boot model untuk sinkronisasi password_hash dengan password Laravel.
     */
    protected static function booted(): void
    {
        static::saving(function (User $user): void {
            if (! empty($user->password)) {
                $user->password_hash = $user->password;
            }
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'metadata' => 'array',
    ];

    /**
     * Scope pencarian nama, username, email.
     */
    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if (empty($keyword)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($keyword): void {
            $q->where('name', 'like', "%{$keyword}%")
                ->orWhere('username', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%");
        });
    }

    /**
     * Scope filter berdasarkan role.
     */
    public function scopeRole(Builder $query, ?string $role): Builder
    {
        if (empty($role)) {
            return $query;
        }

        return $query->whereHas('roles', function (Builder $q) use ($role): void {
            $q->where('name', $role);
        });
    }

    /**
     * Scope filter berdasarkan status aktif.
     */
    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        if ($status === 'active') {
            return $query->where('is_active', true);
        }

        if ($status === 'inactive') {
            return $query->where('is_active', false);
        }

        return $query;
    }

    /**
     * Role utama user.
     */
    public function getPrimaryRoleAttribute(): ?Role
    {
        return $this->roles->first();
    }

    /**
     * CSS class badge role.
     */
    public function getRoleBadgeClassAttribute(): string
    {
        $roleName = $this->roles->first()?->name;

        return match ($roleName) {
            'superadmin' => 'bg-purple-50 text-purple-700 border-purple-200',
            'kades' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            'perangkat' => 'bg-blue-50 text-blue-700 border-blue-200',
            'rt' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'warga' => 'bg-slate-50 text-slate-700 border-slate-200',
            default => 'bg-gray-50 text-gray-700 border-gray-200',
        };
    }

    /**
     * Relasi ke data penduduk (Resident) jika akun ini milik warga.
     */
    public function resident(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Resident::class, 'user_id');
    }

    /**
     * Mengambil nomor RT yang diasosiasikan dengan akun ini (jika ada).
     */
    public function getAssignedRt(): ?string
    {
        return $this->resident?->family?->rt ?? $this->metadata['rt'] ?? null;
    }

    /**
     * Mengambil nomor RW yang diasosiasikan dengan akun ini (jika ada).
     */
    public function getAssignedRw(): ?string
    {
        return $this->resident?->family?->rw ?? $this->metadata['rw'] ?? null;
    }
}
