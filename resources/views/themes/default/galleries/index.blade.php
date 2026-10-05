@extends(theme_layout())

@section('title', 'Album Galeri & Dokumentasi Kegiatan - ' . \App\Models\Setting::get('village_name', 'Desa Sukamaju'))

@section('content')
<!-- Header Banner -->
<section class="bg-gradient-to-r from-sky-900 to-indigo-950 text-white py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-sky-500/20 text-sky-200 border border-sky-400/30 mb-3">
            📷 Dokumentasi Visual Desa
        </span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight">
            Galeri Foto Desa & Album Kegiatan
        </h1>
        <p class="mt-2 text-sm sm:text-base text-sky-200 max-w-2xl">
            Koleksi album dokumentasi foto pembangunan, kegiatan sosial kemasyarakatan, adat budaya, serta keindahan potensi alam {{ \App\Models\Setting::get('village_name', 'Desa Sukamaju') }}.
        </p>
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
