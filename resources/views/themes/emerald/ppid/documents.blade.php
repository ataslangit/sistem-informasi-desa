@extends('themes.emerald.layouts.app')

@section('title', 'Daftar Dokumen Informasi Publik (DIP) - PPID Desa ' . \App\Models\Setting::get('village_name', 'Desa Sukamaju'))

@section('content')
<!-- Banner Hero Hijau Zamrud (Jumbotron Dokumen DIP Tema Emerald) -->
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
                    <a href="{{ route('public.ppid.index') }}" class="hover:text-white transition">PPID Desa</a>
                    <span class="text-emerald-500">/</span>
                    <span class="text-white font-semibold">Dokumen Publik (DIP)</span>
                </nav>

                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-200 text-xs font-bold backdrop-blur-md">
                    <span>📁</span>
                    <span>Daftar Informasi Publik (DIP Desa)</span>
                </div>

                <!-- Judul Halaman Putih Kontras Tinggi -->
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight drop-shadow-sm">
                    Repositori Dokumen Publik
                </h1>

                <p class="text-sm sm:text-base lg:text-lg text-emerald-100/90 leading-relaxed font-normal max-w-3xl">
                    Akses dan unduh berkas resmi penyelenggaraan pemerintahan desa seperti RPJMDes, RKPDes, LPPD, LKPPD, dan Peraturan Desa sesuai amanat UU No. 14 Tahun 2008.
                </p>
            </div>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <!-- Filter Bar -->
    <div class="bg-white p-6 rounded-3xl border border-emerald-100 shadow-sm">
        <form action="{{ route('public.ppid.documents') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="lg:col-span-2">
                <label for="keyword" class="block text-xs font-semibold text-slate-700 mb-1">Cari Dokumen</label>
                <input 
                    type="text" 
                    id="keyword"
                    name="keyword" 
                    value="{{ $keyword }}" 
                    placeholder="Judul atau kata kunci dokumen..." 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                >
            </div>

            <div>
                <label for="category" class="block text-xs font-semibold text-slate-700 mb-1">Kategori KIP</label>
                <select id="category" name="category" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none bg-white">
                    <option value="">Semua Kategori</option>
                    <option value="berkala" {{ $category === 'berkala' ? 'selected' : '' }}>Informasi Berkala</option>
                    <option value="setiap_saat" {{ $category === 'setiap_saat' ? 'selected' : '' }}>Informasi Setiap Saat</option>
                    <option value="serta_merta" {{ $category === 'serta_merta' ? 'selected' : '' }}>Informasi Serta Merta</option>
                </select>
            </div>

            <div>
                <label for="year" class="block text-xs font-semibold text-slate-700 mb-1">Tahun</label>
                <select id="year" name="year" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none bg-white">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $y)
                        <option value="{{ $y }}" {{ (string)$year === (string)$y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end space-x-2">
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs shadow-sm transition">
                    Filter
                </button>
                @if($keyword || $category || $documentType || $year)
                    <a href="{{ route('public.ppid.documents') }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Documents Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($documents as $doc)
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col justify-between hover:shadow-md hover:border-emerald-200 transition space-y-4">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                            {{ $doc->document_type }}
                        </span>
                        @if($doc->year)
                            <span class="text-[11px] font-semibold text-slate-400">Tahun {{ $doc->year }}</span>
                        @endif
                    </div>
                    <h3 class="font-bold text-sm text-slate-800 leading-snug">{{ $doc->title }}</h3>
                    <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                        {{ $doc->description ?? 'Dokumen resmi publikasi PPID Desa.' }}
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <div class="text-[11px] text-slate-400">
                        <span class="font-mono">{{ $doc->formatted_file_size }}</span> • 
                        <span>{{ $doc->download_count }}x diunduh</span>
                    </div>
                    <a href="{{ route('public.ppid.documents.download', $doc) }}" class="inline-flex items-center px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition space-x-1 shadow-sm">
                        <span>⬇️ Unduh</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full p-16 text-center bg-white rounded-3xl border border-dashed border-slate-200 text-slate-400 space-y-2">
                <span class="text-4xl block">📭</span>
                <p class="text-sm font-semibold">Tidak ada dokumen publik yang sesuai kriteria pencarian.</p>
                <p class="text-xs">Coba atur ulang kata kunci atau filter tahun pencarian Anda.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pt-4">
        {{ $documents->links() }}
    </div>
</div>
@endsection
