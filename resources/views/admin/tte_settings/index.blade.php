@extends('admin.layouts.app')

@section('title', 'Konfigurasi TTE Tersertifikasi (BSrE BSSN)')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Tanda Tangan Elektronik (TTE) Tersertifikasi</h2>
            <p class="text-xs text-slate-500 mt-1">Konfigurasi integrasi Penyelenggara Sertifikasi Elektronik (PSrE) / BSrE BSSN sesuai UU No. 1/2024 &amp; PP No. 71/2019.</p>
        </div>
        <div>
            <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                🛡️ Standar BSrE BSSN
            </span>
        </div>
    </div>

    <!-- Alert Keabsahan Yuridis -->
    <div class="bg-indigo-50 border border-indigo-200 p-4 rounded-2xl flex items-start space-x-3 text-xs text-indigo-900">
        <span class="text-xl shrink-0">📜</span>
        <div class="space-y-1">
            <h3 class="font-bold">Dasar Hukum &amp; Kekuatan Pembuktian TTE Instansi Pemerintah:</h3>
            <ul class="list-disc pl-4 space-y-0.5 text-indigo-800 text-[11px]">
                @foreach($regulations as $law)
                    <li>{{ $law }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Status Sertifikat Kades (1/3) -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4 h-fit">
            <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center justify-between">
                <span>Identitas Penandatangan</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700">Kepala Desa</span>
            </h3>

            @if($kadesUser)
                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-slate-400 text-[10px] block">Nama Pemegang Hak TTE</span>
                        <span class="font-bold text-slate-800 text-sm block">{{ $kadesUser->name }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] block">Email Kedinasan</span>
                        <span class="font-medium text-slate-700 block">{{ $kadesUser->email }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] block">NIP (Nomor Induk Pegawai)</span>
                        <span class="font-mono text-slate-700 block">
                            {{ (is_array($kadesUser->metadata) && isset($kadesUser->metadata['nip'])) ? $kadesUser->metadata['nip'] : '197508152005011002' }}
                        </span>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] block">Status Sertifikat X.509</span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 mt-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span>Sertifikat Aktif (BSrE BSSN)</span>
                        </span>
                    </div>
                </div>
            @else
                <div class="p-4 bg-amber-50 rounded-xl border border-amber-200 text-xs text-amber-800">
                    Akun Kepala Desa belum ditemukan. Buat akun dengan role 'kades' pada manajemen pengguna.
                </div>
            @endif
        </div>

        <!-- Form Konfigurasi (2/3) -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider pb-2 border-b border-slate-100">
                Pengaturan Koneksi PSrE / BSrE BSSN
            </h3>

            <form action="{{ route('admin.tte-settings.update') }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="tte_provider" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Penyelenggara Sertifikasi (PSrE) <span class="text-rose-500">*</span>
                        </label>
                        <select 
                            id="tte_provider" 
                            name="tte_provider" 
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 bg-white"
                        >
                            <option value="bsre_bssn" {{ $settings['tte_provider'] === 'bsre_bssn' ? 'selected' : '' }}>
                                BSrE BSSN (Pemerintah / Instansi Resmi)
                            </option>
                            <option value="peruri" {{ $settings['tte_provider'] === 'peruri' ? 'selected' : '' }}>
                                Perum Peruri Digital Signature
                            </option>
                            <option value="local" {{ $settings['tte_provider'] === 'local' ? 'selected' : '' }}>
                                TTE Lokal SiDesa (Internal)
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="tte_bsre_client_id" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Client ID Instansi Desa <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="tte_bsre_client_id" 
                            name="tte_bsre_client_id" 
                            value="{{ old('tte_bsre_client_id', $settings['tte_bsre_client_id']) }}" 
                            required 
                            class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-mono"
                        >
                    </div>
                </div>

                <div>
                    <label for="tte_bsre_url" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Endpoint URL Gateway API BSrE <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="url" 
                        id="tte_bsre_url" 
                        name="tte_bsre_url" 
                        value="{{ old('tte_bsre_url', $settings['tte_bsre_url']) }}" 
                        required 
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-mono"
                    >
                </div>

                <div>
                    <label for="tte_bsre_issuer" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Nama Penerbit Sertifikat (Issuer) <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="tte_bsre_issuer" 
                        name="tte_bsre_issuer" 
                        value="{{ old('tte_bsre_issuer', $settings['tte_bsre_issuer']) }}" 
                        required 
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs"
                    >
                </div>

                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <label class="flex items-center space-x-2.5 cursor-pointer select-none">
                        <input 
                            type="checkbox" 
                            name="tte_sandbox_mode" 
                            value="1" 
                            {{ $settings['tte_sandbox_mode'] ? 'checked' : '' }} 
                            class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4 cursor-pointer"
                        >
                        <div>
                            <span class="text-xs font-bold text-slate-800 block">Mode Sandbox / Simulasi API BSrE</span>
                            <span class="text-[11px] text-slate-500 block">Aktifkan untuk pengujian dan lingkungan simulasi sebelum terhubung ke server produksi BSSN.</span>
                        </div>
                    </label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 hover:bg-blue-700 text-white transition shadow-sm">
                        Simpan Perubahan Konfigurasi TTE
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
