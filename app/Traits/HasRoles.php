<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Ttpryg\AuthUser\Entities\Permission as AuthUserPermission;
use Ttpryg\AuthUser\Entities\Role as AuthUserRole;
use Ttpryg\AuthUser\Entities\User as AuthUserEntity;

trait HasRoles
{
    /**
     * Relasi many-to-many ke Role.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    /**
     * Memeriksa apakah user memiliki salah satu atau beberapa role tertentu.
     *
     * @param string|array<int, string> $roles
     */
    public function hasRole(string|array $roles): bool
    {
        $roleList = is_array($roles) ? $roles : func_get_args();

        // Mengambil nama role yang dimiliki user (cache per-request di relasi)
        $userRoles = $this->roles->pluck('name')->toArray();

        foreach ($roleList as $role) {
            if (in_array($role, $userRoles, true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Memeriksa apakah user memiliki permission tertentu (melalui role-role yang dimilikinya).
     */
    public function hasPermission(string $permission): bool
    {
        if ($this->hasRole('superadmin')) {
            return true;
        }

        $permissions = $this->getAllPermissions()->pluck('name')->toArray();

        return in_array($permission, $permissions, true);
    }

    /**
     * Mengambil seluruh permission dari semua role yang dimiliki user.
     */
    public function getAllPermissions(): Collection
    {
        return $this->roles->loadMissing('permissions')
            ->pluck('permissions')
            ->flatten()
            ->unique('id');
    }

    /**
     * Menetapkan role ke user.
     */
    public function assignRole(string|Role $role): self
    {
        $roleModel = is_string($role)
            ? Role::where('name', $role)->firstOrFail()
            : $role;

        $this->roles()->syncWithoutDetaching([$roleModel->id]);
        $this->load('roles');

        return $this;
    }

    /**
     * Menghapus role dari user.
     */
    public function removeRole(string|Role $role): self
    {
        $roleModel = is_string($role)
            ? Role::where('name', $role)->first()
            : $role;

        if ($roleModel) {
            $this->roles()->detach($roleModel->id);
            $this->load('roles');
        }

        return $this;
    }

    /**
     * Sinkronisasi role user.
     *
     * @param array<int, string|int|Role> $roles
     */
    public function syncRoles(array $roles): self
    {
        $roleIds = [];
        foreach ($roles as $role) {
            if ($role instanceof Role) {
                $roleIds[] = $role->id;
            } elseif (is_numeric($role)) {
                $roleIds[] = (int) $role;
            } elseif (is_string($role)) {
                $found = Role::where('name', $role)->first();
                if ($found) {
                    $roleIds[] = $found->id;
                }
            }
        }

        $this->roles()->sync($roleIds);
        $this->load('roles');

        return $this;
    }

    /**
     * Mengonversi User Eloquent ke Entity Ttpryg\AuthUser untuk integrasi library.
     */
    public function toAuthUserEntity(): AuthUserEntity
    {
        $roles = $this->roles->map(fn (Role $r): AuthUserRole => new AuthUserRole(
            $r->name,
            $r->label,
            $r->description,
            (int) $r->id
        ))->toArray();

        $permissions = $this->getAllPermissions()->map(fn (Permission $p): AuthUserPermission => new AuthUserPermission(
            $p->name,
            $p->label,
            $p->description,
            (int) $p->id
        ))->toArray();

        return new AuthUserEntity(
            email: $this->email,
            passwordHash: $this->password,
            username: $this->username,
            isActive: (bool) $this->is_active,
            metadata: $this->metadata ?? [],
            id: (int) $this->id,
            roles: $roles,
            permissions: $permissions,
            createdAt: $this->created_at,
            updated_at: $this->updated_at,
            deletedAt: $this->deleted_at
        );
    }
}
