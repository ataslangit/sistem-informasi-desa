@extends('admin.layouts.app')

@section('title', 'Dashboard Utama')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-blue-700 via-indigo-700 to-blue-900 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/20 backdrop-blur-sm text-blue-100 mb-3">
                Selamat Datang di SiDesa
            </span>
            <h2 class="text-2xl font-bold">Halo, {{ auth()->user()->name }}! 👋</h2>
            <p class="text-blue-100 text-sm mt-1 max-w-xl">
                Anda masuk sebagai <strong class="text-white">{{ auth()->user()->roles->pluck('label')->implode(', ') }}</strong>. Kelola administrasi kependudukan dan pelayanan warga desa dengan cepat, akurat, dan transparan.
            </p>
        </div>
        <div class="absolute right-4 bottom-0 opacity-10 text-9xl select-none">
            🏛️
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl font-bold">
                👥
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Penduduk</p>
                <h3 class="text-2xl font-extrabold text-slate-800">1,420</h3>
                <span class="text-[11px] text-emerald-600 font-medium">Buku Induk Desa</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl font-bold">
                🏠
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kepala Keluarga</p>
                <h3 class="text-2xl font-extrabold text-slate-800">415</h3>
                <span class="text-[11px] text-emerald-600 font-medium">Terdaftar Aktif</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl font-bold">
                ✉️
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Permohonan Surat</p>
                <h3 class="text-2xl font-extrabold text-slate-800">8</h3>
                <span class="text-[11px] text-amber-600 font-medium">Menunggu Verifikasi</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl font-bold">
                🎨
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Tema Aktif</p>
                <h3 class="text-lg font-extrabold text-slate-800 uppercase">{{ active_theme() }}</h3>
                <span class="text-[11px] text-purple-600 font-medium">Portal Web Publik</span>
            </div>
        </div>
    </div>

    <!-- Info Role & Hak Akses Detail -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
        <h3 class="text-base font-bold text-slate-800 mb-3 flex items-center space-x-2">
            <span>🛡️</span>
            <span>Informasi Hak Akses Anda (RBAC)</span>
        </h3>
        <div class="space-y-3">
            <div class="flex items-center space-x-2">
                <span class="text-xs font-semibold text-slate-600">Role Terpasang:</span>
                @foreach(auth()->user()->roles as $role)
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                        {{ $role->label }} ({{ $role->name }})
                    </span>
                @endforeach
            </div>

            <div>
                <span class="text-xs font-semibold text-slate-600 block mb-2">Daftar Izin (Permissions):</span>
                <div class="flex flex-wrap gap-2">
                    @forelse(auth()->user()->getAllPermissions() as $perm)
                        <span class="px-2 py-0.5 rounded-md text-[11px] font-medium bg-slate-100 text-slate-700 border border-slate-200">
                            {{ $perm->label }} ({{ $perm->name }})
                        </span>
                    @empty
                        <span class="text-xs text-slate-400 italic">Tidak ada permission khusus.</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
