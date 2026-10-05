@extends('admin.layouts.app')

@section('title', 'Edit Pengguna: ' . $user->name)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Edit Akun Pengguna</h2>
            <p class="text-xs text-slate-500 mt-1">Perbarui data profil, peran otoritas (role), atau atur ulang kata sandi pengguna.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-semibold bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition shadow-2xs">
            &larr; Kembali
        </a>
    </div>

    @if($user->id === auth()->id())
        <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200 flex items-center space-x-3 text-xs text-amber-900">
            <span class="text-lg">ℹ️</span>
            <div>
                <span class="font-bold block">Anda sedang mengedit akun Anda sendiri.</span>
                <span class="text-[11px] text-amber-700 block mt-0.5">Status aktif dan role administrator tidak dapat diubah demi keamanan sesi Anda.</span>
            </div>
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

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
                            value="{{ old('name', $user->name) }}" 
                            required 
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
                            value="{{ old('username', $user->username) }}" 
                            required 
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
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
                            value="{{ old('email', $user->email) }}" 
                            required 
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                        @error('email')
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
                            value="{{ old('phone', $user->metadata['phone'] ?? '') }}" 
                            placeholder="081234567890"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>

                    <div>
                        <label for="jabatan" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Jabatan / Keterangan
                        </label>
                        <input 
                            type="text" 
                            id="jabatan" 
                            name="jabatan" 
                            value="{{ old('jabatan', $user->metadata['jabatan'] ?? '') }}" 
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

                @php
                    $currentRoleName = $user->roles->first()?->name;
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($roles as $r)
                        <label class="relative flex items-start p-3.5 rounded-2xl border border-slate-200 hover:border-blue-400 bg-white hover:bg-slate-50/50 cursor-pointer transition {{ old('role', $currentRoleName) === $r->name ? 'border-blue-500 ring-1 ring-blue-500 bg-blue-50/20' : '' }}">
                            <input 
                                type="radio" 
                                name="role" 
                                value="{{ $r->name }}" 
                                {{ old('role', $currentRoleName) === $r->name ? 'checked' : '' }}
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

            <!-- Ganti Password (Opsional) -->
            <div>
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2 pb-2 border-b border-slate-100 flex items-center space-x-2">
                    <span>🔑</span>
                    <span>Ubah Kata Sandi (Opsional)</span>
                </h3>
                <p class="text-[11px] text-slate-400 mb-4">Kosongkan jika tidak ingin mengubah kata sandi pengguna ini.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Kata Sandi Baru
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Minimal 8 karakter..."
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                        @error('password')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Ulangi Kata Sandi Baru
                        </label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            placeholder="Ulangi kata sandi baru di atas..."
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>
                </div>
            </div>

            <!-- Status Aktif -->
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                <label class="flex items-center space-x-3 {{ $user->id === auth()->id() ? 'opacity-60 cursor-not-allowed' : 'cursor-pointer' }}">
                    <input 
                        type="checkbox" 
                        name="is_active" 
                        value="1" 
                        {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                        {{ $user->id === auth()->id() ? 'disabled' : '' }}
                        class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-4 h-4"
                    >
                    <div>
                        <span class="text-xs font-bold text-slate-800 block">Akun Aktif</span>
                        <span class="text-[11px] text-slate-500 block">Pengguna dapat masuk ke sistem dan mengakses fitur sesuai peran.</span>
                    </div>
                </label>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-2">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-800 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
                    Perbarui Akun Pengguna
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
