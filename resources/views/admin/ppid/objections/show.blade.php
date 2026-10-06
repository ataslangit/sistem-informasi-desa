@extends('admin.layouts.app')

@section('title', "Tinjauan Keberatan {$ppidObjection->ticket_number}")

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.ppid-objections.index') }}" class="text-xs text-slate-500 hover:text-slate-800 mb-1 inline-block">
                &larr; Kembali ke Daftar Keberatan
            </a>
            <div class="flex items-center space-x-3">
                <h2 class="text-xl font-bold font-mono text-slate-800">{{ $ppidObjection->ticket_number }}</h2>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $ppidObjection->status_badge_class }}">
                    {{ $ppidObjection->status_label }}
                </span>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs flex items-center space-x-2">
            <span>✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Data Permohonan Asal & Pemohon -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Permohonan Informasi Asal</h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
            <div>
                <span class="text-slate-400 block">Nomor Tiket Asal:</span>
                <a href="{{ route('admin.ppid-requests.show', $ppidObjection->request) }}" class="font-mono font-bold text-blue-600 hover:underline">
                    {{ $ppidObjection->request->ticket_number }}
                </a>
            </div>
            <div>
                <span class="text-slate-400 block">Nama Pemohon:</span>
                <span class="font-bold text-slate-800">{{ $ppidObjection->request->applicant_name }}</span>
            </div>
            <div class="sm:col-span-2">
                <span class="text-slate-400 block mb-1">Informasi yang Pernah Dimohonkan:</span>
                <div class="p-3 bg-slate-50 rounded-xl text-slate-800">{{ $ppidObjection->request->information_requested }}</div>
            </div>
            @if($ppidObjection->request->rejection_reason)
                <div class="sm:col-span-2">
                    <span class="text-rose-500 font-bold block mb-1">Alasan Penolakan PPID Sebelumnya:</span>
                    <div class="p-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl">{{ $ppidObjection->request->rejection_reason }}</div>
                </div>
            @endif
        </div>
    </div>

    <!-- Substansi Keberatan Pemohon -->
    <div class="bg-white rounded-2xl border border-amber-200 shadow-sm p-6 space-y-4 bg-amber-50/20">
        <h3 class="text-xs font-bold text-amber-800 uppercase tracking-wider">Substansi Keberatan Pemohon</h3>
        
        <div class="space-y-3 text-xs">
            <div>
                <span class="text-slate-400 block">Alasan Pengajuan Keberatan:</span>
                <span class="font-bold text-slate-800 text-sm">{{ $ppidObjection->reason_label }}</span>
            </div>
            <div>
                <span class="text-slate-400 block mb-1">Rincian Kronologi & Argumentasi Pemohon:</span>
                <div class="p-4 bg-white rounded-xl border border-slate-200 text-slate-800 leading-relaxed">{{ $ppidObjection->objection_detail }}</div>
            </div>
            <span class="text-[11px] text-slate-400 block">Diajukan pada: {{ $ppidObjection->created_at->format('d M Y, H:i') }} {{ timezone_label() }}</span>
        </div>
    </div>

    <!-- Keputusan Atasan PPID (Kepala Desa) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Keputusan & Tanggapan Atasan PPID (Kepala Desa)</h3>

        @if($ppidObjection->response_text)
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 text-xs space-y-2">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-slate-800">Tanggapan Resmi Kepala Desa:</span>
                    <span class="text-[11px] text-slate-400">{{ $ppidObjection->responded_at?->format('d/m/Y H:i') }}</span>
                </div>
                <p class="text-slate-700 leading-relaxed">{{ $ppidObjection->response_text }}</p>
                <span class="text-[10px] text-slate-400 block">Penandatangan/Pemeriksa: {{ $ppidObjection->responder?->name ?? 'Kepala Desa' }}</span>
            </div>
        @endif

        <!-- Form Tanggapan Kades -->
        <form action="{{ route('admin.ppid-objections.respond', $ppidObjection) }}" method="POST" class="space-y-4 text-xs pt-2">
            @csrf

            <div>
                <label for="status" class="block font-semibold text-slate-700 mb-1">Keputusan Atasan PPID <span class="text-rose-500">*</span></label>
                <select name="status" id="status" required class="w-full px-3 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none bg-white">
                    <option value="upheld" {{ old('status', $ppidObjection->status) === 'upheld' ? 'selected' : '' }}>Keberatan Diterima (Perintahkan PPID Memberikan Informasi)</option>
                    <option value="rejected" {{ old('status', $ppidObjection->status) === 'rejected' ? 'selected' : '' }}>Keberatan Ditolak (Kuatkan Penolakan PPID Sesuai Ketentuan Hukum)</option>
                    <option value="reviewed" {{ old('status', $ppidObjection->status) === 'reviewed' ? 'selected' : '' }}>Sedang Ditinjau / Dalam Mediasi Internal</option>
                </select>
            </div>

            <div>
                <label for="response_text" class="block font-semibold text-slate-700 mb-1">Pertimbangan & Keputusan Tertulis Kepala Desa <span class="text-rose-500">*</span></label>
                <textarea name="response_text" id="response_text" rows="5" required placeholder="Tuliskan pertimbangan hukum dan arahan keputusan Kepala Desa kepada pemohon..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none">{{ old('response_text', $ppidObjection->response_text) }}</textarea>
            </div>

            <div class="pt-2">
                <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-sm transition">
                    Simpan Keputusan Atasan PPID
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
