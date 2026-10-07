@extends('installer.layout')

@section('title', 'Langkah 2: Konfigurasi Basis Data')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="border-b border-slate-100 pb-4">
        <h2 class="text-lg font-bold text-slate-800">Langkah 2: Pengaturan Basis Data (Database)</h2>
        <p class="text-xs text-slate-500 mt-1">
            Masukkan kredensial koneksi ke server MySQL atau MariaDB Anda. Sistem akan menguji koneksi sebelum melanjutkan.
        </p>
    </div>

    <form action="{{ route('installer.database.store') }}" method="POST" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="sm:col-span-2">
                <label for="host" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                    Host Basis Data <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="host" 
                    name="host" 
                    value="{{ old('host', $dbConfig['host'] ?? '127.0.0.1') }}" 
                    required 
                    placeholder="127.0.0.1 / localhost / host.docker.internal"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
                <span class="text-[10px] text-slate-400 mt-0.5 block">Alamat IP atau hostname server MariaDB / MySQL.</span>
                @error('host')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="port" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                    Port <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="number" 
                    id="port" 
                    name="port" 
                    value="{{ old('port', $dbConfig['port'] ?? '3306') }}" 
                    required 
                    placeholder="3306"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
                <span class="text-[10px] text-slate-400 mt-0.5 block">Port standar: 3306</span>
                @error('port')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="database" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                Nama Basis Data (Database Name) <span class="text-rose-500">*</span>
            </label>
            <input 
                type="text" 
                id="database" 
                name="database" 
                value="{{ old('database', $dbConfig['database'] ?? 'sidesa') }}" 
                required 
                placeholder="sidesa"
                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500 focus:outline-none"
            >
            <span class="text-[10px] text-slate-400 mt-0.5 block">Pastikan database sudah dibuat di server MySQL/MariaDB Anda.</span>
            @error('database')
                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="username" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                    Pengguna Basis Data (Username) <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    value="{{ old('username', $dbConfig['username'] ?? 'root') }}" 
                    required 
                    placeholder="root"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
                @error('username')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                    Kata Sandi Basis Data (Password)
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    value="{{ old('password', $dbConfig['password'] ?? '') }}" 
                    placeholder="Kosongkan jika tidak ada password"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
                <span class="text-[10px] text-slate-400 mt-0.5 block">Kata sandi user MySQL jika disetel.</span>
                @error('password')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('installer.index') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition">
                &larr; Kembali
            </a>

            <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm flex items-center space-x-2">
                <span>Uji Koneksi & Lanjutkan</span>
                <span>&rarr;</span>
            </button>
        </div>
    </form>
</div>
@endsection
