@extends('admin.layouts.app')

@section('title', 'Manajemen Pengguna & Akun')

@section('content')
<div class="space-y-6">
    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Manajemen Pengguna & Role</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola akun aparatur desa, kepala desa, ketua RT, dan hak akses otorisasi sistem.</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition space-x-1.5 border border-slate-300">
                <span>🛡️</span>
                <span>Role & Hak Akses</span>
            </a>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm space-x-1.5">
                <span>➕</span>
                <span>Tambah Pengguna</span>
            </a>
        </div>
    </div>

    <!-- Statistik Ringkasan Pengguna -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Akun</span>
            <span class="text-xl font-black text-slate-800 mt-1 block">{{ number_format($stats['total']) }}</span>
            <span class="text-[10px] text-emerald-600 font-medium">{{ $stats['active'] }} Aktif</span>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-[10px] font-bold text-purple-600 uppercase tracking-wider block">Superadmin</span>
            <span class="text-xl font-black text-slate-800 mt-1 block">{{ number_format($stats['superadmin']) }}</span>
            <span class="text-[10px] text-slate-400 font-medium">Administrator</span>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-wider block">Kepala Desa</span>
            <span class="text-xl font-black text-slate-800 mt-1 block">{{ number_format($stats['kades']) }}</span>
            <span class="text-[10px] text-slate-400 font-medium">TTE & Kebijakan</span>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider block">Perangkat</span>
            <span class="text-xl font-black text-slate-800 mt-1 block">{{ number_format($stats['perangkat']) }}</span>
            <span class="text-[10px] text-slate-400 font-medium">Staf Pelayanan</span>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider block">Ketua RT</span>
            <span class="text-xl font-black text-slate-800 mt-1 block">{{ number_format($stats['rt']) }}</span>
            <span class="text-[10px] text-slate-400 font-medium">Verifikator RT</span>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Warga</span>
            <span class="text-xl font-black text-slate-800 mt-1 block">{{ number_format($stats['warga']) }}</span>
            <span class="text-[10px] text-slate-400 font-medium">Layanan Mandiri</span>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div class="sm:col-span-2">
                <input 
                    type="text" 
                    name="keyword" 
                    value="{{ $keyword }}" 
                    placeholder="Cari nama, username, atau email pengguna..." 
                    class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
            </div>
            <div>
                <select name="role" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                    <option value="">Semua Role</option>
                    @foreach($roles as $r)
                        <option value="{{ $r->name }}" {{ $roleFilter === $r->name ? 'selected' : '' }}>
                            {{ $r->label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex space-x-2">
                <select name="status" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                    <option value="">Semua Status</option>
                    <option value="active" {{ $statusFilter === 'active' ? 'selected' : '' }}>Akun Aktif</option>
                    <option value="inactive" {{ $statusFilter === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-slate-800 text-white font-semibold text-xs rounded-xl hover:bg-slate-700 transition">
                    Filter
                </button>
                @if($keyword || $roleFilter || $statusFilter)
                    <a href="{{ route('admin.users.index') }}" class="px-3 py-2 bg-slate-100 text-slate-600 font-semibold text-xs rounded-xl hover:bg-slate-200 transition flex items-center justify-center" title="Reset filter">
                        &times;
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Daftar Pengguna -->
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200 text-[11px]">
                        <th class="py-3 px-4">Pengguna</th>
                        <th class="py-3 px-4">Username & Email</th>
                        <th class="py-3 px-4">Role Sistem</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Terdaftar</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50">
                            <td class="py-3 px-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-9 h-9 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center font-bold text-slate-700 shrink-0 text-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="flex items-center space-x-1.5">
                                            <span class="font-bold text-slate-800 block truncate">{{ $user->name }}</span>
                                            @if($user->id === auth()->id())
                                                <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-amber-100 text-amber-800">Anda</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center flex-wrap gap-1.5 mt-0.5">
                                            @if($user->nik)
                                                <span class="font-mono text-slate-600 bg-slate-100 px-1.5 py-0.5 rounded text-[10px] border border-slate-200" title="NIK Warga / Aparatur (Disamarkan PDP)">
                                                    🪪 {{ $user->masked_nik }}
                                                </span>
                                            @endif
                                            @if($user->getAssignedRt())
                                                <span class="text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded text-[10px] font-semibold border border-emerald-200">
                                                    RT {{ $user->getAssignedRt() }}
                                                </span>
                                            @endif
                                            @if($user->metadata['jabatan'] ?? ($user->metadata['phone'] ?? null))
                                                <span class="text-[11px] text-slate-400 block truncate">
                                                    {{ $user->metadata['jabatan'] ?? $user->metadata['phone'] }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-mono text-slate-700 block font-medium">{{ $user->username }}</span>
                                <span class="text-slate-400 text-[11px] block">{{ $user->email }}</span>
                            </td>
                            <td class="py-3 px-4">
                                @forelse($user->roles as $role)
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $user->role_badge_class }}">
                                        {{ $role->label }}
                                    </span>
                                @empty
                                    <span class="text-slate-400 text-[11px]">Tanpa Role</span>
                                @endforelse
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button 
                                        type="submit" 
                                        {{ $user->id === auth()->id() ? 'disabled' : '' }}
                                        title="{{ $user->id === auth()->id() ? 'Tidak dapat menonaktifkan akun sendiri' : 'Klik untuk mengubah status akun' }}"
                                        class="px-2.5 py-1 rounded-full text-[10px] font-bold transition flex items-center space-x-1 {{ $user->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100' }}"
                                    >
                                        <span class="w-1.5 h-1.5 rounded-full {{ $user->is_active ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                        <span>{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                    </button>
                                </form>
                            </td>
                            <td class="py-3 px-4 text-slate-500 text-[11px] whitespace-nowrap">
                                {{ $user->created_at ? $user->created_at->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="py-3 px-4 text-center whitespace-nowrap space-x-2">
                                <a 
                                    href="{{ route('admin.users.edit', $user) }}" 
                                    class="text-blue-600 hover:text-blue-800 font-semibold text-[11px] px-2 py-1 rounded bg-blue-50 hover:bg-blue-100 transition border border-blue-200"
                                >
                                    ✏️ Edit
                                </a>

                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus akun pengguna {{ addslashes($user->name) }}? Tindakan ini tidak dapat dibatalkan.');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold text-[11px] px-2 py-1 rounded hover:bg-rose-50 transition">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">
                                Tidak ada akun pengguna yang sesuai dengan kriteria filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 bg-white border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
