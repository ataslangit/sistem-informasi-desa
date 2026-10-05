@extends('themes.emerald.layouts.app')

@section('title', \App\Models\Setting::get('app_title', 'SiDesa - Portal Resmi Desa'))

@section('content')
<!-- Hero Section Emerald -->
<section class="relative bg-gradient-to-br from-emerald-950 via-emerald-900 to-teal-950 text-white py-24 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <div class="max-w-5xl mx-auto text-center relative z-10">
        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-200 border border-emerald-400/30 mb-6 backdrop-blur-md">
            🌿 Portal Resmi Desa Wisata & Asri
        </span>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight">
            {{ \App\Models\Setting::get('village_name', 'Desa Sukamaju') }}
        </h1>
        <p class="mt-6 text-lg sm:text-xl text-emerald-100 max-w-2xl mx-auto leading-relaxed">
            {{ \App\Models\Setting::get('app_tagline', 'Mewujudkan Desa Maju, Mandiri, dan Transparan Berbasis Digital') }}
        </p>

        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ route('citizen.letters.create') }}" class="px-6 py-3.5 rounded-xl font-semibold bg-emerald-500 hover:bg-emerald-400 text-slate-950 transition shadow-lg shadow-emerald-950/30 text-sm">
                ✉️ Layanan Surat Mandiri &rarr;
            </a>
            <a href="{{ route('articles.index') }}" class="px-6 py-3.5 rounded-xl font-semibold bg-white/10 hover:bg-white/20 text-white transition backdrop-blur-md text-sm border border-white/20">
                📰 Kabar Desa Terkini
            </a>
        </div>
    </div>
</section>

<!-- Kabar Desa Terkini -->
@if(isset($latestArticles) && $latestArticles->isNotEmpty())
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-4">
            <div>
                <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider block mb-1">Dokumentasi & Berita</span>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kabar Desa Terkini</h2>
            </div>
            <a href="{{ route('articles.index') }}" class="text-sm font-bold text-emerald-600 hover:text-emerald-700 transition flex items-center space-x-1">
                <span>Lihat Semua Berita</span>
                <span>&rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($latestArticles as $article)
                <article class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="relative h-44 bg-slate-100 overflow-hidden">
                            <img src="{{ $article->cover_image ?: 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                        </div>
                        <div class="p-6">
                            <div class="text-[11px] text-slate-400 mb-2">
                                📅 {{ optional($article->published_at)->translatedFormat('d M Y') }}
                            </div>
                            <h3 class="font-bold text-slate-800 text-base line-clamp-2 hover:text-emerald-600 transition mb-2">
                                <a href="{{ route('articles.show', $article->slug) }}">
                                    {{ $article->title }}
                                </a>
                            </h3>
                            <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                                {{ $article->summary }}
                            </p>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between text-xs text-slate-500">
                        <span>{{ $article->author->name ?? 'Aparatur Desa' }}</span>
                        <a href="{{ route('articles.show', $article->slug) }}" class="font-bold text-emerald-600 hover:text-emerald-700">Baca &rarr;</a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
