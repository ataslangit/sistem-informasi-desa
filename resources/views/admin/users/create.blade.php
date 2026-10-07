@extends('admin.layouts.app')

@section('title', 'Tambah Pengguna Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Tambah Akun Pengguna Baru</h2>
            <p class="text-xs text-slate-500 mt-1">Daftarkan akun aparatur desa, kepala desa, ketua RT, atau administrator baru.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-semibold bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition shadow-2xs">
            &larr; Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Informasi Profil Pengguna -->
            <div>
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center space-x-2">
                    <span>👤</span>
                    <span>Informasi Akun & Profil</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            placeholder="Contoh: Ahmad Fauzi, S.Kom."
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                        @error('name')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="username" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Username Login <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            value="{{ old('username') }}" 
                            required 
                            placeholder="Contoh: ahmad_fauzi"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                        <span class="text-[10px] text-slate-400 mt-0.5 block">Huruf kecil, angka, atau underscore tanpa spasi.</span>
                        @error('username')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Alamat Email <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            placeholder="ahmad@desa.id"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                        @error('email')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nik" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            NIK (16 Digit)
                        </label>
                        <input 
                            type="text" 
                            id="nik" 
                            name="nik" 
                            maxlength="16"
                            value="{{ old('nik') }}" 
                            placeholder="320101xxxxxxxxxx"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                        <span class="text-[10px] text-slate-400 mt-0.5 block">16 digit angka identitas resmi kependudukan.</span>
                        @error('nik')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Nomor WhatsApp / HP
                        </label>
                        <input 
                            type="text" 
                            id="phone" 
                            name="phone" 
                            value="{{ old('phone') }}" 
                            placeholder="081234567890"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>

                    <div class="sm:col-span-2">
                        <label for="jabatan" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Jabatan / Keterangan
                        </label>
                        <input 
                            type="text" 
                            id="jabatan" 
                            name="jabatan" 
                            value="{{ old('jabatan') }}" 
                            placeholder="Contoh: Kasi Pelayanan / Operator IT"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>
                </div>
            </div>

            <!-- Penetapan Role / Hak Akses -->
            <div>
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center space-x-2">
                    <span>🛡️</span>
                    <span>Role & Hak Akses Pengguna <span class="text-rose-500">*</span></span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($roles as $r)
                        <label class="relative flex items-start p-3.5 rounded-2xl border border-slate-200 hover:border-blue-400 bg-white hover:bg-slate-50/50 cursor-pointer transition">
                            <input 
                                type="radio" 
                                name="role" 
                                value="{{ $r->name }}" 
                                x-model="selectedRole"
                                {{ old('role', 'perangkat') === $r->name ? 'checked' : '' }}
                                class="mt-0.5 text-blue-600 focus:ring-blue-500"
                            >
                            <div class="ml-3">
                                <span class="block text-xs font-bold text-slate-800">{{ $r->label }}</span>
                                <span class="block text-[11px] text-slate-500 mt-0.5">{{ $r->description }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('role')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bagian Khusus: Tautkan Warga (Wajib Jika Role Warga) -->
            <div x-show="selectedRole === 'warga'" class="p-5 bg-blue-50/70 rounded-3xl border border-blue-200 space-y-3">
                <div class="flex items-center space-x-2 text-xs font-bold text-blue-900">
                    <span class="text-base">🪪</span>
                    <span>Tautkan Data Penduduk Desa (Buku Induk Kependudukan)</span>
                </div>
                <p class="text-[11px] text-blue-700 leading-relaxed">
                    Sesuai ketentuan administrasi, akun peran <b>Warga</b> wajib ditautkan dengan data penduduk desa yang sah dan aktif agar dapat mengajukan permohonan surat layanan mandiri.
                </p>
                <div>
                    <label for="resident_id" class="block text-xs font-bold text-blue-900 uppercase mb-1">
                        Pilih Penduduk Terdaftar <span class="text-rose-500">*</span>
                    </label>
                    <select 
                        name="resident_id" 
                        id="resident_id" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-blue-300 text-xs bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                        <option value="">-- Pilih Penduduk (Nama &bull; NIK) --</option>
                        @foreach($residents as $res)
                            <option value="{{ $res->id }}" {{ old('resident_id') == $res->id ? 'selected' : '' }}>
                                {{ $res->name }} &bull; NIK: {{ $res->masked_nik }} (RT {{ $res->family?->rt ?? '-' }} / RW {{ $res->family?->rw ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                    @error('resident_id')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Bagian Khusus: Wilayah RT (Khusus Role RT) -->
            <div x-show="selectedRole === 'rt'" class="p-5 bg-emerald-50/70 rounded-3xl border border-emerald-200 space-y-3">
                <div class="flex items-center space-x-2 text-xs font-bold text-emerald-900">
                    <span class="text-base">📍</span>
                    <span>Penetapan Wilayah Tugas Ketua RT / RW</span>
                </div>
                <p class="text-[11px] text-emerald-700 leading-relaxed">
                    Sesuai Permendagri 18/2018 (LKD) & UU PDP, akun Ketua RT hanya berwenang memverifikasi surat dan melihat data warga di wilayah RT yang ditugaskan.
                </p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="rt" class="block text-xs font-bold text-emerald-900 uppercase mb-1">
                            Nomor RT <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="rt" 
                            id="rt" 
                            value="{{ old('rt') }}" 
                            placeholder="Contoh: 001"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-emerald-300 text-xs font-mono bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                        >
                        @error('rt')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="rw" class="block text-xs font-bold text-emerald-900 uppercase mb-1">
                            Nomor RW
                        </label>
                        <input 
                            type="text" 
                            name="rw" 
                            id="rw" 
                            value="{{ old('rw') }}" 
                            placeholder="Contoh: 002"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-emerald-300 text-xs font-mono bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                        >
                    </div>
                </div>
            </div>

            <!-- Kata Sandi / Password -->
            <div>
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center space-x-2">
                    <span>🔑</span>
                    <span>Kata Sandi (Password)</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Kata Sandi <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required 
                            placeholder="Minimal 8 karakter..."
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                        @error('password')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Ulangi Kata Sandi <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            required 
                            placeholder="Ulangi kata sandi di atas..."
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>
                </div>
            </div>

            <!-- Status Aktif -->
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input 
                        type="checkbox" 
                        name="is_active" 
                        value="1" 
                        {{ old('is_active', '1') ? 'checked' : '' }}
                        class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-4 h-4"
                    >
                    <div>
                        <span class="text-xs font-bold text-slate-800 block">Akun Langsung Aktif</span>
                        <span class="text-[11px] text-slate-500 block">Pengguna dapat langsung masuk ke sistem setelah akun dibuat.</span>
                    </div>
                </label>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-2">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-800 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
                    Simpan Pengguna Baru
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
