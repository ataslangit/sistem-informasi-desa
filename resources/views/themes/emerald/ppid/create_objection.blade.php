@extends('themes.emerald.layouts.app')

@section('title', 'Formulir Pengajuan Keberatan Informasi Publik - PPID Desa ' . \App\Models\Setting::get('village_name', 'Desa Sukamaju'))

@section('content')
<!-- Banner Hero Hijau Zamrud (Jumbotron Keberatan PPID Tema Emerald) -->
<section class="relative px-4 sm:px-6 lg:px-8 pt-6 pb-4">
    <div class="max-w-7xl mx-auto">
        <div class="relative rounded-3xl overflow-hidden shadow-2xl shadow-emerald-950/20 bg-gradient-to-br from-emerald-950 via-emerald-900 to-teal-950 py-12 sm:py-16 px-6 sm:px-12 text-white">
            <!-- Background Landscape Overlay -->
            <div class="absolute inset-0 bg-cover bg-center opacity-15 mix-blend-overlay pointer-events-none" style="background-image: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=1600&q=80');"></div>
            <!-- Radial Glow Ornaments -->
            <div class="absolute -right-10 -bottom-10 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
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
                    <a href="{{ route('public.ppid.tracking.show', $infoRequest->ticket_number) }}" class="hover:text-white transition">Tiket {{ $infoRequest->ticket_number }}</a>
                    <span class="text-emerald-500">/</span>
                    <span class="text-white font-semibold">Pengajuan Keberatan</span>
                </nav>

                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-500/20 border border-amber-400/30 text-amber-200 text-xs font-bold backdrop-blur-md">
                    <span>⚖️</span>
                    <span>Mekanisme Keberatan KIP (UU 14/2008 & Perki 1/2018)</span>
                </div>

                <!-- Judul Halaman Putih Kontras Tinggi -->
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight drop-shadow-sm">
                    Pengajuan Keberatan Informasi
                </h1>

                <p class="text-sm sm:text-base lg:text-lg text-emerald-100/90 leading-relaxed font-normal max-w-3xl">
                    Keberatan diajukan secara resmi kepada Atasan PPID (Kepala Desa) atas permohonan informasi publik yang ditolak, tidak ditanggapi, atau tidak dipenuhi sebagaimana mestinya.
                </p>
            </div>
        </div>
    </div>
</section>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-3xl border border-emerald-100 shadow-sm p-8 sm:p-10 space-y-8">
        <!-- Rujukan Tiket Asal -->
        <div class="p-5 bg-emerald-50/50 rounded-2xl border border-emerald-100 text-xs space-y-2">
            <span class="font-bold text-emerald-900 block">Rujukan Permohonan Asal:</span>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-slate-700">
                <div><b class="text-slate-900">Nomor Tiket:</b> <span class="font-mono text-emerald-800 font-bold">{{ $infoRequest->ticket_number }}</span></div>
                <div><b class="text-slate-900">Nama Pemohon:</b> {{ $infoRequest->applicant_name }}</div>
                <div class="sm:col-span-2"><b class="text-slate-900">Informasi yang Dimohon:</b> {{ $infoRequest->information_requested }}</div>
            </div>
        </div>

        @if ($errors->any())
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-xs space-y-1">
                <div class="font-bold">⚠️ Mohon periksa isian Anda:</div>
                <ul class="list-disc list-inside space-y-0.5 text-[11px] pt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('public.ppid.objections.store', $infoRequest->ticket_number) }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="reason_code" class="block text-xs font-semibold text-slate-700 mb-1">
                    Alasan Pengajuan Keberatan (Sesuai Perki No. 1/2018) <span class="text-rose-500">*</span>
                </label>
                <select 
                    name="reason_code" 
                    id="reason_code" 
                    required 
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none bg-white"
                >
                    <option value="">Pilih Alasan Keberatan...</option>
                    <option value="rejected" {{ old('reason_code') === 'rejected' ? 'selected' : '' }}>1. Permohonan Informasi Ditolak</option>
                    <option value="not_provided" {{ old('reason_code') === 'not_provided' ? 'selected' : '' }}>2. Informasi Berkala Tidak Disediakan</option>
                    <option value="not_responded" {{ old('reason_code') === 'not_responded' ? 'selected' : '' }}>3. Permohonan Tidak Ditanggapi dalam Batas Waktu</option>
                    <option value="not_as_requested" {{ old('reason_code') === 'not_as_requested' ? 'selected' : '' }}>4. Permohonan Ditanggapi Tidak Sebagaimana Diminta</option>
                    <option value="excessive_fee" {{ old('reason_code') === 'excessive_fee' ? 'selected' : '' }}>5. Pengenaan Biaya yang Tidak Wajar</option>
                    <option value="late_delivery" {{ old('reason_code') === 'late_delivery' ? 'selected' : '' }}>6. Penyampaian Informasi Melebihi Batas Waktu Layanan</option>
                </select>
            </div>

            <div>
                <label for="objection_detail" class="block text-xs font-semibold text-slate-700 mb-1">
                    Kronologi & Rincian Alasan Keberatan <span class="text-rose-500">*</span>
                </label>
                <textarea 
                    name="objection_detail" 
                    id="objection_detail" 
                    rows="5" 
                    required 
                    placeholder="Uraikan secara jelas alasan dan argumentasi keberatan Anda kepada Kepala Desa (Atasan PPID)..."
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                >{{ old('objection_detail') }}</textarea>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('public.ppid.tracking.show', $infoRequest->ticket_number) }}" class="text-xs text-slate-500 hover:text-emerald-800 transition">
                    &larr; Batal & Kembali
                </a>
                <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-xl shadow-md shadow-amber-600/20 transition text-xs flex items-center space-x-2">
                    <span>⚖️</span>
                    <span>Kirim Berkas Keberatan ke Kepala Desa</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
