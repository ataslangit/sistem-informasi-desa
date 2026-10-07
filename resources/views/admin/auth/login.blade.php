<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SiDesa (Sistem Informasi Desa)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ admin_asset('css/admin.css') }}">
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen px-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-200">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-700 to-indigo-800 p-8 text-center text-white">
            <div class="inline-block p-3 bg-white/10 rounded-2xl mb-3 backdrop-blur-sm">
                @if($logo = village_logo())
                    <img src="{{ $logo }}" alt="Logo" class="w-12 h-12 object-contain mx-auto">
                @else
                    <span class="text-4xl">🏛️</span>
                @endif
            </div>
            <h2 class="text-2xl font-bold tracking-tight">SiDesa</h2>
            <p class="text-blue-100 text-sm mt-1">Portal Layanan & Administrasi Desa Terpadu</p>
        </div>

        <!-- Form Body -->
        <div class="p-8">
            @if ($errors->any())
            <div class="mb-5 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="login" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                        Email atau Username
                    </label>
                    <input 
                        type="text" 
                        name="login" 
                        id="login" 
                        value="{{ old('login') }}" 
                        required 
                        autofocus
                        placeholder="contoh: admin@sidesa.id atau kades"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition"
                    >
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                        Kata Sandi
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        required 
                        placeholder="••••••••"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition"
                    >
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center space-x-2 text-slate-600">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-xs">Ingat saya</span>
                    </label>
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-xl shadow-md transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-sm"
                >
                    Masuk ke Sistem
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-100 text-center space-y-2">
                <p class="text-xs text-slate-500">
                    Warga desa dan belum memiliki akun?
                </p>
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center w-full px-4 py-2 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 transition space-x-1">
                    <span>📝</span>
                    <span>Aktivasi Akun Layanan Mandiri Warga</span>
                </a>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('home') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                    ← Kembali ke Halaman Web Portal Publik
                </a>
            </div>
        </div>
    </div>
</body>
</html>
