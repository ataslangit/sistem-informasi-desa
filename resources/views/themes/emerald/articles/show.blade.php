@extends(theme_layout())

@section('title', $article->title . ' - ' . \App\Models\Setting::get('village_name', 'Desa Sukamaju'))

@section('content')
<!-- Banner Hero Hijau Zamrud (Jumbotron Detail Artikel Tema Emerald) -->
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
                    <a href="{{ route('home') }}" class="hover:text-white transition flex items-center gap-1">
                        <span>🏡</span>
                        <span>Beranda</span>
                    </a>
                    <span class="text-emerald-500">/</span>
                    <a href="{{ route('articles.index') }}" class="hover:text-white transition">Kabar Desa</a>
                    <span class="text-emerald-500">/</span>
                    <span class="text-white font-semibold truncate max-w-xs">{{ $article->title }}</span>
                </nav>

                <!-- Kategori Tags -->
                @if($article->categories->isNotEmpty())
                    <div class="flex flex-wrap gap-2 pt-1">
                        @foreach($article->categories as $category)
                            <a href="{{ route('articles.category', $category->slug) }}" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-200 border border-emerald-400/30 backdrop-blur-md hover:bg-emerald-500/30 transition">
                                🏷️ {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                @endif

                <!-- Judul Artikel Putih Kontras Tinggi -->
                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight drop-shadow-sm">
                    {{ $article->title }}
                </h1>

                <!-- Meta Info Bar & Tombol Cetak -->
                <div class="pt-4 flex flex-wrap items-center justify-between gap-4 text-xs text-emerald-200/80 border-t border-white/10">
                    <div class="flex flex-wrap items-center gap-4">
                        <span class="flex items-center gap-1.5 font-medium text-emerald-200">
                            <span>✍️</span>
                            <span>Oleh: <strong>{{ $article->author->name ?? 'Aparatur Desa' }}</strong></span>
                        </span>
                        <span class="text-emerald-500">&bull;</span>
                        <span class="flex items-center gap-1.5 text-emerald-200">
                            <span>📅</span>
                            <span>{{ optional($article->published_at)->translatedFormat('l, d F Y') }}</span>
                        </span>
                        <span class="text-emerald-500">&bull;</span>
                        <span class="flex items-center gap-1.5 text-emerald-200">
                            <span>⏱️</span>
                            <span>{{ $article->reading_time }} menit baca</span>
                        </span>
                        <span class="text-emerald-500">&bull;</span>
                        <span class="flex items-center gap-1.5 text-emerald-200">
                            <span>👁️</span>
                            <span>{{ number_format($article->view_count) }} kali dibaca</span>
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        <button onclick="window.print()" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold backdrop-blur-md border border-white/20 transition shadow-sm cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            <span>Cetak Artikel</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Konten Utama Artikel -->
<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Cover Image -->
    @if($article->cover_image)
        <div class="mb-8 rounded-3xl overflow-hidden shadow-sm border border-emerald-100">
            <img 
                src="{{ $article->cover_image }}" 
                alt="{{ $article->title }}" 
                class="w-full max-h-[500px] object-cover"
            >
        </div>
    @endif

    <!-- Summary Lead -->
    @if($article->summary)
        <div class="text-base sm:text-lg font-medium text-slate-700 leading-relaxed mb-8 p-6 bg-emerald-50/60 rounded-3xl border-l-4 border-emerald-500">
            {{ $article->summary }}
        </div>
    @endif

    <!-- Content Body -->
    <div class="prose prose-slate prose-emerald max-w-none text-slate-700 leading-relaxed space-y-4 text-sm sm:text-base">
        {!! $article->rendered_body !!}
    </div>

    <!-- Navigasi Footer -->
    <div class="mt-12 pt-6 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
        <a href="{{ route('articles.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-emerald-700 hover:text-emerald-800 transition">
            <span>&larr;</span>
            <span>Kembali ke Semua Kabar Desa</span>
        </a>
    </div>
</article>

<!-- Related Articles Section Emerald -->
@if($relatedArticles->isNotEmpty())
    <section class="bg-emerald-50/40 border-t border-emerald-100/60 py-14 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 block mb-1">Artikel Terkait</span>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Kabar Desa Terkait Lainnya</h2>
                </div>
                <a href="{{ route('articles.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                    <span>Lihat Semua &rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedArticles as $related)
                    <div class="bg-white p-6 rounded-3xl border border-emerald-100 shadow-sm hover:shadow-md transition flex flex-col justify-between group">
                        <div>
                            <div class="text-[11px] text-slate-400 mb-2">
                                📅 {{ optional($related->published_at)->translatedFormat('d M Y') }}
                            </div>
                            <h3 class="font-bold text-slate-900 text-sm group-hover:text-emerald-700 line-clamp-2 transition mb-2">
                                <a href="{{ route('articles.show', $related->slug) }}">
                                    {{ $related->title }}
                                </a>
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                {{ $related->summary }}
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-slate-100">
                            <a href="{{ route('articles.show', $related->slug) }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center gap-1">
                                <span>Baca &rarr;</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
@endsection
