@extends('errors.layout')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
<div class="bg-white p-8 sm:p-12 rounded-3xl shadow-sm border border-slate-200">
    <!-- Icon Ilustrasi 404 -->
    <div class="w-20 h-20 mx-auto rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-6">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </div>

    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 mb-3 tracking-wide">
        GALAT 404 &bull; TIDAK DITEMUKAN
    </span>

    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-3">
        Halaman Tidak Ditemukan
    </h1>

    <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-8">
        Mohon maaf, halaman atau berkas yang Anda cari tidak tersedia. Tautan mungkin telah dipindahkan, dinonaktifkan, atau alamat URL yang Anda masukkan salah.
    </p>

    <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
        <a href="/" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-emerald-600 text-white font-semibold text-sm hover:bg-emerald-700 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Kembali ke Beranda
        </a>
        <a href="/ppid/dokumen" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-slate-100 text-slate-700 font-semibold text-sm hover:bg-slate-200 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Dokumen Publik (DIP)
        </a>
    </div>

    <!-- Tautan Cepat Alternatif -->
    <div class="mt-8 pt-6 border-t border-slate-100 flex flex-wrap items-center justify-center gap-4 text-xs text-slate-500">
        <span>Butuh layanan lain?</span>
        <a href="/citizen/letters/create" class="text-emerald-600 font-medium hover:underline">Permohonan Surat Warga</a>
        <span>&bull;</span>
        <a href="/berita" class="text-emerald-600 font-medium hover:underline">Kabar Berita Desa</a>
        <span>&bull;</span>
        <a href="/ppid/tracking" class="text-emerald-600 font-medium hover:underline">Lacak Tiket PPID</a>
    </div>
</div>
@endsection
