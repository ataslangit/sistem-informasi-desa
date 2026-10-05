@extends(theme_layout())

@section('title', 'PPID Desa - Layanan Keterbukaan Informasi Publik')

@section('content')
<!-- Banner Hero Hijau Zamrud (Jumbotron PPID Tema Emerald) -->
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
                    <span class="text-white font-semibold">PPID Desa (Keterbukaan Informasi Publik)</span>
                </nav>

                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-200 text-xs font-bold backdrop-blur-md">
                    <span>📢</span>
                    <span>UU KIP No. 14 Tahun 2008 & Perki No. 1 Tahun 2018</span>
                </div>

                <!-- Judul Halaman Putih Kontras Tinggi -->
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight drop-shadow-sm">
                    PPID Desa {{ $ppidProfile['village_name'] }}
                </h1>

                <p class="text-sm sm:text-base lg:text-lg text-emerald-100/90 leading-relaxed font-normal max-w-3xl">
                    Pejabat Pengelola Informasi dan Dokumentasi (PPID) Desa menjamin hak masyarakat untuk memperoleh informasi publik secara cepat, tepat waktu, mudah, dan transparan.
                </p>

                <!-- Tombol Aksi Cepat Emerald -->
                <div class="pt-4 flex flex-wrap gap-3">
                    <a href="{{ route('public.ppid.requests.create') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-400 text-slate-950 font-bold text-xs hover:opacity-90 transition shadow-lg shadow-emerald-950/40">
                        <span>📝</span>
                        <span>Permohonan Informasi Daring</span>
                    </a>
                    <a href="{{ route('public.ppid.documents') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold text-xs border border-white/20 backdrop-blur-md transition">
                        <span>📁</span>
                        <span>Daftar Dokumen Publik (DIP)</span>
                    </a>
                    <a href="{{ route('public.ppid.tracking') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold text-xs border border-white/20 backdrop-blur-md transition">
                        <span>🔍</span>
                        <span>Cek Status Tiket</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    <!-- Statistik Singkat -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl font-bold">
                📄
            </div>
            <div>
                <span class="text-2xl font-black text-slate-800">{{ $stats['total_documents'] }}</span>
                <p class="text-xs text-slate-500 font-medium">Dokumen Publik Terbit</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl font-bold">
                📬
            </div>
            <div>
                <span class="text-2xl font-black text-slate-800">{{ $stats['total_requests'] }}</span>
                <p class="text-xs text-slate-500 font-medium">Permohonan Informasi Diterima</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl font-bold">
                ✅
            </div>
            <div>
                <span class="text-2xl font-black text-slate-800">{{ $stats['resolved_requests'] }}</span>
                <p class="text-xs text-slate-500 font-medium">Permohonan Telah Ditanggapi</p>
            </div>
        </div>
    </div>

    <!-- Maklumat Pelayanan Informasi -->
    <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-3xl p-8 border border-blue-100 shadow-sm relative overflow-hidden">
        <div class="max-w-3xl space-y-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-blue-100 text-blue-800 uppercase tracking-wider">
                ⚖️ Maklumat Pelayanan Informasi Publik Desa
            </span>
            <blockquote class="text-lg sm:text-xl font-bold text-slate-800 italic leading-snug">
                "{{ $ppidProfile['maklumat'] }}"
            </blockquote>
            <div class="pt-2 text-xs text-slate-600 flex items-center space-x-2">
                <span>Ditetapkan oleh Pemerintah Desa {{ $ppidProfile['village_name'] }}</span>
                <span>•</span>
                <span>Berdasarkan UU KIP No. 14 Tahun 2008</span>
            </div>
        </div>
    </div>

    <!-- Struktur Organisasi PPID Desa -->
    <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm space-y-8">
        <div>
            <h2 class="text-xl font-black text-slate-800">Struktur Organisasi PPID Desa</h2>
            <p class="text-xs text-slate-500 mt-1">Sesuai Peraturan Komisi Informasi (Perki) No. 1 Tahun 2018 tentang Standar Layanan Informasi Publik Desa.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Atasan PPID -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-800 uppercase tracking-wider">
                    Atasan PPID Desa
                </span>
                <h3 class="text-base font-bold text-slate-800">{{ $ppidProfile['kades_name'] }}</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Bertanggung jawab penuh atas pengelolaan keterbukaan informasi publik desa dan menetapkan keputusan atas pengajuan keberatan permohonan informasi.
                </p>
            </div>

            <!-- PPID Desa -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 uppercase tracking-wider">
                    Pejabat Pengelola Informasi & Dokumentasi (PPID)
                </span>
                <h3 class="text-base font-bold text-slate-800">{{ $ppidProfile['sekdes_name'] }}</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Mengoordinasikan pengumpulan, pendokumentasian, verifikasi, serta penyampaian informasi publik desa kepada masyarakat pemohon.
                </p>
            </div>
        </div>
    </div>

    <!-- Dokumen Publik Terbaru -->
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-black text-slate-800">Dokumen Publik Berkala Terbaru</h2>
                <p class="text-xs text-slate-500 mt-1">Unduh berkas resmi perencanaan dan pertanggungjawaban desa.</p>
            </div>
            <a href="{{ route('public.ppid.documents') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800">
                Lihat Semua Dokumen &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($latestDocuments as $doc)
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow-md transition space-y-4">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                {{ $doc->document_type }}
                            </span>
                            @if($doc->year)
                                <span class="text-[11px] font-semibold text-slate-400">Tahun {{ $doc->year }}</span>
                            @endif
                        </div>
                        <h3 class="font-bold text-sm text-slate-800 line-clamp-2">{{ $doc->title }}</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">{{ $doc->description ?? 'Tidak ada ringkasan keterangan.' }}</p>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] font-mono text-slate-400">{{ $doc->formatted_file_size }}</span>
                        <a href="{{ route('public.ppid.documents.download', $doc) }}" class="inline-flex items-center px-3 py-1.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-semibold transition space-x-1">
                            <span>⬇️ Unduh</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full p-8 text-center bg-white rounded-3xl border border-dashed border-slate-200 text-slate-400 text-xs">
                    Belum ada dokumen publik berkala yang diunggah.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
