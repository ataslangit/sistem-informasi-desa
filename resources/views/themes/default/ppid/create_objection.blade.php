@extends(theme_layout())

@section('title', 'Formulir Pengajuan Keberatan Informasi Publik - PPID Desa')

@section('content')
<!-- Header Banner -->
<section class="bg-gradient-to-r from-amber-900 via-orange-900 to-slate-900 text-white py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/20 text-amber-200 border border-amber-400/30 mb-3 space-x-1.5">
            <span>⚖️</span>
            <span>Mekanisme Keberatan KIP (UU 14/2008 & Perki 1/2018)</span>
        </span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight">
            Pengajuan Keberatan Informasi
        </h1>
        <p class="mt-2 text-sm sm:text-base text-amber-100 leading-relaxed">
            Keberatan diajukan kepada Atasan PPID (Kepala Desa) atas permohonan informasi publik yang ditolak, tidak ditanggapi, atau tidak dipenuhi sebagaimana mestinya.
        </p>
    </div>
</section>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 sm:p-10 space-y-8">
        <!-- Rujukan Tiket Asal -->
        <div class="p-5 bg-slate-50 rounded-2xl border border-slate-200 text-xs space-y-2">
            <span class="font-bold text-slate-700 block">Rujukan Permohonan Asal:</span>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-slate-600">
                <div><b>Nomor Tiket:</b> <span class="font-mono">{{ $infoRequest->ticket_number }}</span></div>
                <div><b>Nama Pemohon:</b> {{ $infoRequest->applicant_name }}</div>
                <div class="sm:col-span-2"><b>Informasi yang Dimohon:</b> {{ $infoRequest->information_requested }}</div>
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
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none bg-white"
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
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none"
                >{{ old('objection_detail') }}</textarea>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('public.ppid.tracking.show', $infoRequest->ticket_number) }}" class="text-xs text-slate-500 hover:text-slate-800">
                    &larr; Batal & Kembali
                </a>
                <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-xl shadow-md transition text-xs flex items-center space-x-2">
                    <span>⚖️</span>
                    <span>Kirim Berkas Keberatan ke Kepala Desa</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
