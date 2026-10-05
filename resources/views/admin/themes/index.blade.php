@extends('admin.layouts.app')

@section('title', 'Manajemen Tema Publik')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Manajemen Tema Portal Publik</h2>
            <p class="text-xs text-slate-500 mt-1">Pilih dan terapkan tampilan portal depan desa tanpa mengganggu sistem administrasi dan data internal.</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-emerald-600 text-white hover:bg-emerald-700 transition shadow-sm space-x-1">
                <span>🌐</span>
                <span>Buka Portal Publik</span>
            </a>
        </div>
    </div>

    <!-- Active Theme Card Banner -->
    <div class="bg-gradient-to-r from-blue-700 to-indigo-800 rounded-2xl p-6 text-white shadow-md flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/20 text-white border border-white/30 mb-2">
                ✨ Tema Aktif Saat Ini
            </span>
            <h3 class="text-xl font-black tracking-tight">{{ $availableThemes[$activeTheme]['name'] ?? ucfirst($activeTheme) }}</h3>
            <p class="text-xs text-blue-100 mt-1 max-w-xl">
                {{ $availableThemes[$activeTheme]['description'] ?? 'Tema portal publik yang sedang digunakan oleh pengunjung warga desa.' }}
            </p>
        </div>
        <div class="text-xs font-mono bg-black/20 px-4 py-2 rounded-xl border border-white/10 self-start sm:self-center">
            Folder: /resources/views/themes/{{ $activeTheme }}
        </div>
    </div>

    <!-- Themes Grid -->
    <div>
        <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-4">Tema Terpasang di Sistem</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($availableThemes as $folder => $theme)
                @php
                    $isActive = ($folder === $activeTheme);
                @endphp
                <div class="bg-white rounded-2xl border {{ $isActive ? 'border-blue-500 ring-2 ring-blue-500/20 shadow-md' : 'border-slate-200 shadow-sm' }} overflow-hidden flex flex-col transition hover:shadow-md">
                    <!-- Screenshot / Preview Thumbnail -->
                    <div class="relative h-44 bg-slate-100 overflow-hidden">
                        <img 
                            src="{{ $theme['screenshot'] ?? 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=600&q=80' }}" 
                            alt="{{ $theme['name'] }}" 
                            class="w-full h-full object-cover"
                        >
                        @if($isActive)
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-600 text-white shadow-md border border-white/20">
                                    ✓ Sedang Aktif
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <h4 class="font-bold text-slate-800 text-base">{{ $theme['name'] }}</h4>
                                <span class="text-[10px] font-mono font-semibold px-2 py-0.5 rounded bg-slate-100 text-slate-600">v{{ $theme['version'] ?? '1.0' }}</span>
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                {{ $theme['description'] }}
                            </p>
                            <div class="mt-3 text-[11px] text-slate-400">
                                Pengembang: <span class="font-medium text-slate-600">{{ $theme['author'] ?? 'SiDesa' }}</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[10px] font-mono text-slate-400">themes/{{ $folder }}</span>
                            @if($isActive)
                                <button type="button" disabled class="px-4 py-2 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 cursor-default">
                                    Tema Aktif
                                </button>
                            @else
                                <form action="{{ route('admin.themes.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="theme" value="{{ $folder }}">
                                    <button type="submit" class="px-4 py-2 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
                                        Aktifkan Tema Ini
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
