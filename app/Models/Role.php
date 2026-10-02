<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'name',
        'label',
        'description',
    ];

    /**
     * Relasi ke permission yang dimiliki role ini.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id');
    }

    /**
     * Relasi ke user yang memiliki role ini.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_roles', 'role_id', 'user_id');
    }

    /**
     * Memberikan permission ke role.
     */
    public function givePermissionTo(Permission|string $permission): self
    {
        $perm = is_string($permission)
            ? Permission::firstOrCreate(['name' => $permission], ['label' => ucfirst(str_replace('.', ' ', $permission))])
            : $permission;

        $this->permissions()->syncWithoutDetaching([$perm->id]);

        return $this;
    }
}
