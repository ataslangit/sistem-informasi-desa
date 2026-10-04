@extends('admin.layouts.app')

@section('title', 'Detail Log Audit #' . $auditLog->id)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.audit-logs.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="text-xl font-bold text-slate-800">Detail Audit Trail #{{ $auditLog->id }}</h2>
                <p class="text-xs text-slate-500">Informasi lengkap perubahan data dan komparasi nilai lama vs baru.</p>
            </div>
        </div>
    </div>

    <!-- Metadata Card -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">Informasi Metadata</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs">
            <div>
                <span class="block text-slate-400 font-semibold mb-1">Peristiwa (Event)</span>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border
                    @if(str_contains($auditLog->event_name, 'Created')) bg-emerald-50 text-emerald-700 border-emerald-200
                    @elseif(str_contains($auditLog->event_name, 'Updated')) bg-amber-50 text-amber-700 border-amber-200
                    @elseif(str_contains($auditLog->event_name, 'Deleted')) bg-rose-50 text-rose-700 border-rose-200
                    @else bg-blue-50 text-blue-700 border-blue-200 @endif">
                    {{ $auditLog->event_name }}
                </span>
            </div>
            <div>
                <span class="block text-slate-400 font-semibold mb-1">Entitas Target</span>
                <div class="font-bold text-slate-800 text-sm">
                    {{ ucfirst($auditLog->entity_type) }} <span class="font-mono text-xs text-blue-600">#{{ $auditLog->entity_id }}</span>
                </div>
            </div>
            <div>
                <span class="block text-slate-400 font-semibold mb-1">Waktu Kejadian</span>
                <div class="font-medium text-slate-700">
                    {{ $auditLog->created_at ? $auditLog->created_at->translatedFormat('l, d F Y - H:i:s') : '-' }}
                </div>
            </div>
            <div>
                <span class="block text-slate-400 font-semibold mb-1">Pelaku (Actor)</span>
                @if($auditLog->actor)
                    <div class="font-bold text-slate-800">{{ $auditLog->actor->name }}</div>
                    <div class="text-[11px] text-slate-500">{{ $auditLog->actor->email }}</div>
                @else
                    <span class="text-slate-400 italic">Sistem / Background Process</span>
                @endif
            </div>
            <div>
                <span class="block text-slate-400 font-semibold mb-1">Alamat IP</span>
                <div class="font-mono text-slate-700">{{ $auditLog->ip_address ?? '-' }}</div>
            </div>
            <div>
                <span class="block text-slate-400 font-semibold mb-1">User Agent (Browser / Device)</span>
                <div class="text-slate-600 truncate text-[11px]" title="{{ $auditLog->user_agent }}">
                    {{ $auditLog->user_agent ?? '-' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Perbandingan Nilai (Diff) -->
    @php
        $oldValues = $auditLog->old_values ?? [];
        $newValues = $auditLog->new_values ?? [];
        $allKeys = array_unique(array_merge(array_keys($oldValues), array_keys($newValues)));
        sort($allKeys);
    @endphp

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Perbandingan Perubahan Kolom Data</h3>
            <span class="text-xs text-slate-500 font-normal">Menampilkan {{ count($allKeys) }} atribut terdampak</span>
        </div>

        @if(empty($allKeys))
            <div class="p-8 text-center text-slate-400 text-xs">
                Tidak ada data nilai lama atau baru yang terekam untuk event ini.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            <th class="py-3 px-4 w-1/4">Nama Kolom (Field)</th>
                            <th class="py-3 px-4 w-5/12 bg-rose-50/50 text-rose-800">Nilai Sebelum (Lama)</th>
                            <th class="py-3 px-4 w-5/12 bg-emerald-50/50 text-emerald-800">Nilai Sesudah (Baru)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @foreach($allKeys as $key)
                            @php
                                $old = $oldValues[$key] ?? null;
                                $new = $newValues[$key] ?? null;
                                $isDifferent = json_encode($old) !== json_encode($new);
                            @endphp
                            <tr class="{{ $isDifferent ? 'bg-amber-50/20' : '' }}">
                                <td class="py-3 px-4 font-mono font-medium text-slate-700">
                                    {{ $key }}
                                </td>
                                <td class="py-3 px-4 font-mono text-[11px] text-slate-600 bg-rose-50/20">
                                    @if(is_null($old))
                                        <span class="text-slate-300 italic">null</span>
                                    @elseif(is_bool($old))
                                        <span class="font-bold {{ $old ? 'text-emerald-600' : 'text-rose-600' }}">{{ $old ? 'true' : 'false' }}</span>
                                    @elseif(is_array($old))
                                        <pre class="whitespace-pre-wrap">{{ json_encode($old, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    @else
                                        {{ (string) $old }}
                                    @endif
                                </td>
                                <td class="py-3 px-4 font-mono text-[11px] text-slate-800 bg-emerald-50/20 font-semibold">
                                    @if(is_null($new))
                                        <span class="text-slate-300 italic">null</span>
                                    @elseif(is_bool($new))
                                        <span class="font-bold {{ $new ? 'text-emerald-600' : 'text-rose-600' }}">{{ $new ? 'true' : 'false' }}</span>
                                    @elseif(is_array($new))
                                        <pre class="whitespace-pre-wrap">{{ json_encode($new, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    @else
                                        {{ (string) $new }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
