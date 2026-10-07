@extends('admin.layouts.app')

@section('title', "Detail Permohonan {$ppidRequest->ticket_number}")

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.ppid-requests.index') }}" class="text-xs text-slate-500 hover:text-slate-800 mb-1 inline-block">
                &larr; Kembali ke Daftar Permohonan
            </a>
            <div class="flex items-center space-x-3">
                <h2 class="text-xl font-bold font-mono text-slate-800">{{ $ppidRequest->ticket_number }}</h2>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $ppidRequest->status_badge_class }}">
                    {{ $ppidRequest->status_label }}
                </span>
            </div>
        </div>
        
        @if($ppidRequest->status === 'submitted')
            <form action="{{ route('admin.ppid-requests.process', $ppidRequest) }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-sm transition">
                    ▶️ Mulai Proses Telaah
                </button>
            </form>
        @endif
    </div>

    @if (session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs flex items-center space-x-2">
            <span>✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($ppidRequest->objection && $ppidRequest->objection->status === 'upheld')
        <div class="p-4 bg-emerald-50 border-2 border-emerald-300 text-emerald-900 rounded-2xl text-xs space-y-1 shadow-sm">
            <div class="flex items-center space-x-2 font-bold text-emerald-800">
                <span class="text-base">📢</span>
                <span>Perintah Kepala Desa (Atasan PPID): Keberatan Pemohon DITERIMA</span>
            </div>
            <p class="text-emerald-700">
                Keberatan atas penolakan tiket ini telah disetujui oleh Kepala Desa (Tiket: <a href="{{ route('admin.ppid-objections.show', $ppidRequest->objection) }}" class="underline font-mono font-bold">{{ $ppidRequest->objection->ticket_number }}</a>). PPID Desa diperintahkan untuk segera mengunggah dokumen/jawaban informasi publik di formulir bawah ini.
            </p>
        </div>
    @endif

    <!-- Data Pemohon -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Identitas Pemohon Informasi</h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
            <div>
                <span class="text-slate-400 block">Nama Lengkap:</span>
                <span class="font-bold text-slate-800 text-sm">{{ $ppidRequest->applicant_name }}</span>
            </div>
            <div>
                <span class="text-slate-400 block">NIK:</span>
                <span class="font-mono text-slate-700">{{ $ppidRequest->applicant_nik ?? 'Tidak dicantumkan' }}</span>
            </div>
            <div>
                <span class="text-slate-400 block">Nomor Telepon/WA:</span>
                <span class="text-slate-700">{{ $ppidRequest->applicant_phone }}</span>
            </div>
            <div>
                <span class="text-slate-400 block">Email:</span>
                <span class="text-slate-700">{{ $ppidRequest->applicant_email }}</span>
            </div>
            <div class="sm:col-span-2">
                <span class="text-slate-400 block">Alamat Domisili:</span>
                <span class="text-slate-700">{{ $ppidRequest->applicant_address }}</span>
            </div>
            @if($ppidRequest->identity_card_path)
                <div class="sm:col-span-2 pt-2">
                    <span class="text-slate-400 block mb-1">Lampiran Identitas (KTP):</span>
                    <a href="{{ asset('storage/' . $ppidRequest->identity_card_path) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold space-x-1">
                        <span>🪪</span>
                        <span>Lihat Berkas Identitas KTP</span>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Rincian Permohonan -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rincian Informasi & Tujuan</h3>
        
        <div class="space-y-3 text-xs">
            <div>
                <span class="text-slate-400 block mb-1">Informasi yang Diminta:</span>
                <div class="p-4 bg-slate-50 rounded-xl text-slate-800 leading-relaxed">{{ $ppidRequest->information_requested }}</div>
            </div>
            <div>
                <span class="text-slate-400 block mb-1">Tujuan Penggunaan:</span>
                <div class="p-3 bg-slate-50 rounded-xl text-slate-800">{{ $ppidRequest->purpose }}</div>
            </div>
            <div>
                <span class="text-slate-400 block">Cara Memperoleh Salinan:</span>
                <span class="font-semibold text-slate-700 capitalize">{{ str_replace('_', ' ', $ppidRequest->acquisition_way) }}</span>
            </div>
        </div>
    </div>

    <!-- Jawaban / Tanggapan PPID Saat Ini -->
    @if($ppidRequest->status === 'approved' || $ppidRequest->status === 'rejected')
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-3">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Hasil Tindak Lanjut PPID</h3>
            
            @if($ppidRequest->status === 'approved')
                <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-200 text-xs space-y-2">
                    <span class="font-bold text-emerald-800 block">Jawaban Informasi Publik Diberikan:</span>
                    <p class="text-slate-800 leading-relaxed">{{ $ppidRequest->response_text }}</p>
                    @if($ppidRequest->response_file_path)
                        <div class="pt-1">
                            <a href="{{ asset('storage/' . $ppidRequest->response_file_path) }}" target="_blank" class="inline-flex items-center text-xs font-bold text-emerald-700 hover:underline">
                                <span>📁 Unduh Berkas Jawaban Terlampir</span>
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div class="p-4 bg-rose-50 rounded-xl border border-rose-200 text-xs space-y-1">
                    <span class="font-bold text-rose-800 block">Permohonan Ditolak Tertulis:</span>
                    <p class="text-slate-800 leading-relaxed">{{ $ppidRequest->rejection_reason }}</p>
                </div>
            @endif

            <span class="text-[11px] text-slate-400 block">
                Petugas Penjawab: {{ $ppidRequest->responder?->name ?? '-' }} ({{ $ppidRequest->responded_at?->format('d/m/Y H:i') }})
            </span>
        </div>
    @endif

    <!-- Form Tindak Lanjut PPID (Jika Belum Selesai) -->
    @if($ppidRequest->status === 'submitted' || $ppidRequest->status === 'processed')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Form Setujui & Berikan Jawaban -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                <div class="flex items-center space-x-2 text-emerald-700 font-bold text-sm">
                    <span>✅</span>
                    <span>Setujui & Berikan Jawaban Informasi</span>
                </div>
                <form action="{{ route('admin.ppid-requests.approve', $ppidRequest) }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label for="response_text" class="block font-semibold text-slate-700 mb-1">Rincian Tanggapan / Jawaban <span class="text-rose-500">*</span></label>
                        <textarea name="response_text" id="response_text" rows="4" required placeholder="Tuliskan jawaban atau penjelasan informasi yang dimohon..." class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:outline-none"></textarea>
                    </div>
                    <div>
                        <label for="response_file" class="block font-semibold text-slate-700 mb-1">Lampirkan Berkas (PDF/Excel max 10MB)</label>
                        <input type="file" name="response_file" id="response_file" class="w-full text-slate-500 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-emerald-50 file:text-emerald-700">
                    </div>
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded-xl shadow-sm transition">
                        Kirim Jawaban Resmi
                    </button>
                </form>
            </div>

            <!-- Form Tolak Permohonan -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                <div class="flex items-center space-x-2 text-rose-700 font-bold text-sm">
                    <span>⛔</span>
                    <span>Tolak Permohonan Informasi</span>
                </div>
                <form action="{{ route('admin.ppid-requests.reject', $ppidRequest) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label for="rejection_reason" class="block font-semibold text-slate-700 mb-1">Alasan Penolakan Tertulis (Dasar Hukum UU KIP) <span class="text-rose-500">*</span></label>
                        <textarea name="rejection_reason" id="rejection_reason" rows="6" required placeholder="Jelaskan dasar pasal UU KIP atau alasan mengapa informasi ini tidak dapat diberikan / termasuk informasi dikecualikan..." class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-rose-500 focus:outline-none"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-bold py-2.5 rounded-xl shadow-sm transition">
                        Tolak Permohonan
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection
