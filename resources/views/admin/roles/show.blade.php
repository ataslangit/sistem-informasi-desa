@extends('admin.layouts.app')

@section('title', 'Hak Akses Role: ' . $role->label)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2 text-xs text-slate-500 mb-1">
                <a href="{{ route('admin.roles.index') }}" class="hover:text-blue-600 transition">Role & Hak Akses</a>
                <span>&rsaquo;</span>
                <span class="font-bold text-slate-800">{{ $role->label }}</span>
            </div>
            <h2 class="text-xl font-bold text-slate-800 flex items-center space-x-2">
                <span>Konfigurasi Hak Akses: {{ $role->label }}</span>
                <span class="text-xs font-mono px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">({{ $role->name }})</span>
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">{{ $role->description }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.roles.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-semibold bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition shadow-2xs">
                &larr; Kembali
            </a>
        </div>
    </div>

    @if($role->name === 'superadmin')
        <div class="p-4 bg-purple-50 rounded-2xl border border-purple-200 flex items-center space-x-3 text-xs text-purple-900">
            <span class="text-xl">⚡</span>
            <div>
                <span class="font-bold block">Role Super Administrator</span>
                <span class="text-[11px] text-purple-700 block mt-0.5">Role ini memiliki wewenang mutlak atas seluruh fitur dan konfigurasi sistem. Hak akses krusial selalu terlindungi.</span>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Kolom Kiri: Matriks Hak Akses (8/12) -->
        <div class="lg:col-span-8 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
            <form action="{{ route('admin.roles.permissions.update', $role) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">Daftar Hak Akses (Permissions)</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Centang izin operasional yang diizinkan untuk pengguna dengan role ini.</p>
                    </div>
                    <div class="flex space-x-2">
                        <button type="button" onclick="toggleAllCheckboxes(true)" class="px-2.5 py-1 text-[11px] font-semibold text-blue-600 hover:bg-blue-50 rounded-lg transition">
                            Pilih Semua
                        </button>
                        <button type="button" onclick="toggleAllCheckboxes(false)" class="px-2.5 py-1 text-[11px] font-semibold text-slate-500 hover:bg-slate-100 rounded-lg transition">
                            Hapus Semua
                        </button>
                    </div>
                </div>

                @php
                    $rolePermissionIds = $role->permissions->pluck('id')->toArray();
                @endphp

                <div class="space-y-6">
                    @foreach($groupedPermissions as $groupName => $groupPerms)
                        <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/50 space-y-3">
                            <div class="flex items-center justify-between">
                                <h4 class="font-bold text-xs text-slate-800 uppercase tracking-wider flex items-center space-x-1.5">
                                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                    <span>{{ $groupName }}</span>
                                </h4>
                                <span class="text-[10px] text-slate-400 font-medium">
                                    {{ count($groupPerms) }} izin
                                </span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-1">
                                @foreach($groupPerms as $perm)
                                    <label class="flex items-start p-3 rounded-xl bg-white border border-slate-200 hover:border-blue-400 transition cursor-pointer select-none">
                                        <input 
                                            type="checkbox" 
                                            name="permissions[]" 
                                            value="{{ $perm->id }}" 
                                            {{ in_array($perm->id, $rolePermissionIds) ? 'checked' : '' }}
                                            class="perm-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-4 h-4 mt-0.5"
                                        >
                                        <div class="ml-2.5">
                                            <span class="block text-xs font-bold text-slate-800 leading-tight">{{ $perm->label }}</span>
                                            <span class="block text-[10px] text-slate-500 mt-0.5 leading-snug">{{ $perm->description }}</span>
                                            <span class="block font-mono text-[9px] text-slate-400 mt-1">{{ $perm->name }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pt-6 mt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.roles.index') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-800 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
                        Simpan Perubahan Hak Akses
                    </button>
                </div>
            </form>
        </div>

        <!-- Kolom Kanan: Daftar Pengguna dengan Role ini (4/12) -->
        <div class="lg:col-span-4 space-y-4">
            <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">
                        Pengguna Terdaftar ({{ $role->users->count() }})
                    </h3>
                    <a href="{{ route('admin.users.create') }}" class="text-[11px] font-semibold text-blue-600 hover:text-blue-800">
                        + Tambah
                    </a>
                </div>

                <div class="divide-y divide-slate-100 max-h-[500px] overflow-y-auto scrollbar-thin">
                    @forelse($role->users as $u)
                        <div class="py-2.5 flex items-center justify-between">
                            <div class="flex items-center space-x-2.5 min-w-0">
                                <div class="w-7 h-7 rounded-full bg-slate-100 text-slate-700 font-bold flex items-center justify-center text-xs shrink-0">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <span class="font-bold text-slate-800 text-xs block truncate">{{ $u->name }}</span>
                                    <span class="font-mono text-[10px] text-slate-400 block truncate">{{ $u->username }}</span>
                                </div>
                            </div>
                            <a href="{{ route('admin.users.edit', $u) }}" class="text-[11px] text-slate-400 hover:text-blue-600 font-semibold shrink-0 ml-2">
                                Edit &rsaquo;
                            </a>
                        </div>
                    @empty
                        <p class="py-4 text-center text-xs text-slate-400">Belum ada pengguna dengan role ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleAllCheckboxes(checked) {
        document.querySelectorAll('.perm-checkbox').forEach(cb => {
            cb.checked = checked;
        });
    }
</script>
@endsection
