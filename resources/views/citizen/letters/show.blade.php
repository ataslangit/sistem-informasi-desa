@extends('admin.layouts.app')

@section('title', 'Status Permohonan ' . $letterRequest->request_number)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <a href="{{ route('citizen.letters.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="text-xl font-bold text-slate-800">{{ $letterRequest->template->name }}</h2>
                <p class="text-xs text-slate-500 font-mono">No. Pengajuan: {{ $letterRequest->request_number }}</p>
            </div>
        </div>
        <div>
            @php
                $badge = match($letterRequest->status) {
                    'pending_rt' => 'bg-amber-50 text-amber-700 border-amber-200',
                    'pending_staff' => 'bg-blue-50 text-blue-700 border-blue-200',
                    'pending_kades' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                    'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                    'rejected' => 'bg-rose-50 text-rose-700 border-rose-200',
                    default => 'bg-slate-50 text-slate-700 border-slate-200',
                };
            @endphp
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $badge }}">
                {{ $letterRequest->status_label }}
            </span>
        </div>
    </div>

    <!-- Banner Download if Approved -->
    @if($letterRequest->isApproved())
        <div class="bg-gradient-to-r from-emerald-600 to-teal-600 text-white p-6 rounded-2xl shadow-lg flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-white/20 mb-2">
                    RESMI & TTE SAH
                </div>
                <h3 class="text-base font-bold">Surat Anda Telah Selesai Diterbitkan!</h3>
                <p class="text-xs text-emerald-100 mt-1">Nomor Surat: <strong class="font-mono">{{ $letterRequest->letter_number }}</strong></p>
            </div>
            <div>
                <a href="{{ route('citizen.letters.pdf', $letterRequest) }}" target="_blank" class="inline-flex items-center px-5 py-2.5 rounded-xl bg-white text-emerald-800 text-xs font-bold hover:bg-emerald-50 transition shadow space-x-2">
                    <span>📥</span>
                    <span>Unduh Dokumen PDF</span>
                </a>
            </div>
        </div>
    @endif

    <!-- Banner Rejection -->
    @if($letterRequest->isRejected())
        <div class="bg-rose-50 border border-rose-200 p-5 rounded-2xl text-xs text-rose-800">
            <div class="font-bold text-sm text-rose-900 mb-1">❌ Permohonan Surat Anda Ditolak</div>
            <p>Alasan: {{ $letterRequest->rejection_reason }}</p>
            <p class="text-[11px] text-rose-600 mt-2">Silakan hubungi aparatur desa jika membutuhkan penjelasan lebih lanjut atau ajukan permohonan baru dengan berkas perbaikan.</p>
        </div>
    @endif

    <!-- Tracking Timeline Card -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Tahapan Proses Verifikasi</h3>

        <div class="space-y-6 relative border-l-2 border-slate-200 ml-4 pl-6">
            <!-- 1. Pengajuan Warga -->
            <div class="relative">
                <div class="absolute -left-[33px] top-0 w-4 h-4 rounded-full bg-emerald-500 border-2 border-white ring-2 ring-emerald-500"></div>
                <div class="font-bold text-xs text-slate-800">1. Pengajuan Surat Dikirim</div>
                <div class="text-[11px] text-slate-500 mt-0.5">Dikirim pada {{ $letterRequest->created_at->translatedFormat('l, d F Y - H:i') }} WIB</div>
                <div class="text-xs text-slate-600 mt-2 p-3 bg-slate-50 rounded-xl">
                    Keperluan: <em>"{{ $letterRequest->purpose }}"</em>
                </div>
            </div>

            <!-- 2. Verifikasi RT -->
            <div class="relative">
                <div class="absolute -left-[33px] top-0 w-4 h-4 rounded-full
                    @if($letterRequest->rt_verified_at) bg-emerald-500 ring-2 ring-emerald-500
                    @elseif($letterRequest->status === 'pending_rt') bg-amber-500 ring-2 ring-amber-400 animate-pulse
                    @else bg-slate-300 ring-2 ring-slate-200 @endif border-2 border-white"></div>
                <div class="font-bold text-xs text-slate-800">2. Verifikasi Pengantar RT / RW</div>
                @if($letterRequest->rt_verified_at)
                    <div class="text-[11px] text-emerald-600 font-semibold mt-0.5">
                        Telah disetujui RT/RW pada {{ $letterRequest->rt_verified_at->translatedFormat('d M Y - H:i') }} WIB
                    </div>
                    @if($letterRequest->rt_notes)
                        <div class="text-[11px] text-slate-500 italic mt-1">Catatan: {{ $letterRequest->rt_notes }}</div>
                    @endif
                @elseif($letterRequest->status === 'pending_rt')
                    <div class="text-[11px] text-amber-600 font-semibold mt-0.5">Sedang menunggu konfirmasi dari Pengurus RT/RW setempat...</div>
                @else
                    <div class="text-[11px] text-slate-400 mt-0.5">Menunggu antrean</div>
                @endif
            </div>

            <!-- 3. Verifikasi Staf Pelayanan Desa -->
            <div class="relative">
                <div class="absolute -left-[33px] top-0 w-4 h-4 rounded-full
                    @if($letterRequest->staff_verified_at) bg-emerald-500 ring-2 ring-emerald-500
                    @elseif($letterRequest->status === 'pending_staff') bg-blue-500 ring-2 ring-blue-400 animate-pulse
                    @else bg-slate-300 ring-2 ring-slate-200 @endif border-2 border-white"></div>
                <div class="font-bold text-xs text-slate-800">3. Verifikasi Administrasi Staf Desa</div>
                @if($letterRequest->staff_verified_at)
                    <div class="text-[11px] text-emerald-600 font-semibold mt-0.5">
                        Diverifikasi oleh Staf Pelayanan pada {{ $letterRequest->staff_verified_at->translatedFormat('d M Y - H:i') }} WIB
                    </div>
                    @if($letterRequest->staff_notes)
                        <div class="text-[11px] text-slate-500 italic mt-1">Catatan: {{ $letterRequest->staff_notes }}</div>
                    @endif
                @elseif($letterRequest->status === 'pending_staff')
                    <div class="text-[11px] text-blue-600 font-semibold mt-0.5">Sedang ditinjau oleh operator / staf kantor desa...</div>
                @else
                    <div class="text-[11px] text-slate-400 mt-0.5">Menunggu tahapan sebelumnya</div>
                @endif
            </div>

            <!-- 4. Pengesahan Kades TTE -->
            <div class="relative">
                <div class="absolute -left-[33px] top-0 w-4 h-4 rounded-full
                    @if($letterRequest->kades_approved_at) bg-emerald-500 ring-2 ring-emerald-500
                    @elseif($letterRequest->status === 'pending_kades') bg-indigo-500 ring-2 ring-indigo-400 animate-pulse
                    @else bg-slate-300 ring-2 ring-slate-200 @endif border-2 border-white"></div>
                <div class="font-bold text-xs text-slate-800">4. Tanda Tangan Elektronik (TTE) Kepala Desa</div>
                @if($letterRequest->kades_approved_at)
                    <div class="text-[11px] text-emerald-600 font-semibold mt-0.5">
                        Disahkan secara elektronik oleh Kepala Desa pada {{ $letterRequest->kades_approved_at->translatedFormat('d M Y - H:i') }} WIB
                    </div>
                @elseif($letterRequest->status === 'pending_kades')
                    <div class="text-[11px] text-indigo-600 font-semibold mt-0.5">Sedang menunggu penandatanganan elektronik oleh Kepala Desa...</div>
                @else
                    <div class="text-[11px] text-slate-400 mt-0.5">Menunggu tahapan sebelumnya</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
