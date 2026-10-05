<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Throwable;
use Ttpryg\AuditEngine\Services\AuditService;

trait Auditable
{
    /**
     * Boot auditable trait to listen for Eloquent events.
     */
    public static function bootAuditable(): void
    {
        static::created(function (Model $model): void {
            /** @var Auditable|Model $model */
            $model->auditEvent('Created', null, $model->filterAuditAttributes($model->getAttributes()));
        });

        static::updated(function (Model $model): void {
            /** @var Auditable|Model $model */
            $changes = $model->getChanges();
            if (empty($changes)) {
                return;
            }

            $old = Arr::only($model->getOriginal(), array_keys($changes));
            $new = $changes;

            $model->auditEvent(
                'Updated',
                $model->filterAuditAttributes($old),
                $model->filterAuditAttributes($new)
            );
        });

        static::deleted(function (Model $model): void {
            /** @var Auditable|Model $model */
            $model->auditEvent(
                'Deleted',
                $model->filterAuditAttributes($model->getOriginal()),
                null
            );
        });
    }

    /**
     * Dapatkan identifier tipe entitas.
     */
    public function getAuditEntityType(): string
    {
        return strtolower(class_basename(static::class));
    }

    /**
     * Dapatkan kolom yang dikecualikan dari audit trail.
     */
    public function getAuditExclude(): array
    {
        return property_exists($this, 'auditExclude')
            ? $this->auditExclude
            : ['created_at', 'updated_at', 'deleted_at', 'remember_token', 'password'];
    }

    /**
     * Filter atribut dari pengecualian audit.
     */
    public function filterAuditAttributes(array $attributes): array
    {
        return Arr::except($attributes, $this->getAuditExclude());
    }

    /**
     * Catat event audit via AuditService.
     */
    protected function auditEvent(string $action, ?array $oldValues, ?array $newValues): void
    {
        try {
            if (! app()->bound(AuditService::class)) {
                return;
            }

            /** @var AuditService $auditService */
            $auditService = app(AuditService::class);
            $eventName = class_basename(static::class).$action;
            $entityType = $this->getAuditEntityType();
            $entityId = (string) $this->getKey();
            $actorId = auth()->id() ?? null;

            $ipAddress = null;
            $userAgent = null;
            if (app()->bound('request')) {
                $req = request();
                $ipAddress = $req?->ip();
                $userAgent = $req?->userAgent();
            }

            $auditService->log(
                eventName: $eventName,
                entityType: $entityType,
                entityId: $entityId,
                oldValues: $oldValues,
                newValues: $newValues,
                actorId: $actorId,
                ipAddress: $ipAddress,
                userAgent: $userAgent
            );
        } catch (Throwable $e) {
            Log::warning("Gagal mencatat audit log: {$e->getMessage()}", [
                'entity' => static::class,
                'id' => $this->getKey(),
            ]);
        }
    }

    /**
     * Catat aktivitas pembacaan atau akses data pribadi sensitif (UU PDP No. 27/2022).
     *
     * @param  string  $action  Nama aksi pembacaan/akses, misal: 'Viewed', 'Exported'
     * @param  array<string, mixed>  $details  Detail kontekstual rekam jejak akses
     */
    public function logAccess(string $action = 'Viewed', array $details = []): void
    {
        try {
            if (! app()->bound(AuditService::class)) {
                return;
            }

            /** @var AuditService $auditService */
            $auditService = app(AuditService::class);
            $eventName = class_basename(static::class).$action;
            $entityType = $this->getAuditEntityType();
            $entityId = (string) $this->getKey();
            $actorId = auth()->id() ?? null;

            $ipAddress = null;
            $userAgent = null;
            if (app()->bound('request')) {
                $req = request();
                $ipAddress = $req?->ip();
                $userAgent = $req?->userAgent();
            }

            $auditService->log(
                eventName: $eventName,
                entityType: $entityType,
                entityId: $entityId,
                oldValues: null,
                newValues: ! empty($details) ? $details : ['accessed_at' => now()->toIso8601String()],
                actorId: $actorId,
                ipAddress: $ipAddress,
                userAgent: $userAgent
            );
        } catch (Throwable $e) {
            Log::warning("Gagal mencatat audit log akses: {$e->getMessage()}", [
                'entity' => static::class,
                'id' => $this->getKey(),
            ]);
        }
    }

    /**
     * Relasi ke riwayat log audit entitas ini.
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class, 'entity_id')
            ->where('entity_type', $this->getAuditEntityType())
            ->orderBy('created_at', 'desc');
    }
}
