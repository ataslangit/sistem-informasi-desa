<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', \App\Models\Setting::get('app_title', 'SiDesa - Portal Resmi Desa'))</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Theme Specific CSS via theme_asset() helper -->
    <link rel="stylesheet" href="{{ theme_asset('css/style.css') }}">
</head>
<body class="bg-white text-slate-800 flex flex-col min-h-screen">
    @include('themes.default.partials.header')

    <main class="flex-1">
        @yield('content')
    </main>

    @include('themes.default.partials.footer')
</body>
</html>
