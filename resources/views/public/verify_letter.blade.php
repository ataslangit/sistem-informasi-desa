<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Keaslian Dokumen - SiDesa {{ $villageName }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-100 min-h-screen py-10 px-4 flex items-center justify-center">
    <div class="max-w-lg w-full bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-slate-900 to-slate-800 p-6 text-white text-center">
            <div class="inline-flex p-3 rounded-2xl bg-white/10 mb-3 backdrop-blur">
                🏛️
            </div>
            <h1 class="text-lg font-bold">Pemerintah Desa {{ $villageName }}</h1>
            <p class="text-xs text-slate-300">Kec. {{ $districtName }}, Kab. {{ $regencyName }}</p>
            <div class="mt-2 text-[11px] font-mono tracking-widest text-blue-300 uppercase">
                Sistem Verifikasi Dokumen & TTE SiDesa
            </div>
        </div>

        <div class="p-6">
            @if($letter && $letter->isApproved())
                <!-- Status Valid -->
                <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 mb-6 text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 mb-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h2 class="text-base font-bold text-emerald-900">DOKUMEN SAH & TERVERIFIKASI</h2>
                    <p class="text-xs text-emerald-700 mt-1">Dokumen ini resmi diterbitkan dan ditandatangani secara elektronik (TTE) oleh Kepala Desa.</p>
                </div>

                <!-- Detail Dokumen -->
                <div class="space-y-3 text-xs">
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Nomor Surat Resmi</span>
                        <span class="font-bold text-slate-800 font-mono">{{ $letter->letter_number }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Jenis Dokumen</span>
                        <span class="font-semibold text-slate-800 text-right">{{ $letter->template->name }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Nama Pemohon / Warga</span>
                        <span class="font-bold text-slate-800">{{ $letter->resident->name }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">NIK (Tersensor)</span>
                        <span class="font-mono text-slate-800">
                            {{ substr($letter->resident->nik, 0, 6) . '******' . substr($letter->resident->nik, -4) }}
                        </span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Keperluan</span>
                        <span class="text-slate-800 text-right italic">{{ $letter->purpose }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Tanggal Pengesahan</span>
                        <span class="font-medium text-slate-800">
                            {{ $letter->signed_at ? $letter->signed_at->translatedFormat('d F Y - H:i:s') . ' WIB' : '-' }}
                        </span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-slate-500">Penandatangan (TTE)</span>
                        <span class="font-bold text-blue-700 text-right">
                            {{ $letter->kadesApprover->name ?? 'Kepala Desa' }}
                        </span>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 text-center">
                    <p class="text-[10px] text-slate-400">
                        Keabsahan data diverifikasi langsung dari basis data server SiDesa (Sistem Informasi Desa).
                    </p>
                </div>
            @else
                <!-- Status Tidak Ditemukan / Tidak Sah -->
                <div class="bg-rose-50 border border-rose-200 rounded-2xl p-6 text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-rose-100 text-rose-600 mb-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>
                    <h2 class="text-base font-bold text-rose-900">DOKUMEN TIDAK TERDAFTAR</h2>
                    <p class="text-xs text-rose-700 mt-2">
                        QR Code atau token dokumen tidak cocok dengan catatan resmi server atau belum selesai disahkan oleh Kepala Desa.
                    </p>
                </div>
            @endif

            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-xs text-blue-600 hover:text-blue-800 font-semibold">
                    &larr; Kembali ke Beranda SiDesa
                </a>
            </div>
        </div>
    </div>
</body>
</html>
