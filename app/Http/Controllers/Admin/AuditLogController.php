<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Menampilkan daftar riwayat audit log.
     */
    public function index(Request $request): View
    {
        $keyword = $request->input('keyword');
        $entityType = $request->input('entity_type');
        $eventName = $request->input('event_name');

        $query = AuditLog::with('actor')->orderByDesc('id');

        if ($entityType) {
            $query->where('entity_type', $entityType);
        }

        if ($eventName) {
            $query->where('event_name', 'like', "%{$eventName}%");
        }

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('entity_id', 'like', "%{$keyword}%")
                    ->orWhere('event_name', 'like', "%{$keyword}%")
                    ->orWhere('ip_address', 'like', "%{$keyword}%")
                    ->orWhereHas('actor', function ($actorQuery) use ($keyword) {
                        $actorQuery->where('name', 'like', "%{$keyword}%")
                            ->orWhere('email', 'like', "%{$keyword}%");
                    });
            });
        }

        $auditLogs = $query->paginate(20)->withQueryString();

        $entityTypes = AuditLog::select('entity_type')
            ->distinct()
            ->pluck('entity_type');

        return view('admin.audit_logs.index', compact('auditLogs', 'entityTypes', 'keyword', 'entityType', 'eventName'));
    }

    /**
     * Menampilkan detail dan komparasi perubahan log audit.
     */
    public function show(AuditLog $auditLog): View
    {
        $auditLog->load('actor');

        return view('admin.audit_logs.show', compact('auditLog'));
    }
}
