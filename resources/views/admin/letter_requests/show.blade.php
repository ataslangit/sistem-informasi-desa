@extends('admin.layouts.app')

@section('title', 'Detail Permohonan ' . $letterRequest->request_number)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.letter-requests.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <div class="flex items-center space-x-2">
                    <h2 class="text-xl font-bold text-slate-800">{{ $letterRequest->request_number }}</h2>
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
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $badge }}">
                        {{ $letterRequest->status_label }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">{{ $letterRequest->template->name }}</p>
            </div>
        </div>

        @if($letterRequest->isApproved())
            <div>
                <a href="{{ route('admin.letter-requests.pdf', $letterRequest) }}" target="_blank" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition shadow space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Unduh PDF Resmi (TTE)</span>
                </a>
            </div>
        @endif
    </div>

    <!-- Timeline 3 Tahap Alur Persetujuan -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-6">Alur Verifikasi 3 Tahap</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 relative">
            <!-- Step 1: Warga Submit -->
            <div class="p-4 rounded-xl border {{ $letterRequest->created_at ? 'bg-emerald-50/50 border-emerald-200' : 'bg-slate-50 border-slate-200' }}">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-bold uppercase text-slate-500">1. Pengajuan Warga</span>
                    <span class="text-xs">✅</span>
                </div>
                <div class="font-bold text-slate-800 text-xs">{{ $letterRequest->resident->name }}</div>
                <div class="text-[10px] text-slate-500 mt-1">{{ $letterRequest->created_at->translatedFormat('d M Y - H:i') }}</div>
            </div>

            <!-- Step 2: RT/RW -->
            <div class="p-4 rounded-xl border
                @if($letterRequest->rt_verified_at) bg-emerald-50/50 border-emerald-200
                @elseif($letterRequest->status === 'pending_rt') bg-amber-50/50 border-amber-300 ring-2 ring-amber-400/20
                @else bg-slate-50 border-slate-200 @endif">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-bold uppercase text-slate-500">2. Verifikasi RT/RW</span>
                    @if($letterRequest->rt_verified_at) <span class="text-xs">✅</span>
                    @elseif($letterRequest->status === 'pending_rt') <span class="text-xs">⏳</span>
                    @else <span class="text-xs">⚪</span> @endif
                </div>
                @if($letterRequest->rt_verified_at)
                    <div class="font-bold text-slate-800 text-xs">{{ $letterRequest->rtVerifier->name ?? 'Pengurus RT/RW' }}</div>
                    <div class="text-[10px] text-slate-500 mt-1">{{ $letterRequest->rt_verified_at->translatedFormat('d M Y - H:i') }}</div>
                    @if($letterRequest->rt_notes)
                        <div class="text-[10px] text-slate-600 mt-1 bg-white p-1.5 rounded border border-slate-100 italic">"{{ $letterRequest->rt_notes }}"</div>
                    @endif
                @else
                    <div class="text-xs text-slate-400 italic">Menunggu verifikasi ketua RT/RW</div>
                @endif
            </div>

            <!-- Step 3: Staf Desa -->
            <div class="p-4 rounded-xl border
                @if($letterRequest->staff_verified_at) bg-emerald-50/50 border-emerald-200
                @elseif($letterRequest->status === 'pending_staff') bg-blue-50/50 border-blue-300 ring-2 ring-blue-400/20
                @else bg-slate-50 border-slate-200 @endif">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-bold uppercase text-slate-500">3. Verifikasi Staf</span>
                    @if($letterRequest->staff_verified_at) <span class="text-xs">✅</span>
                    @elseif($letterRequest->status === 'pending_staff') <span class="text-xs">⏳</span>
                    @else <span class="text-xs">⚪</span> @endif
                </div>
                @if($letterRequest->staff_verified_at)
                    <div class="font-bold text-slate-800 text-xs">{{ $letterRequest->staffVerifier->name ?? 'Staf Pelayanan' }}</div>
                    <div class="text-[10px] text-slate-500 mt-1">{{ $letterRequest->staff_verified_at->translatedFormat('d M Y - H:i') }}</div>
                    @if($letterRequest->staff_notes)
                        <div class="text-[10px] text-slate-600 mt-1 bg-white p-1.5 rounded border border-slate-100 italic">"{{ $letterRequest->staff_notes }}"</div>
                    @endif
                @else
                    <div class="text-xs text-slate-400 italic">Menunggu verifikasi staf pelayanan</div>
                @endif
            </div>

            <!-- Step 4: Kades TTE -->
            <div class="p-4 rounded-xl border
                @if($letterRequest->kades_approved_at) bg-emerald-50/50 border-emerald-200
                @elseif($letterRequest->status === 'pending_kades') bg-indigo-50/50 border-indigo-300 ring-2 ring-indigo-400/20
                @else bg-slate-50 border-slate-200 @endif">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-bold uppercase text-slate-500">4. TTE Kepala Desa</span>
                    @if($letterRequest->kades_approved_at) <span class="text-xs">✍️</span>
                    @elseif($letterRequest->status === 'pending_kades') <span class="text-xs">⏳</span>
                    @else <span class="text-xs">⚪</span> @endif
                </div>
                @if($letterRequest->kades_approved_at)
                    <div class="font-bold text-slate-800 text-xs">{{ $letterRequest->kadesApprover->name ?? 'Kepala Desa' }}</div>
                    <div class="text-[10px] text-slate-500 mt-1">{{ $letterRequest->kades_approved_at->translatedFormat('d M Y - H:i') }}</div>
                    <div class="text-[10px] text-emerald-700 font-semibold mt-1">Disahkan secara elektronik</div>
                @else
                    <div class="text-xs text-slate-400 italic">Menunggu persetujuan Kades</div>
                @endif
            </div>
        </div>

        @if($letterRequest->isRejected())
            <div class="mt-4 p-4 rounded-xl bg-rose-50 border border-rose-200 text-xs">
                <div class="font-bold text-rose-800 mb-1">❌ Permohonan Ditolak</div>
                <div class="text-rose-700">Alasan: {{ $letterRequest->rejection_reason }}</div>
                <div class="text-[10px] text-rose-500 mt-1">
                    Ditolak oleh {{ $letterRequest->rejecter->name ?? 'Aparat Desa' }} pada {{ $letterRequest->rejected_at?->translatedFormat('d M Y H:i') }}
                </div>
            </div>
        @endif
    </div>

    <!-- Action Forms for Approvals -->
    @if(!$letterRequest->isApproved() && !$letterRequest->isRejected())
        @if($letterRequest->canBeProcessedBy(auth()->user()))
            <div class="bg-slate-900 text-white p-6 rounded-2xl shadow-sm">
                <h3 class="text-sm font-bold uppercase tracking-wider mb-4">Aksi Verifikasi & Persetujuan</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Approval Form -->
                    <div>
                        @if($letterRequest->status === 'pending_rt')
                            @if(auth()->user()->hasRole(['superadmin', 'rt']) || auth()->user()->hasPermission('letters.verify_rt'))
                                <form action="{{ route('admin.letter-requests.verify-rt', $letterRequest) }}" method="POST" class="space-y-3">
                                    @csrf
                                    <label class="block text-xs text-slate-300">Catatan Verifikasi RT/RW (Opsional):</label>
                                    <input type="text" name="notes" placeholder="cth: Data kependudukan RT/RW sesuai dan disetujui" class="w-full px-3 py-2 rounded-xl text-xs bg-slate-800 border border-slate-700 text-white placeholder-slate-500">
                                    <button type="submit" class="w-full py-2.5 rounded-xl bg-amber-500 text-slate-950 text-xs font-bold hover:bg-amber-400 transition">
                                        Verifikasi & Setujui Tahap RT/RW &rarr;
                                    </button>
                                </form>
                            @endif

                            @if(auth()->user()->hasRole(['superadmin', 'perangkat']) || auth()->user()->hasPermission('letters.process'))
                                <div class="{{ (auth()->user()->hasRole(['superadmin', 'rt']) || auth()->user()->hasPermission('letters.verify_rt')) ? 'mt-4 pt-4 border-t border-slate-800' : '' }}">
                                    <form action="{{ route('admin.letter-requests.bypass-rt', $letterRequest) }}" method="POST" class="space-y-3">
                                        @csrf
                                        <div class="flex items-center justify-between">
                                            <label class="block text-xs text-amber-300 font-semibold">⚡ Bypass Verifikasi RT/RW (Staf Desa):</label>
                                            <span class="text-[10px] text-slate-400">Warga membawa pengantar fisik RT/RW</span>
                                        </div>
                                        <input type="text" name="bypass_notes" placeholder="cth: Pengantar fisik RT/RW No. 12/X/2026 diverifikasi manual oleh staf" class="w-full px-3 py-2 rounded-xl text-xs bg-slate-800 border border-slate-700 text-white placeholder-slate-500">
                                        <button type="submit" class="w-full py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 text-slate-950 text-xs font-bold hover:brightness-110 transition shadow">
                                            Bypass RT/RW & Teruskan ke Kades &rarr;
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @elseif($letterRequest->status === 'pending_staff' && (auth()->user()->hasRole(['superadmin', 'perangkat']) || auth()->user()->hasPermission('letters.process')))
                            <form action="{{ route('admin.letter-requests.verify-staff', $letterRequest) }}" method="POST" class="space-y-3">
                                @csrf
                                <label class="block text-xs text-slate-300">Catatan Staf Pelayanan (Opsional):</label>
                                <input type="text" name="notes" placeholder="cth: Berkas persyaratan lengkap dan valid" class="w-full px-3 py-2 rounded-xl text-xs bg-slate-800 border border-slate-700 text-white placeholder-slate-500">
                                <button type="submit" class="w-full py-2.5 rounded-xl bg-blue-600 text-white text-xs font-bold hover:bg-blue-500 transition">
                                    Verifikasi Staf & Teruskan ke Kades &rarr;
                                </button>
                            </form>
                        @elseif($letterRequest->status === 'pending_kades' && (auth()->user()->hasRole(['superadmin', 'kades']) || auth()->user()->hasPermission('letters.approve')))
                            <form action="{{ route('admin.letter-requests.approve-kades', $letterRequest) }}" method="POST" class="space-y-3">
                                @csrf
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <label class="block text-xs text-emerald-300 font-semibold">Nomor Surat Resmi:</label>
                                        <span class="text-[10px] text-slate-400">Format sistem (dapat disesuaikan)</span>
                                    </div>
                                    <input type="text" name="letter_number" value="{{ $suggestedLetterNumber ?? '' }}" placeholder="cth: {{ $suggestedLetterNumber ?? '' }}" class="w-full px-3 py-2 rounded-xl text-xs bg-slate-800 border border-slate-700 text-emerald-300 font-mono font-bold focus:outline-none focus:border-emerald-500">
                                </div>

                                <div>
                                    <label class="block text-xs text-slate-300 mb-1">Catatan Kepala Desa (Opsional):</label>
                                    <input type="text" name="notes" placeholder="cth: Disetujui dan disahkan" class="w-full px-3 py-2 rounded-xl text-xs bg-slate-800 border border-slate-700 text-white placeholder-slate-500">
                                </div>

                                <button type="submit" class="w-full py-2.5 rounded-xl bg-emerald-500 text-slate-950 text-xs font-bold hover:bg-emerald-400 transition flex items-center justify-center space-x-2 shadow-lg">
                                    <span>✍️</span>
                                    <span>Sahkan Dokumen & Tanda Tangan Elektronik (TTE)</span>
                                </button>
                            </form>
                        @endif
                    </div>

                    <!-- Rejection Form -->
                    <div class="border-t md:border-t-0 md:border-l border-slate-800 md:pl-6 pt-4 md:pt-0">
                        <form action="{{ route('admin.letter-requests.reject', $letterRequest) }}" method="POST" class="space-y-3" onsubmit="return confirm('Apakah Anda yakin ingin menolak permohonan surat ini?');">
                            @csrf
                            <label class="block text-xs text-rose-300">Tolak Permohonan Surat:</label>
                            <input type="text" name="rejection_reason" required placeholder="Tulis alasan penolakan berkas..." class="w-full px-3 py-2 rounded-xl text-xs bg-slate-800 border border-slate-700 text-white placeholder-slate-500">
                            <button type="submit" class="w-full py-2 rounded-xl bg-rose-600/80 hover:bg-rose-600 text-white text-xs font-semibold transition">
                                Tolak Permohonan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-slate-50 border border-slate-200 p-5 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                <div class="flex items-center space-x-3">
                    <span class="text-2xl">ℹ️</span>
                    <div>
                        <div class="font-bold text-slate-800">
                            Status Permohonan: <span class="text-amber-600">{{ $letterRequest->status_label }}</span>
                        </div>
                        <p class="text-slate-500 mt-0.5">
                            @if($letterRequest->rt_verified_at && auth()->user()->hasRole('rt'))
                                Anda telah memverifikasi permohonan ini pada tingkat RT/RW. Berkas saat ini sedang dalam proses oleh tahapan selanjutnya.
                            @else
                                Anda tidak memiliki hak otorisasi untuk memproses atau menolak permohonan pada tahapan ini.
                            @endif
                        </p>
                    </div>
                </div>
                <div class="text-[11px] bg-white border border-slate-200 px-3 py-1.5 rounded-lg text-slate-500 font-medium self-start sm:self-center">
                    Hanya Petugas Tahap Aktif
                </div>
            </div>
        @endif
    @endif

    <!-- 2 Kolom: Detail Warga vs Preview Surat -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Biodata Warga -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2">Biodata Pemohon</h3>
            
            <div class="space-y-3 text-xs">
                <div>
                    <span class="block text-slate-400 text-[10px]">Nama Lengkap</span>
                    <span class="font-bold text-slate-800 text-sm">{{ $letterRequest->resident->name }}</span>
                </div>
                <div>
                    <span class="block text-slate-400 text-[10px]">NIK</span>
                    <span class="font-mono font-bold text-slate-700">{{ $letterRequest->resident->nik }}</span>
                </div>
                <div>
                    <span class="block text-slate-400 text-[10px]">Nomor Kartu Keluarga</span>
                    <span class="font-mono text-slate-700">{{ $letterRequest->resident->family?->family_card_number ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-slate-400 text-[10px]">Alamat & Wilayah</span>
                    <span class="text-slate-700">
                        {{ $letterRequest->resident->family?->address ?? '-' }},
                        RT {{ $letterRequest->resident->family?->rt ?? '-' }} / RW {{ $letterRequest->resident->family?->rw ?? '-' }},
                        {{ $letterRequest->resident->family?->hamlet ?? '-' }}
                    </span>
                </div>
                <div>
                    <span class="block text-slate-400 text-[10px]">Keperluan Surat</span>
                    <span class="text-slate-800 font-medium italic">{{ $letterRequest->purpose }}</span>
                </div>
            </div>

            @if(!empty($letterRequest->extra_data))
                @php
                    $fieldLabels = [
                        'business_name' => 'Nama / Jenis Usaha',
                        'nama_usaha' => 'Nama / Jenis Usaha',
                        'business_location' => 'Lokasi Usaha',
                        'lokasi_usaha' => 'Lokasi Usaha',
                        'business_since' => 'Lama / Tahun Berdiri',
                        'lama_usaha' => 'Lama / Tahun Berdiri',
                        'school_or_institution' => 'Instansi / Lembaga Tujuan',
                        'nama_instansi' => 'Instansi / Lembaga Tujuan',
                    ];
                @endphp
                <div class="pt-3 border-t border-slate-100">
                    <span class="block text-slate-400 text-[10px] mb-2 font-bold uppercase">Data Tambahan</span>
                    <div class="space-y-2 text-xs">
                        @foreach($letterRequest->extra_data as $key => $val)
                            <div class="flex justify-between items-start gap-2">
                                <span class="text-slate-500 font-medium">{{ $fieldLabels[$key] ?? ucwords(str_replace('_', ' ', (string) $key)) }}:</span>
                                <span class="font-semibold text-slate-800 text-right">{{ $val }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Pratinjau Redaksi Surat Resmi -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2 mb-4">
                Pratinjau Redaksi Dokumen Surat
            </h3>
            
            <div class="p-6 bg-slate-50 rounded-xl border border-slate-200 font-serif text-xs text-slate-800 leading-relaxed shadow-inner">
                {!! $previewContent !!}
            </div>
        </div>
    </div>
</div>
@endsection
