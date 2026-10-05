<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', \App\Models\Setting::get('app_title', 'SiDesa - Portal Resmi Desa'))</title>
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
    <!-- Theme Specific CSS via theme_asset() helper -->
    <link rel="stylesheet" href="{{ theme_asset('css/style.css') }}">
</head>
<body class="bg-gradient-to-br from-slate-50 via-emerald-50/30 to-teal-50/20 text-slate-800 flex flex-col min-h-screen antialiased selection:bg-emerald-500 selection:text-white">
    <!-- Header Khusus Tema Emerald -->
    @include('themes.emerald.partials.header')

    <!-- Konten Halaman Tema Emerald -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer Khusus Tema Emerald -->
    @include('themes.emerald.partials.footer')
</body>
</html>
