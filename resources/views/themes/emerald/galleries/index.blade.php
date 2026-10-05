@extends('themes.emerald.layouts.app')

@section('title', 'Album Galeri & Dokumentasi Kegiatan - ' . \App\Models\Setting::get('village_name', 'Desa Sukamaju'))

@section('content')
<!-- Banner Hero Hijau Zamrud (Jumbotron Galeri Tema Emerald) -->
<section class="relative px-4 sm:px-6 lg:px-8 pt-6 pb-4">
    <div class="max-w-7xl mx-auto">
        <div class="relative rounded-3xl overflow-hidden shadow-2xl shadow-emerald-950/20 bg-gradient-to-br from-emerald-950 via-emerald-900 to-teal-950 py-12 sm:py-16 px-6 sm:px-12 text-white">
            <!-- Background Landscape Overlay -->
            <div class="absolute inset-0 bg-cover bg-center opacity-15 mix-blend-overlay pointer-events-none" style="background-image: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=1600&q=80');"></div>
            <!-- Radial Glow Ornaments -->
            <div class="absolute -right-10 -bottom-10 w-80 h-80 bg-emerald-400/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-10 -top-10 w-72 h-72 bg-teal-300/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-4xl space-y-4">
                <!-- Breadcrumbs Cerah Kontras Tinggi -->
                <nav class="flex flex-wrap items-center gap-2 text-xs text-emerald-300 font-medium">
                    <a href="/" class="hover:text-white transition flex items-center gap-1">
                        <span>🏡</span>
                        <span>Beranda</span>
                    </a>
                    <span class="text-emerald-500">/</span>
                    <span class="text-white font-semibold">Galeri & Potret Desa</span>
                </nav>

                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-200 text-xs font-bold backdrop-blur-md">
                    <span>📸</span>
                    <span>Dokumentasi Visual & Potret Kehidupan Desa</span>
                </div>

                <!-- Judul Halaman Putih Kontras Tinggi -->
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight drop-shadow-sm">
                    Galeri Foto Desa & Potret Kegiatan
                </h1>

                <p class="text-sm sm:text-base lg:text-lg text-emerald-100/90 leading-relaxed font-normal max-w-3xl">
                    Koleksi album dokumentasi foto pembangunan, kegiatan sosial kemasyarakatan, adat budaya, serta keindahan potensi alam {{ \App\Models\Setting::get('village_name', 'Desa Sukamaju') }}.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Album Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($galleries as $album)
            @php
                $photoCount = $album->photos_count ?? $album->photos->count();
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 group flex flex-col justify-between">
                <div>
                    <!-- Album Cover Container -->
                    <a href="{{ route('galleries.show', $album->slug) }}" class="block relative h-64 bg-slate-100 overflow-hidden group-hover:opacity-95 transition">
                        <img 
                            src="{{ $album->cover_image }}" 
                            alt="{{ $album->title }}" 
                            class="w-full h-full object-cover transition duration-500 group-hover:scale-105"
                        >
                        <!-- Overlay Gradient -->
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-80 group-hover:opacity-60 transition"></div>
                        
                        <!-- Badge Jumlah Foto -->
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-900/75 text-white backdrop-blur-sm border border-white/20 shadow-sm space-x-1.5">
                                <span>🖼️</span>
                                <span>{{ $photoCount }} Foto</span>
                            </span>
                        </div>

                        <!-- Badge Tanggal Rilis -->
                        <div class="absolute bottom-3 left-3 text-xs text-white/90 font-medium flex items-center space-x-1">
                            <span>📅</span>
                            <span>{{ optional($album->published_at)->translatedFormat('d M Y') }}</span>
                        </div>
                    </a>

                    <!-- Album Info -->
                    <div class="p-6">
                        <h3 class="font-bold text-slate-800 text-lg leading-snug mb-2 group-hover:text-sky-600 transition">
                            <a href="{{ route('galleries.show', $album->slug) }}">
                                {{ $album->title }}
                            </a>
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 line-clamp-2 leading-relaxed">
                            {{ $album->summary }}
                        </p>
                    </div>
                </div>

                <!-- Footer Card -->
                <div class="px-6 pb-6 pt-0">
                    <a 
                        href="{{ route('galleries.show', $album->slug) }}" 
                        class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-bold bg-sky-50 text-sky-700 hover:bg-sky-600 hover:text-white transition group-hover:bg-sky-600 group-hover:text-white border border-sky-200 group-hover:border-transparent space-x-2"
                    >
                        <span>Buka Album</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-slate-400 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                <div class="text-5xl mb-3">🖼️</div>
                <h3 class="text-base font-bold text-slate-700">Belum ada album galeri foto</h3>
                <p class="text-xs text-slate-400 mt-1">Dokumentasi kegiatan dan album foto desa akan segera ditambahkan di sini.</p>
            </div>
        @endforelse
    </div>

    @if($galleries->hasPages())
        <div class="mt-12">
            {{ $galleries->links() }}
        </div>
    @endif
</div>
@endsection
