@extends('errors.layout')

@section('title', '500 - Kesalahan Server')

@section('content')
<div class="bg-white p-8 sm:p-12 rounded-3xl shadow-sm border border-slate-200">
    <!-- Icon Ilustrasi 500 -->
    <div class="w-20 h-20 mx-auto rounded-2xl bg-red-50 text-red-600 flex items-center justify-center mb-6">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
    </div>

    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 mb-3 tracking-wide">
        GALAT 500 &bull; GANGGUAN SERVER
    </span>

    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-3">
        Terjadi Kesalahan Server
    </h1>

    <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-8">
        Mohon maaf, sistem mengalami kendala internal saat memproses permintaan Anda. Administrator dan tim teknis desa sedang memeriksa dan menangani permasalahan ini.
    </p>

    <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
        <button onclick="window.location.reload()" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-slate-900 text-white font-semibold text-sm hover:bg-slate-800 transition shadow-sm cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Coba Lagi
        </button>
        <a href="/" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-slate-100 text-slate-700 font-semibold text-sm hover:bg-slate-200 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
