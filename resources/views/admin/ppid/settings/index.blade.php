@extends('admin.layouts.app')

@section('title', 'Pengaturan & Struktur PPID Desa')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Pengaturan Struktur & Maklumat PPID Desa</h2>
        <p class="text-xs text-slate-500 mt-1">Konfigurasi nama pejabat pengelola informasi desa dan maklumat pelayanan informasi publik.</p>
    </div>

    @if (session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs flex items-center space-x-2">
            <span>✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-xs space-y-1">
            <div class="font-bold">⚠️ Periksa isian:</div>
            <ul class="list-disc list-inside space-y-0.5 text-[11px] pt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.ppid-settings.update') }}" method="POST" class="space-y-6 text-xs">
            @csrf

            <!-- Struktur Pejabat PPID -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider text-blue-600">
                    1. Struktur Pejabat Layanan Informasi (Perki No. 1/2018)
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="ppid_leader_name" class="block font-semibold text-slate-700 mb-1">
                            Atasan PPID (Kepala Desa) <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="ppid_leader_name" 
                            id="ppid_leader_name" 
                            value="{{ old('ppid_leader_name', $settings['ppid_leader_name']) }}" 
                            required 
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>

                    <div>
                        <label for="ppid_officer_name" class="block font-semibold text-slate-700 mb-1">
                            PPID Desa (Sekretaris Desa) <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="ppid_officer_name" 
                            id="ppid_officer_name" 
                            value="{{ old('ppid_officer_name', $settings['ppid_officer_name']) }}" 
                            required 
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>
                </div>

                <div>
                    <label for="ppid_desk_officers" class="block font-semibold text-slate-700 mb-1">
                        Petugas Pelayanan Informasi (Desk PPID / Perangkat Desa) <span class="text-rose-500">*</span>
                    </label>
                    <textarea 
                        name="ppid_desk_officers" 
                        id="ppid_desk_officers" 
                        rows="3" 
                        required 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none font-mono"
                    >{{ old('ppid_desk_officers', $settings['ppid_desk_officers']) }}</textarea>
                    <p class="text-[11px] text-slate-400 mt-1">Pisahkan per baris untuk masing-masing jabatan/nama petugas desk.</p>
                </div>
            </div>

            <!-- Maklumat Pelayanan & Jam Layanan -->
            <div class="pt-6 border-t border-slate-100 space-y-4">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider text-blue-600">
                    2. Maklumat Pelayanan & Waktu Layanan Informasi
                </h3>

                <div>
                    <label for="ppid_maklumat" class="block font-semibold text-slate-700 mb-1">
                        Teks Maklumat Pelayanan Informasi Publik <span class="text-rose-500">*</span>
                    </label>
                    <textarea 
                        name="ppid_maklumat" 
                        id="ppid_maklumat" 
                        rows="4" 
                        required 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >{{ old('ppid_maklumat', $settings['ppid_maklumat']) }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="ppid_service_hours" class="block font-semibold text-slate-700 mb-1">
                            Jam Layanan Meja PPID <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="ppid_service_hours" 
                            id="ppid_service_hours" 
                            value="{{ old('ppid_service_hours', $settings['ppid_service_hours']) }}" 
                            required 
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>

                    <div>
                        <label for="ppid_phone" class="block font-semibold text-slate-700 mb-1">
                            Nomor Kontak Layanan PPID <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="ppid_phone" 
                            id="ppid_phone" 
                            value="{{ old('ppid_phone', $settings['ppid_phone']) }}" 
                            required 
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>

                    <div>
                        <label for="ppid_email" class="block font-semibold text-slate-700 mb-1">
                            Email Resmi PPID Desa <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            name="ppid_email" 
                            id="ppid_email" 
                            value="{{ old('ppid_email', $settings['ppid_email']) }}" 
                            required 
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-sm transition">
                    Simpan Perubahan Pengaturan PPID
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
