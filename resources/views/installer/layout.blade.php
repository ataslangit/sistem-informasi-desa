<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Instalasi Sistem') - SiDesa (Sistem Informasi Desa)</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between py-10 px-4 sm:px-6">

    <div class="max-w-2xl w-full mx-auto space-y-6">
        <!-- Logo & Header -->
        <div class="text-center space-y-2">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-600 text-white text-3xl shadow-lg shadow-blue-500/20 mb-2">
                🏛️
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">SiDesa Installer</h1>
            <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto">
                Panduan Pemasangan Mandiri Sistem Informasi Administrasi & Layanan Kependudukan Desa
            </p>
        </div>

        <!-- Stepper Wizard -->
        <div class="bg-white p-3 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between text-xs font-semibold">
            <div class="flex items-center space-x-2 px-3 py-1.5 rounded-xl {{ request()->routeIs('installer.index') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-400' }}">
                <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] {{ request()->routeIs('installer.index') ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-600' }}">1</span>
                <span class="hidden sm:inline">Persyaratan</span>
            </div>
            <span class="text-slate-300">&rarr;</span>
            <div class="flex items-center space-x-2 px-3 py-1.5 rounded-xl {{ request()->routeIs('installer.database') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-400' }}">
                <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] {{ request()->routeIs('installer.database') ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-600' }}">2</span>
                <span class="hidden sm:inline">Basis Data</span>
            </div>
            <span class="text-slate-300">&rarr;</span>
            <div class="flex items-center space-x-2 px-3 py-1.5 rounded-xl {{ request()->routeIs('installer.setup') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-400' }}">
                <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] {{ request()->routeIs('installer.setup') ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-600' }}">3</span>
                <span class="hidden sm:inline">Identitas & Admin</span>
            </div>
            <span class="text-slate-300">&rarr;</span>
            <div class="flex items-center space-x-2 px-3 py-1.5 rounded-xl {{ request()->routeIs('installer.completed') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-400' }}">
                <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] {{ request()->routeIs('installer.completed') ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-600' }}">4</span>
                <span class="hidden sm:inline">Selesai</span>
            </div>
        </div>

        <!-- Alert Notifications -->
        @if(session('error'))
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-xs text-rose-800 flex items-start space-x-3">
                <span class="text-base shrink-0">⚠️</span>
                <div>
                    <span class="font-bold block">Terjadi Kendala:</span>
                    <span class="block mt-0.5 leading-relaxed">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 flex items-start space-x-3">
                <span class="text-base shrink-0">✅</span>
                <div>
                    <span class="font-bold block">Berhasil:</span>
                    <span class="block mt-0.5 leading-relaxed">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('warning'))
            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-xs text-amber-800 flex items-start space-x-3">
                <span class="text-base shrink-0">ℹ️</span>
                <div>
                    <span class="font-bold block">Pemberitahuan:</span>
                    <span class="block mt-0.5 leading-relaxed">{{ session('warning') }}</span>
                </div>
            </div>
        @endif

        <!-- Main Card Content -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center text-xs text-slate-400 mt-8 space-y-1">
        <p>&copy; {{ date('Y') }} <b>SiDesa</b> &bull; Sistem Informasi Desa & Kependudukan Mandiri</p>
        <p class="text-[11px] text-slate-400">Lisensi Terbuka (GPL v3) &bull; Kepatuhan Regulasi UU Desa & Adminduk</p>
    </div>

</body>
</html>
