@extends('errors.layout')

@section('title', '503 - Mode Pemeliharaan')

@section('content')
<div class="bg-white p-8 sm:p-12 rounded-3xl shadow-sm border border-slate-200">
    <!-- Icon Ilustrasi 503 -->
    <div class="w-20 h-20 mx-auto rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center mb-6">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
    </div>

    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-sky-100 text-sky-800 mb-3 tracking-wide">
        PEMELIHARAAN SISTEM
    </span>

    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-3">
        Layanan Sedang Ditingkatkan
    </h1>

    <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-8">
        Portal Informasi Desa sedang menjalani pemeliharaan sistem berkala guna meningkatkan kualitas pelayanan, stabilitas, dan keamanan data. Kami akan segera kembali beroperasi normal.
    </p>

    <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
        <button onclick="window.location.reload()" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-sky-600 text-white font-semibold text-sm hover:bg-sky-700 transition shadow-sm cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Cek Status Layanan
        </button>
    </div>
</div>
@endsection
