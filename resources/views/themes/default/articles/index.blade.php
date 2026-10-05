@extends('themes.default.layouts.app')

@section('title', ($currentCategory ? $currentCategory->name . ' - ' : '') . 'Kabar & Berita - ' . \App\Models\Setting::get('village_name', 'Desa Sukamaju'))

@section('content')
<!-- Header Banner -->
<section class="bg-gradient-to-r from-sky-900 to-indigo-950 text-white py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-sky-500/20 text-sky-200 border border-sky-400/30 mb-3">
            📰 Warta & Dokumentasi Desa
        </span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight">
            @if($currentCategory)
                Kategori: {{ $currentCategory->name }}
            @elseif($search)
                Hasil Pencarian: "{{ $search }}"
            @else
                Kabar & Informasi Terkini
            @endif
        </h1>
        <p class="mt-2 text-sm sm:text-base text-sky-200 max-w-2xl">
            Transparansi kegiatan, pengumuman publik, dan kabar terkini seputar pembangunan dan kehidupan masyarakat {{ \App\Models\Setting::get('village_name', 'Desa Sukamaju') }}.
        </p>

        <!-- Search Form -->
        <div class="mt-8 max-w-xl">
            <form action="{{ route('articles.index') }}" method="GET" class="flex gap-2">
                <input 
                    type="text" 
                    name="q" 
                    value="{{ $search }}" 
                    placeholder="Cari kabar, pengumuman, atau artikel..." 
                    class="w-full px-4 py-3 rounded-xl bg-white/10 text-white placeholder-sky-200 border border-white/20 text-sm focus:outline-none focus:ring-2 focus:ring-sky-400 backdrop-blur-md"
                >
                <button type="submit" class="px-6 py-3 rounded-xl bg-sky-500 hover:bg-sky-400 text-white font-semibold text-sm transition shadow-md">
                    Cari
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Content & Category Filter -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Category Pills -->
    <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-8 text-xs font-medium scrollbar-thin">
        <a href="{{ route('articles.index') }}" class="px-4 py-2 rounded-xl whitespace-nowrap transition {{ empty($currentCategory) ? 'bg-sky-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
            Semua Kabar
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('articles.category', $cat->slug) }}" class="px-4 py-2 rounded-xl whitespace-nowrap transition {{ optional($currentCategory)->id === $cat->id ? 'bg-sky-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                {{ $cat->name }} ({{ $cat->contents_count }})
            </a>
        @endforeach
    </div>

    <!-- Articles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($articles as $article)
            <article class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
                <div>
                    <!-- Cover Image -->
                    <div class="relative h-48 bg-slate-100 overflow-hidden">
                        <img 
                            src="{{ $article->cover_image ?: 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=600&q=80' }}" 
                            alt="{{ $article->title }}" 
                            class="w-full h-full object-cover transition duration-300 hover:scale-105"
                        >
                        @if($article->categories->isNotEmpty())
                            <div class="absolute top-3 left-3 flex flex-wrap gap-1">
                                @foreach($article->categories->take(2) as $category)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[10px] font-bold bg-white/90 text-sky-800 backdrop-blur-md shadow-sm">
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
                            <span>•</span>
                            <span>⏱️ {{ $article->reading_time }} mnt baca</span>
                        </div>

                        <h2 class="text-lg font-bold text-slate-900 leading-snug line-clamp-2 hover:text-sky-600 transition">
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
                    <a href="{{ route('articles.show', $article->slug) }}" class="font-bold text-sky-600 hover:text-sky-700 transition flex items-center space-x-1">
                        <span>Baca</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </article>
        @empty
            <div class="col-span-full py-16 text-center text-slate-400 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                <div class="text-5xl mb-3">📰</div>
                <h3 class="text-base font-bold text-slate-700">Tidak ada kabar yang ditemukan</h3>
                <p class="text-xs text-slate-400 mt-1">Coba gunakan kata kunci pencarian lain atau pilih kategori berbeda.</p>
                <div class="mt-4">
                    <a href="{{ route('articles.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold bg-sky-600 text-white hover:bg-sky-500 transition">
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
