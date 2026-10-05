<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivasi Akun Warga - SiDesa (Sistem Informasi Desa)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ admin_asset('css/admin.css') }}">
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen px-4 py-8">
    <div class="max-w-xl w-full bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-200">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-700 to-indigo-800 p-8 text-center text-white">
            <div class="inline-block p-3 bg-white/10 rounded-2xl mb-3 backdrop-blur-sm">
                <span class="text-4xl">📝</span>
            </div>
            <h2 class="text-2xl font-bold tracking-tight">Aktivasi Layanan Mandiri Warga</h2>
            <p class="text-blue-100 text-xs mt-1 max-w-sm mx-auto">
                Daftarkan akun permohonan surat online dengan memverifikasi data kependudukan resmi Anda.
            </p>
        </div>

        <!-- Form Body -->
        <div class="p-6 sm:p-8">
            <!-- Informasi Panduan -->
            <div class="mb-6 p-4 bg-blue-50/80 rounded-2xl border border-blue-100 flex items-start space-x-3 text-xs text-blue-900">
                <span class="text-lg shrink-0">ℹ️</span>
                <div class="space-y-0.5">
                    <span class="font-bold block">Verifikasi Identitas Penduduk:</span>
                    <p class="text-[11px] text-blue-700">
                        Pastikan <b>NIK</b>, <b>Nomor KK</b>, dan <b>Tanggal Lahir</b> yang Anda masukkan sama persis dengan yang tertera pada e-KTP dan Kartu Keluarga Anda.
                    </p>
                </div>
            </div>

            @if ($errors->any())
            <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-2xl text-xs space-y-1">
                <div class="font-bold flex items-center space-x-1.5">
                    <span>⚠️</span>
                    <span>Terdapat data yang belum sesuai:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 text-[11px] pt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Bagian 1: Data Kependudukan -->
                <div class="space-y-3">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">
                        Langkah 1: Identitas Kependudukan
                    </span>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="nik" class="block text-xs font-semibold text-slate-700 mb-1">
                                NIK (16 Digit) <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="nik" 
                                id="nik" 
                                maxlength="16" 
                                value="{{ old('nik') }}" 
                                required 
                                placeholder="320xxxxxxxxxxxxx"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none"
                            >
                        </div>

                        <div>
                            <label for="family_card_number" class="block text-xs font-semibold text-slate-700 mb-1">
                                No. Kartu Keluarga (KK) <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="family_card_number" 
                                id="family_card_number" 
                                maxlength="16" 
                                value="{{ old('family_card_number') }}" 
                                required 
                                placeholder="320xxxxxxxxxxxxx"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none"
                            >
                        </div>
                    </div>

                    <div>
                        <label for="birth_date" class="block text-xs font-semibold text-slate-700 mb-1">
                            Tanggal Lahir (Sesuai KTP/KK) <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="date" 
                            name="birth_date" 
                            id="birth_date" 
                            value="{{ old('birth_date') }}" 
                            required 
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none bg-white"
                        >
                    </div>
                </div>

                <!-- Bagian 2: Kontak & Kata Sandi -->
                <div class="pt-4 border-t border-slate-100 space-y-3">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">
                        Langkah 2: Kontak & Kata Sandi Akun
                    </span>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">
                                Alamat Email Aktif <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                value="{{ old('email') }}" 
                                required 
                                placeholder="nama@email.com"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none"
                            >
                        </div>

                        <div>
                            <label for="phone" class="block text-xs font-semibold text-slate-700 mb-1">
                                Nomor WhatsApp / HP
                            </label>
                            <input 
                                type="text" 
                                name="phone" 
                                id="phone" 
                                value="{{ old('phone') }}" 
                                placeholder="081234567890"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none"
                            >
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">
                                Kata Sandi Baru <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                required 
                                placeholder="Minimal 8 karakter"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none"
                            >
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1">
                                Konfirmasi Kata Sandi <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                id="password_confirmation" 
                                required 
                                placeholder="Ulangi kata sandi"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none"
                            >
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button 
                        type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow-md transition text-xs flex items-center justify-center space-x-2"
                    >
                        <span>🚀</span>
                        <span>Verifikasi Data & Aktifkan Akun</span>
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-100 text-center space-y-2">
                <p class="text-xs text-slate-500">
                    Sudah memiliki akun layanan mandiri?
                </p>
                <a href="{{ route('login') }}" class="inline-flex items-center text-xs text-blue-600 hover:text-blue-800 font-semibold space-x-1">
                    <span>Sudah punya akun? Masuk di sini &rarr;</span>
                </a>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('home') }}" class="text-[11px] text-slate-400 hover:text-slate-600">
                    &larr; Kembali ke Portal Publik Desa
                </a>
            </div>
        </div>
    </div>
</body>
</html>
