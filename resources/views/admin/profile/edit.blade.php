@extends('admin.layouts.app')

@section('title', 'Profil Akun Saya')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Pengaturan Profil & Akun</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola data informasi akun, kontak, serta pembaruan kata sandi Anda.</p>
        </div>
        <div class="flex items-center space-x-2">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $user->role_badge_class }}">
                {{ $user->roles->pluck('label')->first() ?? 'Staff' }}
            </span>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                🟢 Akun Aktif
            </span>
        </div>
    </div>

    @if (session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs flex items-center space-x-2 shadow-sm">
            <span>✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-xs space-y-1 shadow-sm">
            <div class="font-bold flex items-center space-x-1.5">
                <span>⚠️</span>
                <span>Terdapat kesalahan pengisian formulir:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5 text-[11px] pt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Kartu Ringkasan Akun -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 flex flex-col sm:flex-row items-center sm:items-start gap-6">
        <div class="w-20 h-20 rounded-full bg-blue-600 text-white font-extrabold flex items-center justify-center text-3xl shadow-lg ring-4 ring-blue-50 flex-shrink-0">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div class="flex-1 text-center sm:text-left space-y-2">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">{{ $user->name }}</h3>
                    <p class="text-xs font-mono text-slate-400">@<span>{{ $user->username }}</span> &bull; {{ $user->email }}</p>
                </div>
                <div class="text-[11px] text-slate-400">
                    Terdaftar sejak: {{ $user->created_at->format('d M Y') }}
                </div>
            </div>

            @if($user->metadata)
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 pt-2">
                    @if(!empty($user->metadata['jabatan']))
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs bg-slate-100 text-slate-700 border border-slate-200">
                            💼 {{ $user->metadata['jabatan'] }}
                        </span>
                    @endif
                    @if(!empty($user->metadata['phone']))
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs bg-slate-100 text-slate-700 border border-slate-200 font-mono">
                            📞 {{ $user->metadata['phone'] }}
                        </span>
                    @endif
                    @if(!empty($user->metadata['rt']))
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs bg-emerald-50 text-emerald-700 border border-emerald-200 font-semibold">
                            📍 Wilayah RT {{ $user->metadata['rt'] }} / RW {{ $user->metadata['rw'] ?? '-' }}
                        </span>
                    @endif
                </div>
            @endif

            <!-- Data Penduduk Tertaut (Khusus Akun Warga) -->
            @if($user->resident)
                <div class="mt-4 p-4 bg-slate-50 rounded-2xl border border-slate-200 text-xs space-y-2">
                    <span class="font-bold text-slate-700 flex items-center gap-1.5">
                        <span>🪪</span>
                        <span>Identitas Kependudukan Terintegrasi (Buku Induk Desa)</span>
                    </span>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 text-slate-600 pt-1">
                        <div>
                            <span class="text-slate-400 block text-[11px]">NIK:</span>
                            <span class="font-mono font-bold text-slate-800">{{ $user->resident->masked_nik }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[11px]">Nomor KK:</span>
                            <span class="font-mono font-semibold text-slate-800">{{ $user->resident->family?->masked_family_card_number ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[11px]">Alamat & Wilayah:</span>
                            <span class="font-semibold text-slate-800">RT {{ $user->resident->family?->rt ?? '-' }} / RW {{ $user->resident->family?->rw ?? '-' }}, {{ $user->resident->family?->address ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Grid Formulir: Informasi Profil & Ubah Password -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- 1. Form Edit Informasi Profil -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-7 space-y-5">
            <div class="flex items-center space-x-2 pb-3 border-b border-slate-100">
                <span class="text-lg">👤</span>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Perbarui Biodata Akun</h3>
                    <p class="text-[11px] text-slate-400">Ubah nama lengkap, username, dan kontak aktif Anda.</p>
                </div>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block font-semibold text-slate-700 mb-1">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name', $user->name) }}" 
                        required 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>

                <div>
                    <label for="username" class="block font-semibold text-slate-700 mb-1">
                        Username (Nama Pengguna) <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="username" 
                        id="username" 
                        value="{{ old('username', $user->username) }}" 
                        required 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    <p class="text-[10px] text-slate-400 mt-1">Digunakan untuk masuk ke sistem. Huruf, angka, strip, dan garis bawah.</p>
                </div>

                <div>
                    <label for="email" class="block font-semibold text-slate-700 mb-1">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email', $user->email) }}" 
                        required 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>

                <div>
                    <label for="phone" class="block font-semibold text-slate-700 mb-1">
                        Nomor Telepon / WhatsApp
                    </label>
                    <input 
                        type="text" 
                        name="phone" 
                        id="phone" 
                        value="{{ old('phone', $user->metadata['phone'] ?? '') }}" 
                        placeholder="Contoh: 081234567890"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>

                <div class="pt-3">
                    <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-sm transition">
                        Simpan Perubahan Biodata
                    </button>
                </div>
            </form>
        </div>

        <!-- 2. Form Ubah Kata Sandi -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-7 space-y-5">
            <div class="flex items-center space-x-2 pb-3 border-b border-slate-100">
                <span class="text-lg">🔒</span>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Ganti Kata Sandi</h3>
                    <p class="text-[11px] text-slate-400">Pastikan menggunakan kata sandi yang aman dan mudah diingat.</p>
                </div>
            </div>

            <form action="{{ route('profile.password') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="block font-semibold text-slate-700 mb-1">
                        Kata Sandi Saat Ini <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="password" 
                        name="current_password" 
                        id="current_password" 
                        required 
                        placeholder="Masukkan kata sandi lama Anda..."
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none"
                    >
                </div>

                <div>
                    <label for="password" class="block font-semibold text-slate-700 mb-1">
                        Kata Sandi Baru <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        required 
                        placeholder="Minimal 8 karakter..."
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none"
                    >
                </div>

                <div>
                    <label for="password_confirmation" class="block font-semibold text-slate-700 mb-1">
                        Ulangi Kata Sandi Baru <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation" 
                        required 
                        placeholder="Konfirmasi kata sandi baru..."
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none"
                    >
                </div>

                <div class="pt-3">
                    <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl shadow-sm transition">
                        Perbarui Kata Sandi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
