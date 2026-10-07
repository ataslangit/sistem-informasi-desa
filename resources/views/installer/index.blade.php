@extends('installer.layout')

@section('title', 'Langkah 1: Persyaratan Sistem')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="border-b border-slate-100 pb-4">
        <h2 class="text-lg font-bold text-slate-800">Langkah 1: Pengecekan Persyaratan Server</h2>
        <p class="text-xs text-slate-500 mt-1">
            Sistem memeriksa kesesuaian versi PHP, ekstensi modul, dan izin tulis direktori untuk menjamin kelancaran operasional aplikasi desa.
        </p>
    </div>

    <!-- 1. Versi PHP -->
    <div class="space-y-3">
        <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-2">
            <span>⚙️</span>
            <span>Versi PHP Lingkungan</span>
        </h3>
        <div class="p-3.5 rounded-2xl border {{ $requirements['php']['status'] ? 'border-emerald-200 bg-emerald-50/50' : 'border-rose-200 bg-rose-50/50' }} flex items-center justify-between text-xs">
            <div>
                <span class="font-bold text-slate-800">PHP {{ $requirements['php']['current'] }}</span>
                <span class="text-slate-500 block text-[11px]">Dibutuhkan minimal PHP {{ $requirements['php']['required'] }}</span>
            </div>
            @if($requirements['php']['status'])
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                    ✓ Memenuhi Syarat
                </span>
            @else
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">
                    ✕ Tidak Memenuhi
                </span>
            @endif
        </div>
    </div>

    <!-- 2. Ekstensi PHP -->
    <div class="space-y-3">
        <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-2">
            <span>🧩</span>
            <span>Ekstensi PHP Wajib</span>
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
            @foreach($requirements['extensions'] as $ext)
                <div class="p-3 rounded-xl border {{ $ext['status'] ? 'border-slate-200 bg-slate-50/50' : 'border-rose-200 bg-rose-50/70' }} flex items-center justify-between text-xs">
                    <div class="min-w-0 pr-2">
                        <span class="font-mono font-bold text-slate-800 block truncate">{{ $ext['name'] }}</span>
                        <span class="text-[10px] text-slate-400 block truncate">{{ $ext['label'] }}</span>
                    </div>
                    @if($ext['status'])
                        <span class="text-emerald-600 font-bold text-sm shrink-0">✓</span>
                    @else
                        <span class="text-rose-600 font-bold text-sm shrink-0">✕</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- 3. Izin Direktori -->
    <div class="space-y-3">
        <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-2">
            <span>📁</span>
            <span>Hak Akses Tulis Direktori (Write Permissions)</span>
        </h3>
        <div class="space-y-2">
            @foreach($permissions['directories'] as $dir)
                <div class="p-3 rounded-xl border {{ $dir['status'] ? 'border-slate-200 bg-slate-50/50' : 'border-rose-200 bg-rose-50/70' }} flex items-center justify-between text-xs">
                    <div>
                        <span class="font-mono font-semibold text-slate-700 block">{{ $dir['path'] }}</span>
                        <span class="text-[10px] text-slate-400 block">{{ $dir['label'] }}</span>
                    </div>
                    @if($dir['status'])
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
                            Writable (Bisa Ditulis)
                        </span>
                    @else
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-800">
                            Not Writable (Terkunci)
                        </span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Navigasi Aksi -->
    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
        <span class="text-xs text-slate-400">
            @if($requirements['all_passed'] && $permissions['all_passed'])
                <span class="text-emerald-600 font-semibold">✓ Seluruh persyaratan sistem terpenuhi.</span>
            @else
                <span class="text-rose-600 font-semibold">⚠️ Mohon perbaiki komponen yang belum terpenuhi.</span>
            @endif
        </span>

        @if($requirements['all_passed'] && $permissions['all_passed'])
            <a href="{{ route('installer.database') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm flex items-center space-x-2">
                <span>Lanjutkan ke Konfigurasi Basis Data</span>
                <span>&rarr;</span>
            </a>
        @else
            <button disabled class="px-5 py-2.5 rounded-xl text-xs font-bold bg-slate-200 text-slate-400 cursor-not-allowed">
                Persyaratan Belum Lengkap
            </button>
        @endif
    </div>
</div>
@endsection
