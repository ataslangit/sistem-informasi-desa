@extends(theme_layout())

@section('title', \App\Models\Setting::get('app_title', 'SiDesa - Portal Resmi Desa'))

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-sky-900 via-sky-800 to-indigo-950 text-white py-24 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <div class="max-w-5xl mx-auto text-center relative z-10">
        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-semibold bg-sky-500/20 text-sky-200 border border-sky-400/30 mb-6 backdrop-blur-md">
            ✨ Selamat Datang di Portal Resmi Desa
        </span>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight">
            {{ \App\Models\Setting::get('village_name', 'Desa Sukamaju') }}
        </h1>
        <p class="mt-6 text-lg sm:text-xl text-sky-100 max-w-2xl mx-auto leading-relaxed">
            {{ \App\Models\Setting::get('app_tagline', 'Mewujudkan Desa Maju, Mandiri, dan Transparan Berbasis Digital') }}
        </p>

        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ route('citizen.letters.create') }}" class="px-6 py-3.5 rounded-xl font-semibold bg-sky-500 hover:bg-sky-400 text-white transition shadow-lg shadow-sky-950/30 text-sm">
                ✉️ Ajukan Surat Online &rarr;
            </a>
            <a href="#profil" class="px-6 py-3.5 rounded-xl font-semibold bg-white/10 hover:bg-white/20 text-white transition backdrop-blur-md text-sm border border-white/20">
                📖 Profil & Transparansi
            </a>
        </div>
    </div>
</section>

<!-- Quick Highlights / Features -->
<section id="layanan" class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pelayanan Warga Mandiri</h2>
            <p class="mt-3 text-slate-600 text-sm">
                Kemudahan pengurusan dokumen administrasi dan persuratan desa tanpa harus antre lama di kantor desa.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="w-14 h-14 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-3xl mb-6">
                    📜
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Surat Keterangan Usaha (SKU)</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Pengajuan surat keterangan usaha untuk keperluan izin usaha, pengajuan perbankan, dan bantuan UMKM.
                </p>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-3xl mb-6">
                    🏡
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Keterangan Domisili</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Pengesahan tempat tinggal warga maupun pendatang untuk berbagai kelengkapan administrasi instansi.
                </p>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl mb-6">
                    🤝
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Surat Pengantar SKCK</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Surat rekomendasi desa untuk permohonan Surat Keterangan Catatan Kepolisian di Polsek setempat.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Profil Desa Brief -->
<section id="profil" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-xs font-bold text-sky-600 uppercase tracking-wider block mb-2">Profil Singkat</span>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-6">
                    Pemerintahan yang Responsif & Terbuka
                </h2>
                <p class="text-slate-600 text-sm leading-relaxed mb-4">
                    {{ \App\Models\Setting::get('village_name', 'Desa Sukamaju') }} terus bertransformasi menuju tata kelola desa berbasis digital. Melalui sistem SiDesa, seluruh data kependudukan tercatat dengan rapi, pelayanan surat menyurat terdistribusi secara efisien, serta transparansi pengelolaan anggaran dapat diakses secara terbuka oleh masyarakat.
                </p>
                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                    <div>
                        <span class="block text-2xl font-black text-slate-800">100%</span>
                        <span class="text-xs text-slate-500">Transparansi Anggaran</span>
                    </div>
                    <div>
                        <span class="block text-2xl font-black text-slate-800">24/7</span>
                        <span class="text-xs text-slate-500">Akses Portal Informasi</span>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-tr from-sky-100 to-indigo-50 p-8 rounded-3xl border border-sky-100 flex flex-col justify-center items-center text-center">
                <div class="text-8xl mb-4 select-none">🏛️</div>
                <h3 class="font-bold text-xl text-slate-800">{{ \App\Models\Setting::get('village_name', 'Desa Sukamaju') }}</h3>
                <p class="text-xs text-slate-500 mt-1">Kode Wilayah: {{ \App\Models\Setting::get('village_code', '3201012001') }}</p>
                <div class="mt-6 inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold bg-white text-slate-700 shadow-sm border border-slate-200">
                    Sistem Multi-Tema Terisolasi
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Kabar Desa Terkini -->
@if(isset($latestArticles) && $latestArticles->isNotEmpty())
<section id="informasi" class="py-20 bg-slate-50 border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-4">
            <div>
                <span class="text-xs font-bold text-sky-600 uppercase tracking-wider block mb-1">Warta & Dokumentasi</span>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kabar Desa Terkini</h2>
                <p class="text-xs text-slate-500 mt-1">Ikuti berita terbaru, agenda kegiatan, dan kebijakan desa terkini.</p>
            </div>
            <a href="{{ route('articles.index') }}" class="text-xs font-bold text-sky-600 hover:text-sky-700 transition flex items-center space-x-1">
                <span>Lihat Semua Kabar</span>
                <span>&rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($latestArticles as $article)
                <article class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="relative h-48 bg-slate-100 overflow-hidden">
                            <img 
                                src="{{ $article->cover_image ?: 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=600&q=80' }}" 
                                alt="{{ $article->title }}" 
                                class="w-full h-full object-cover transition duration-300 hover:scale-105"
                            >
                            @if($article->categories->isNotEmpty())
                                <div class="absolute top-3 left-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-white/90 text-sky-800 backdrop-blur-md shadow-sm">
                                        {{ $article->categories->first()->name }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <div class="text-[11px] text-slate-400 mb-2">
                                📅 {{ optional($article->published_at)->translatedFormat('d M Y') }}
                            </div>
                            <h3 class="font-bold text-slate-800 text-base line-clamp-2 hover:text-sky-600 transition mb-2">
                                <a href="{{ route('articles.show', $article->slug) }}">
                                    {{ $article->title }}
                                </a>
                            </h3>
                            <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                                {{ $article->summary }}
                            </p>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between text-xs text-slate-500">
                        <span>✍️ {{ $article->author->name ?? 'Aparatur Desa' }}</span>
                        <a href="{{ route('articles.show', $article->slug) }}" class="font-bold text-sky-600 hover:text-sky-700">Baca &rarr;</a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
