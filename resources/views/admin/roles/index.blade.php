@extends('admin.layouts.app')

@section('title', 'Manajemen Role & Hak Akses')

@section('content')
<div class="space-y-6">
    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Role & Hak Akses (Otorisasi)</h2>
            <p class="text-xs text-slate-500 mt-1">Konfigurasi peran dan wewenang operasional untuk tiap tingkatan aparatur dan warga desa.</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition space-x-1.5 border border-slate-300">
                <span>👥</span>
                <span>Daftar Pengguna</span>
            </a>
        </div>
    </div>

    <!-- Navigasi Tab Pengguna & Role -->
    <div class="flex items-center space-x-2 border-b border-slate-200">
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 text-xs font-semibold text-slate-500 hover:text-slate-700 border-b-2 border-transparent hover:border-slate-300 transition">
            👥 Pengguna Sistem
        </a>
        <a href="{{ route('admin.roles.index') }}" class="px-4 py-2.5 text-xs font-bold text-blue-600 border-b-2 border-blue-600 transition">
            🛡️ Role & Hak Akses (RBAC)
        </a>
    </div>

    <!-- Grid Kartu Role -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($roles as $role)
            @php
                $badgeColor = match ($role->name) {
                    'superadmin' => 'bg-purple-50 text-purple-700 border-purple-200',
                    'kades' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                    'perangkat' => 'bg-blue-50 text-blue-700 border-blue-200',
                    'rt' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                    'warga' => 'bg-slate-50 text-slate-700 border-slate-200',
                    default => 'bg-gray-50 text-gray-700 border-gray-200',
                };
                $icon = match ($role->name) {
                    'superadmin' => '⚡',
                    'kades' => '🏛️',
                    'perangkat' => '💼',
                    'rt' => '🏘️',
                    'warga' => '👤',
                    default => '🛡️',
                };
            @endphp
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-2xl">{{ $icon }}</span>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $badgeColor }}">
                            {{ $role->users_count }} Pengguna Aktif
                        </span>
                    </div>

                    <div>
                        <h3 class="font-bold text-slate-800 text-sm flex items-center space-x-1.5">
                            <span>{{ $role->label }}</span>
                            <span class="text-[11px] font-mono text-slate-400">({{ $role->name }})</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            {{ $role->description }}
                        </p>
                    </div>

                    <!-- Ringkasan Permissions -->
                    <div class="pt-3 border-t border-slate-100">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                Hak Akses Terpasang
                            </span>
                            <span class="text-[11px] font-bold text-slate-700">
                                {{ $role->permissions->count() }} / {{ $permissions->count() }}
                            </span>
                        </div>
                        <div class="flex flex-wrap gap-1.5 max-h-24 overflow-y-auto scrollbar-none">
                            @forelse($role->permissions->take(6) as $perm)
                                <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600">
                                    {{ $perm->label }}
                                </span>
                            @empty
                                <span class="text-[11px] text-slate-400 italic">Belum ada hak akses khusus.</span>
                            @endforelse
                            @if($role->permissions->count() > 6)
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-200 text-slate-700">
                                    +{{ $role->permissions->count() - 6 }} lainnya
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="pt-5 mt-4 border-t border-slate-100">
                    <a 
                        href="{{ route('admin.roles.show', $role) }}" 
                        class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-slate-50 hover:bg-slate-100 text-slate-700 transition border border-slate-200 space-x-1.5"
                    >
                        <span>⚙️</span>
                        <span>Konfigurasi Hak Akses</span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
