@extends('themes.default.layouts.app')

@section('title', 'PPID Desa - Layanan Keterbukaan Informasi Publik')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 text-white py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/20 text-blue-200 border border-blue-400/30 mb-3 space-x-1.5">
            <span>📢</span>
            <span>UU No. 14 Tahun 2008 & Perki No. 1 Tahun 2018</span>
        </span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight">
            PPID Desa {{ $ppidProfile['village_name'] }}
        </h1>
        <p class="mt-2 text-sm sm:text-base text-blue-100 max-w-2xl leading-relaxed">
            Pejabat Pengelola Informasi dan Dokumentasi (PPID) Desa hadir untuk menjamin hak masyarakat desa dalam memperoleh informasi publik secara cepat, tepat waktu, dan transparan.
        </p>

        <!-- Quick CTA Buttons -->
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('public.ppid.requests.create') }}" class="inline-flex items-center px-5 py-3 rounded-2xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs shadow-lg transition space-x-2">
                <span>📝</span>
                <span>Permohonan Informasi Daring</span>
            </a>
            <a href="{{ route('public.ppid.documents') }}" class="inline-flex items-center px-5 py-3 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs backdrop-blur-sm border border-white/20 transition space-x-2">
                <span>📁</span>
                <span>Daftar Dokumen Publik (DIP)</span>
            </a>
            <a href="{{ route('public.ppid.tracking') }}" class="inline-flex items-center px-5 py-3 rounded-2xl bg-slate-800/80 hover:bg-slate-700/80 text-blue-200 font-bold text-xs border border-slate-700 transition space-x-2">
                <span>🔍</span>
                <span>Cek Status Tiket</span>
            </a>
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
