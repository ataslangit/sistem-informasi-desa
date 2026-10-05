@extends('themes.emerald.layouts.app')

@section('title', ($currentCategory ? $currentCategory->name . ' - ' : '') . 'Kabar & Berita - ' . \App\Models\Setting::get('village_name', 'Desa Sukamaju'))

@section('content')
<!-- Banner Hero Hijau Zamrud (Jumbotron Warta & Berita Tema Emerald) -->
<section class="relative px-4 sm:px-6 lg:px-8 pt-6 pb-4">
    <div class="max-w-7xl mx-auto">
        <div class="relative rounded-3xl overflow-hidden shadow-2xl shadow-emerald-950/20 bg-gradient-to-br from-emerald-950 via-emerald-900 to-teal-950 py-12 sm:py-16 px-6 sm:px-12 text-white">
            <!-- Tekstur Lanskap Alam Halus di Latar Belakang -->
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
                    <span class="text-white font-semibold">Warta & Kabar Desa</span>
                    @if($currentCategory)
                        <span class="text-emerald-500">/</span>
                        <span class="text-emerald-300 font-bold">{{ $currentCategory->name }}</span>
                    @endif
                </nav>

                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-200 text-xs font-bold backdrop-blur-md">
                    <span>📰</span>
                    <span>Warta Resmi & Dokumentasi Desa Sukamaju</span>
                </div>

                <!-- Judul Halaman Putih Kontras Tinggi -->
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight drop-shadow-sm">
                    @if($currentCategory)
                        Kategori: {{ $currentCategory->name }}
                    @elseif($search)
                        Hasil Pencarian: "{{ $search }}"
                    @else
                        Kabar & Warta Terkini Desa
                    @endif
                </h1>

                <p class="text-sm sm:text-base lg:text-lg text-emerald-100/90 leading-relaxed font-normal max-w-3xl">
                    Informasi kegiatan, pengumuman publik, serta transparansi pembangunan desa yang asri, mandiri, dan berkelanjutan.
                </p>

                <!-- Search Form Emerald -->
                <div class="pt-4 max-w-xl">
                    <form action="{{ route('articles.index') }}" method="GET" class="flex gap-2 bg-white/10 backdrop-blur-md border border-white/20 p-1.5 rounded-2xl shadow-inner">
                        <div class="pl-3 flex items-center text-emerald-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="q" 
                            value="{{ $search }}" 
                            placeholder="Cari kabar, pengumuman, atau artikel..." 
                            class="w-full bg-transparent border-0 text-white placeholder-emerald-200/70 text-xs sm:text-sm focus:outline-none focus:ring-0"
                        >
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-400 text-slate-950 font-bold text-xs hover:opacity-90 transition shadow-md">
                            Cari
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Content & Category Filter -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Category Pills Emerald -->
    <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-8 text-xs font-semibold scrollbar-thin">
        <a href="{{ route('articles.index') }}" class="px-4 py-2.5 rounded-xl whitespace-nowrap transition {{ empty($currentCategory) ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'bg-white text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200' }}">
            Semua Kabar
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('articles.category', $cat->slug) }}" class="px-4 py-2.5 rounded-xl whitespace-nowrap transition {{ optional($currentCategory)->id === $cat->id ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/20' : 'bg-white text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200' }}">
                {{ $cat->name }} ({{ $cat->contents_count }})
            </a>
        @endforeach
    </div>

    <!-- Articles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($articles as $article)
            <article class="bg-white rounded-3xl border border-emerald-100 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between group">
                <div>
                    <!-- Cover Image -->
                    <div class="relative h-52 bg-slate-100 overflow-hidden">
                        <img 
                            src="{{ $article->cover_image ?: 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=600&q=80' }}" 
                            alt="{{ $article->title }}" 
                            class="w-full h-full object-cover transition duration-500 group-hover:scale-105"
                        >
                        @if($article->categories->isNotEmpty())
                            <div class="absolute top-3 left-3 flex flex-wrap gap-1">
                                @foreach($article->categories->take(2) as $category)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold bg-white/95 text-emerald-800 backdrop-blur-md shadow-sm border border-emerald-100">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Body -->
                    <div class="p-6">
                        <div class="flex items-center space-x-2 text-[11px] text-slate-400 mb-2">
                            <span>📅 {{ optional($article->published_at)->translatedFormat('d M Y') }}</span>
                            <span>&bull;</span>
                            <span>⏱️ {{ $article->reading_time }} mnt baca</span>
                        </div>

                        <h2 class="text-base sm:text-lg font-bold text-slate-900 leading-snug line-clamp-2 group-hover:text-emerald-700 transition">
                            <a href="{{ route('articles.show', $article->slug) }}">
                                {{ $article->title }}
                            </a>
                        </h2>

                        <p class="text-xs text-slate-600 mt-2.5 line-clamp-3 leading-relaxed">
                            {{ $article->summary }}
                        </p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between text-xs text-slate-500">
                    <span class="font-medium text-slate-700">✍️ {{ $article->author->name ?? 'Aparatur Desa' }}</span>
                    <a href="{{ route('articles.show', $article->slug) }}" class="font-bold text-emerald-600 hover:text-emerald-700 transition flex items-center space-x-1">
                        <span>Baca Selengkapnya</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </article>
        @empty
            <div class="col-span-full py-16 text-center text-slate-400 bg-white rounded-3xl border border-dashed border-emerald-200 p-8">
                <div class="text-5xl mb-3">📰</div>
                <h3 class="text-base font-bold text-slate-700">Tidak ada kabar yang ditemukan</h3>
                <p class="text-xs text-slate-400 mt-1">Coba gunakan kata kunci pencarian lain atau pilih kategori berbeda.</p>
                <div class="mt-4">
                    <a href="{{ route('articles.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-emerald-600 text-white hover:bg-emerald-700 transition shadow-sm">
                        Tampilkan Semua Berita
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($articles->hasPages())
        <div class="mt-12">
            {{ $articles->links() }}
        </div>
    @endif
</div>
@endsection
