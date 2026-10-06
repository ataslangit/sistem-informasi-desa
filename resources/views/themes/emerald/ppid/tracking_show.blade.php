@extends(theme_layout())

@section('title', "Status Tiket {$ticket} - PPID Desa " . \App\Models\Setting::get('village_name', 'Desa Sukamaju'))

@section('content')
<!-- Banner Hero Hijau Zamrud (Jumbotron Detail Tiket PPID Tema Emerald) -->
<section class="relative px-4 sm:px-6 lg:px-8 pt-6 pb-4">
    <div class="max-w-7xl mx-auto">
        <div class="relative rounded-3xl overflow-hidden shadow-2xl shadow-emerald-950/20 bg-gradient-to-br from-emerald-950 via-emerald-900 to-teal-950 py-10 sm:py-14 px-6 sm:px-12 text-white">
            <!-- Background Landscape Overlay -->
            <div class="absolute inset-0 bg-cover bg-center opacity-15 mix-blend-overlay pointer-events-none" style="background-image: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=1600&q=80');"></div>
            <!-- Radial Glow Ornaments -->
            <div class="absolute -right-10 -bottom-10 w-80 h-80 bg-emerald-400/10 rounded-full blur-3xl pointer-events-none"></div>
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
                    <a href="{{ route('public.ppid.tracking') }}" class="hover:text-white transition">Lacak Tiket</a>
                    <span class="text-emerald-500">/</span>
                    <span class="text-white font-mono font-semibold">{{ $ticket }}</span>
                </nav>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-2">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-200 text-xs font-bold backdrop-blur-md mb-2">
                            <span>🔍</span>
                            <span>Hasil Pelacakan Tiket Layanan Informasi</span>
                        </div>
                        <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white font-mono tracking-tight">
                            {{ $ticket }}
                        </h1>
                    </div>
                    <div>
                        @if($objection)
                            <span class="inline-flex items-center px-4 py-2 rounded-2xl text-xs font-bold border backdrop-blur-md shadow-lg {{ $objection->status_badge_class }}">
                                {{ $objection->status_label }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-4 py-2 rounded-2xl text-xs font-bold border backdrop-blur-md shadow-lg {{ $infoRequest->status_badge_class }}">
                                {{ $infoRequest->status_label }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    @if (session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs flex items-center space-x-2">
            <span>✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Kartu Informasi Keberatan (Jika Tiket Keberatan atau Permohonan memiliki keberatan) -->
    @if($objection)
        <div class="bg-white rounded-3xl border border-amber-200 shadow-sm p-6 sm:p-8 space-y-4 bg-amber-50/20">
            <div class="flex items-center justify-between">
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 uppercase tracking-wider">
                    ⚖️ Berkas Keberatan Informasi Publik
                </span>
                <span class="font-mono text-xs text-slate-500">{{ $objection->ticket_number }}</span>
            </div>

            <div class="space-y-2 text-xs">
                <div>
                    <span class="text-slate-400 block">Alasan Keberatan:</span>
                    <span class="font-bold text-slate-800">{{ $objection->reason_label }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Rincian Keberatan Pemohon:</span>
                    <p class="text-slate-700 bg-white p-3 rounded-xl border border-slate-200 mt-1">{{ $objection->objection_detail }}</p>
                </div>

                @if($objection->response_text)
                    <div class="pt-3 border-t border-amber-200">
                        <span class="font-bold text-emerald-800 block mb-1">Keputusan / Tanggapan Resmi Atasan PPID (Kepala Desa):</span>
                        <div class="p-4 bg-white rounded-xl border border-emerald-200 text-slate-800 leading-relaxed">
                            {{ $objection->response_text }}
                        </div>
                        <span class="text-[10px] text-slate-400 mt-1 block">Ditanggapi pada: {{ $objection->responded_at?->format('d/m/Y H:i') }}</span>
                    </div>
                @else
                    <div class="p-3 bg-amber-50 rounded-xl border border-amber-200 text-amber-800 text-[11px]">
                        ⏳ Berkas keberatan ini sedang dalam pemeriksaan dan telaah oleh Atasan PPID (Kepala Desa).
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Rincian Permohonan Informasi Asal -->
    <div class="bg-white rounded-3xl border border-emerald-100 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div>
                <h2 class="text-base font-bold text-slate-800">Rincian Permohonan Informasi</h2>
                <span class="text-xs text-slate-400">Diajukan pada: {{ $infoRequest->created_at->format('d M Y, H:i') }} {{ timezone_label() }}</span>
            </div>
            <span class="font-mono text-xs font-semibold text-emerald-800 bg-emerald-50 px-3 py-1 rounded-xl border border-emerald-200">
                {{ $infoRequest->ticket_number }}
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
            <div>
                <span class="text-slate-400 block mb-0.5">Nama Pemohon:</span>
                <span class="font-bold text-slate-800">{{ $infoRequest->applicant_name }}</span>
            </div>
            <div>
                <span class="text-slate-400 block mb-0.5">Email / Kontak:</span>
                <span class="text-slate-700">{{ $infoRequest->applicant_email }} ({{ $infoRequest->applicant_phone }})</span>
            </div>
            <div class="sm:col-span-2">
                <span class="text-slate-400 block mb-0.5">Rincian Informasi Dimohon:</span>
                <div class="p-3 bg-slate-50 rounded-xl text-slate-800">{{ $infoRequest->information_requested }}</div>
            </div>
            <div class="sm:col-span-2">
                <span class="text-slate-400 block mb-0.5">Tujuan Penggunaan:</span>
                <div class="p-3 bg-slate-50 rounded-xl text-slate-800">{{ $infoRequest->purpose }}</div>
            </div>
        </div>

        <!-- Tanggapan PPID Desa -->
        <div class="pt-6 border-t border-slate-100 space-y-4">
            <h3 class="text-sm font-bold text-slate-800">Tanggapan Resmi PPID Desa</h3>

            @if($infoRequest->status === 'approved')
                <div class="p-5 bg-emerald-50 rounded-2xl border border-emerald-200 space-y-3">
                    <div class="flex items-center space-x-2 text-emerald-800 font-bold text-xs">
                        <span>✅</span>
                        <span>Permohonan Telah Disetujui / Selesai</span>
                    </div>
                    <div class="text-xs text-slate-700 leading-relaxed bg-white p-4 rounded-xl border border-emerald-100">
                        {{ $infoRequest->response_text }}
                    </div>
                    @if($infoRequest->response_file_path)
                        <div class="pt-2">
                            <a href="{{ asset('storage/' . $infoRequest->response_file_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs space-x-1.5 transition shadow-sm">
                                <span>⬇️</span>
                                <span>Unduh Berkas Salinan Informasi</span>
                            </a>
                        </div>
                    @endif
                    <div class="text-[11px] text-slate-400">
                        Ditanggapi pada: {{ $infoRequest->responded_at?->format('d/m/Y H:i') }} {{ timezone_label() }}
                    </div>
                </div>
            @elseif($infoRequest->status === 'rejected')
                <div class="p-5 bg-rose-50 rounded-2xl border border-rose-200 space-y-3">
                    <div class="flex items-center space-x-2 text-rose-800 font-bold text-xs">
                        <span>⛔</span>
                        <span>Permohonan Ditolak</span>
                    </div>
                    <div class="text-xs text-slate-700 leading-relaxed bg-white p-4 rounded-xl border border-rose-100">
                        <span class="font-bold block text-rose-800 mb-1">Alasan Penolakan Tertulis:</span>
                        {{ $infoRequest->rejection_reason }}
                    </div>
                    <div class="text-[11px] text-slate-400">
                        Diputuskan pada: {{ $infoRequest->responded_at?->format('d/m/Y H:i') }} {{ timezone_label() }}
                    </div>

                    <!-- Tombol Pengajuan Keberatan jika ditolak -->
                    @if(!$infoRequest->objection)
                        <div class="pt-2">
                            <a href="{{ route('public.ppid.objections.create', $infoRequest->ticket_number) }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs space-x-1.5 transition shadow-sm">
                                <span>⚖️</span>
                                <span>Ajukan Keberatan Informasi kepada Kepala Desa</span>
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div class="p-5 bg-teal-50 rounded-2xl border border-teal-200 space-y-2 text-xs text-teal-900">
                    <span class="font-bold flex items-center space-x-1.5">
                        <span>⏳</span>
                        <span>Dalam Proses Penanganan PPID Desa</span>
                    </span>
                    <p class="text-[11px] text-teal-700 leading-relaxed">
                        Permohonan Anda telah tercatat dan saat ini sedang ditinjau serta diproses oleh tim PPID Desa. Mohon periksa kembali nomor tiket ini secara berkala.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
