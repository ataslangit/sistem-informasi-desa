@extends('admin.layouts.app')

@section('title', 'Audit Trail Sistem')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Audit Trail & Rekam Jejak Sistem</h2>
            <p class="text-xs text-slate-500 mt-1">Riwayat seluruh perubahan data master, kependudukan, dan pengaturan yang terekam otomatis oleh Audit Engine.</p>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.audit-logs.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div class="sm:col-span-2">
                <input 
                    type="text" 
                    name="keyword" 
                    value="{{ $keyword }}" 
                    placeholder="Cari ID Entitas, Event, IP, atau Nama Pelaku..." 
                    class="w-full px-4 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
            </div>
            <div>
                <select name="entity_type" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="">Semua Tipe Entitas</option>
                    @foreach($entityTypes as $type)
                        <option value="{{ $type }}" {{ $entityType === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-700 transition">
                    Filter
                </button>
                @if($keyword || $entityType || $eventName)
                    <a href="{{ route('admin.audit-logs.index') }}" class="px-3 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-semibold hover:bg-slate-200 transition flex items-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Audit Logs -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-3 px-4">Waktu</th>
                        <th class="py-3 px-4">Peristiwa (Event)</th>
                        <th class="py-3 px-4">Entitas & ID</th>
                        <th class="py-3 px-4">Pelaku (Actor)</th>
                        <th class="py-3 px-4">IP Address</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse($auditLogs as $log)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3 px-4 font-mono text-[11px] text-slate-500 whitespace-nowrap">
                                {{ $log->created_at ? $log->created_at->format('d/m/Y H:i:s') : '-' }}
                            </td>
                            <td class="py-3 px-4">
                                @php
                                    $badgeColor = match(true) {
                                        str_contains($log->event_name, 'Created') => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        str_contains($log->event_name, 'Updated') => 'bg-amber-50 text-amber-700 border-amber-200',
                                        str_contains($log->event_name, 'Deleted') => 'bg-rose-50 text-rose-700 border-rose-200',
                                        default => 'bg-blue-50 text-blue-700 border-blue-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold border {{ $badgeColor }}">
                                    {{ $log->event_name }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-semibold text-slate-800">{{ ucfirst($log->entity_type) }}</span>
                                <span class="text-slate-500 text-[11px] font-mono">#{{ $log->entity_id }}</span>
                            </td>
                            <td class="py-3 px-4">
                                @if($log->actor)
                                    <div class="font-medium text-slate-800">{{ $log->actor->name }}</div>
                                    <div class="text-[10px] text-slate-500">{{ $log->actor->email }}</div>
                                @else
                                    <span class="text-slate-400 italic">Sistem / Background</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 font-mono text-[11px] text-slate-500">
                                {{ $log->ip_address ?? '-' }}
                            </td>
                            <td class="py-3 px-4 text-center whitespace-nowrap">
                                <a href="{{ route('admin.audit-logs.show', $log->id) }}" class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-semibold hover:bg-blue-100 transition space-x-1">
                                    <span>🔍</span>
                                    <span>Detail</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">
                                Belum ada riwayat log audit yang tersimpan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($auditLogs->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50">
                {{ $auditLogs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
