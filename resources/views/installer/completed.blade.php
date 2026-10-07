@extends('installer.layout')

@section('title', 'Instalasi Berhasil')

@section('content')
<div class="text-center space-y-6 py-4">
    <!-- Success Icon -->
    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-emerald-100 text-emerald-600 text-4xl shadow-md">
        🎉
    </div>

    <div class="space-y-2">
        <h2 class="text-2xl font-extrabold text-slate-900">Selamat! SiDesa Berhasil Dipasang</h2>
        <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto">
            Aplikasi Sistem Informasi Desa telah siap digunakan. Seluruh struktur tabel basis data, hak akses peran, dan akun administrator utama telah aktif.
        </p>
    </div>

    <!-- Ringkasan Informasi Instalasi -->
    <div class="p-5 bg-slate-50 rounded-2xl border border-slate-200 text-left text-xs space-y-3">
        <h3 class="font-bold text-slate-800 uppercase tracking-wider text-[11px] pb-2 border-b border-slate-200 flex items-center space-x-2">
            <span>📋</span>
            <span>Ringkasan Konfigurasi Sistem</span>
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-slate-700">
            <div>
                <span class="text-slate-400 block text-[10px] uppercase font-bold">Pemerintahan Desa</span>
                <span class="font-bold text-slate-900">{{ $info['village_name'] ?? 'Pemerintah Desa' }}</span>
            </div>
            <div>
                <span class="text-slate-400 block text-[10px] uppercase font-bold">Status Data Awal</span>
                <span class="font-semibold text-slate-800">{{ !empty($info['load_demo_data']) ? 'Contoh Demo Termuat' : 'Basis Data Bersih (Produksi)' }}</span>
            </div>
            <div>
                <span class="text-slate-400 block text-[10px] uppercase font-bold">Username Administrator</span>
                <span class="font-mono font-bold text-blue-600">{{ $info['admin_username'] ?? 'admin' }}</span>
            </div>
            <div>
                <span class="text-slate-400 block text-[10px] uppercase font-bold">Email Administrator</span>
                <span class="font-mono text-slate-800">{{ $info['admin_email'] ?? 'admin@desa.id' }}</span>
            </div>
        </div>
    </div>

    <!-- Peringatan Keamanan Kunci -->
    <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-left text-xs text-amber-900 space-y-1">
        <div class="flex items-center space-x-2 font-bold">
            <span>🔒</span>
            <span>Keamanan Sistem Terjamin:</span>
        </div>
        <p class="text-[11px] text-amber-800 leading-relaxed">
            Berkas kunci <code>storage/installed</code> telah otomatis dibuat. Jalur URL <code>/install</code> sekarang dikunci secara permanen dan tidak dapat diakses kembali demi melindungi data Anda.
        </p>
    </div>

    <!-- Tombol Aksi Menuju Dashboard / Portal -->
    <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
        <a href="{{ route('admin.login') }}" class="w-full sm:w-auto px-6 py-3 rounded-xl text-xs font-bold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm flex items-center justify-center space-x-2">
            <span>Masuk ke Dashboard Admin</span>
            <span>&rarr;</span>
        </a>
        <a href="{{ route('home') }}" class="w-full sm:w-auto px-6 py-3 rounded-xl text-xs font-semibold bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition">
            Lihat Portal Publik Desa
        </a>
    </div>
</div>
@endsection
