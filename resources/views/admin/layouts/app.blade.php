<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - SiDesa Admin</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ admin_asset('css/admin.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-100 text-slate-800 antialiased flex h-screen overflow-hidden" x-data="{ sidebarOpen: true }">
    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'w-64' : 'w-20'" class="bg-slate-900 text-slate-300 flex flex-col transition-all duration-300 z-30">
        <!-- Logo Brand -->
        <div class="h-16 flex items-center justify-between px-4 border-b border-slate-800 bg-slate-950">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 overflow-hidden">
                <span class="text-2xl">🏛️</span>
                <span x-show="sidebarOpen" class="font-bold text-lg text-white tracking-wide">SiDesa</span>
            </a>
            <button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-white p-1 rounded focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>

        <!-- Menu Navigation -->
        <nav class="flex-1 overflow-y-auto py-4 px-2 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span x-show="sidebarOpen">Dashboard</span>
            </a>

            @if(auth()->user()->hasRole(['superadmin', 'kades', 'perangkat', 'rt']))
            <div x-show="sidebarOpen" class="px-3 pt-4 pb-1 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                Administrasi Kependudukan
            </div>

            <a href="{{ route('admin.families.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.families.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span x-show="sidebarOpen">Kartu Keluarga</span>
            </a>

            <a href="{{ route('admin.residents.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.residents.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span x-show="sidebarOpen">Buku Induk Penduduk</span>
            </a>

            @if(auth()->user()->hasRole(['superadmin', 'kades', 'perangkat']))
            <a href="{{ route('admin.mutations.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.mutations.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                <span x-show="sidebarOpen">Mutasi Penduduk</span>
            </a>

            <a href="{{ route('admin.reports.population') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.reports.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                <span x-show="sidebarOpen">Statistik Penduduk</span>
            </a>
            @endif
            @endif

            @if(auth()->user()->hasRole(['superadmin', 'kades', 'perangkat', 'rt']))
            <div x-show="sidebarOpen" class="px-3 pt-4 pb-1 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                Pelayanan Surat
            </div>

            <a href="{{ route('admin.letter-requests.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.letter-requests.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span x-show="sidebarOpen">Permohonan Surat</span>
            </a>

            @if(auth()->user()->hasRole(['superadmin', 'perangkat']))
            <a href="{{ route('admin.letter-templates.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.letter-templates.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span x-show="sidebarOpen">Template Surat</span>
            </a>
            @endif
            @endif

            @if(auth()->user()->hasRole(['superadmin', 'kades', 'perangkat']))
            <div x-show="sidebarOpen" class="px-3 pt-4 pb-1 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                CMS & Portal Publik
            </div>

            <a href="{{ route('admin.articles.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.articles.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                <span x-show="sidebarOpen">Kabar & Berita</span>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                <span x-show="sidebarOpen">Kategori & Tag</span>
            </a>

            <a href="{{ route('admin.pages.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.pages.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span x-show="sidebarOpen">Halaman Statis</span>
            </a>

            <a href="{{ route('admin.menus.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.menus.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <span x-show="sidebarOpen">Menu Navigasi</span>
            </a>

            <a href="{{ route('admin.galleries.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.galleries.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span x-show="sidebarOpen">Galeri Foto</span>
            </a>

            <a href="{{ route('admin.themes.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.themes.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4 4 4 0 014-4c.48 0 .942.083 1.373.238l5.88-5.88a2.5 2.5 0 013.536 3.536l-5.88 5.88A3.996 3.996 0 017 21z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 5l3 3"></path></svg>
                <span x-show="sidebarOpen">Tema Portal</span>
            </a>

            <div x-show="sidebarOpen" class="px-3 pt-4 pb-1 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                Keuangan & Pemetaan (GIS)
            </div>

            <a href="{{ route('admin.budgets.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.budgets.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span x-show="sidebarOpen">Transparansi APBDes</span>
            </a>

            <a href="{{ route('admin.boundaries.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.boundaries.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                <span x-show="sidebarOpen">Batas Wilayah</span>
            </a>

            <a href="{{ route('admin.facilities.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.facilities.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span x-show="sidebarOpen">Fasilitas & Sarana</span>
            </a>
            @endif

            @if(auth()->user()->hasRole('warga'))
            <div x-show="sidebarOpen" class="px-3 pt-4 pb-1 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                Layanan Mandiri Warga
            </div>

            <a href="{{ route('citizen.letters.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('citizen.letters.index') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                <span x-show="sidebarOpen">Surat Saya</span>
            </a>

            <a href="{{ route('citizen.letters.create') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('citizen.letters.create') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span x-show="sidebarOpen">Buat Permohonan</span>
            </a>
            @endif

            @if(auth()->user()->hasRole(['superadmin', 'kades']))
            <div x-show="sidebarOpen" class="px-3 pt-4 pb-1 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                Konfigurasi & Audit
            </div>

            @if(auth()->user()->hasRole('superadmin'))
            <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 text-slate-300' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span x-show="sidebarOpen">Pengguna & Role</span>
            </a>
            @endif

            <a href="{{ route('admin.audit-logs.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-slate-800 {{ request()->routeIs('admin.audit-logs.*') ? 'bg-blue-600 text-white' : 'text-slate-300' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span x-show="sidebarOpen">Audit Trail</span>
            </a>
            @endif

            <div class="pt-4 border-t border-slate-800">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-800">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    <span x-show="sidebarOpen">Lihat Portal Web</span>
                </a>
            </div>
        </nav>

        <!-- User Profile Bottom Bar -->
        <div class="p-3 border-t border-slate-800 bg-slate-950 flex items-center justify-between">
            <div class="flex items-center space-x-3 overflow-hidden">
                <div class="w-8 h-8 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center flex-shrink-0 text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div x-show="sidebarOpen" class="overflow-hidden">
                    <div class="text-xs font-medium text-white truncate">{{ auth()->user()->name }}</div>
                    <div class="text-[10px] text-blue-400 uppercase font-semibold">
                        {{ auth()->user()->roles->pluck('label')->first() ?? 'Staff' }}
                    </div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" title="Logout" class="text-slate-400 hover:text-red-400 p-1 rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Navbar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 z-20">
            <div>
                <h1 class="text-lg font-bold text-slate-800">@yield('title')</h1>
            </div>
            <div class="flex items-center space-x-4">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                    Sistem Aktif
                </span>
                <div class="text-sm text-slate-500">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </div>
            </div>
        </header>

        <!-- Body Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-6 bg-slate-50">
            @if(session('success'))
            <div class="mb-4 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded text-emerald-800 text-sm">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mb-4 bg-rose-50 border-l-4 border-rose-500 p-4 rounded text-rose-800 text-sm">
                {{ session('error') }}
            </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
