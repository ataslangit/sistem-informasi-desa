@extends(theme_layout())

@section('title', 'Lacak Status Tiket Layanan Informasi - PPID Desa ' . \App\Models\Setting::get('village_name', 'Desa Sukamaju'))

@section('content')
<!-- Banner Hero Hijau Zamrud (Jumbotron Tracking Tiket PPID Tema Emerald) -->
<section class="relative px-4 sm:px-6 lg:px-8 pt-6 pb-4">
    <div class="max-w-7xl mx-auto">
        <div class="relative rounded-3xl overflow-hidden shadow-2xl shadow-emerald-950/20 bg-gradient-to-br from-emerald-950 via-emerald-900 to-teal-950 py-12 sm:py-16 px-6 sm:px-12 text-white">
            <!-- Background Landscape Overlay -->
            <div class="absolute inset-0 bg-cover bg-center opacity-15 mix-blend-overlay pointer-events-none" style="background-image: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=1600&q=80');"></div>
            <!-- Radial Glow Ornaments -->
            <div class="absolute -right-10 -bottom-10 w-80 h-80 bg-emerald-400/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-10 -top-10 w-72 h-72 bg-teal-300/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-4xl space-y-4">
                <!-- Breadcrumbs Cerah Kontras Tinggi -->
                <nav class="flex flex-wrap items-center gap-2 text-xs text-emerald-300 font-medium">
                    <a href="{{ route('home') }}" class="hover:text-white transition flex items-center gap-1">
                        <span>🏡</span>
                        <span>Beranda</span>
                    </a>
                    <span class="text-emerald-500">/</span>
                    <a href="{{ route('public.ppid.index') }}" class="hover:text-white transition">PPID Desa</a>
                    <span class="text-emerald-500">/</span>
                    <span class="text-white font-semibold">Lacak Status Tiket</span>
                </nav>

                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-200 text-xs font-bold backdrop-blur-md">
                    <span>🔍</span>
                    <span>Pelacakan Tiket Layanan Informasi</span>
                </div>

                <!-- Judul Halaman Putih Kontras Tinggi -->
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight drop-shadow-sm">
                    Lacak Status Tiket KIP
                </h1>

                <p class="text-sm sm:text-base lg:text-lg text-emerald-100/90 leading-relaxed font-normal max-w-3xl">
                    Pantau status progres tindak lanjut permohonan informasi publik atau pengajuan keberatan Anda secara real-time.
                </p>
            </div>
        </div>
    </div>
</section>

<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white rounded-3xl border border-emerald-100 shadow-sm p-8 sm:p-10 space-y-6">
        @if (session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-xs flex items-center space-x-2">
                <span>⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('public.ppid.tracking.check') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="ticket_number" class="block text-xs font-semibold text-slate-700 mb-1">
                    Nomor Tiket Layanan (INF-... atau KBR-...)
                </label>
                <input 
                    type="text" 
                    name="ticket_number" 
                    id="ticket_number" 
                    required 
                    placeholder="Contoh: INF-20261005-0001 atau KBR-20261005-0001"
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 font-mono text-sm uppercase focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                >
                <p class="text-[11px] text-slate-400 mt-1">
                    Nomor tiket diberikan saat Anda selesai mengirimkan formulir permohonan informasi daring.
                </p>
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-xl shadow-md shadow-emerald-600/20 transition text-xs flex items-center justify-center space-x-2">
                <span>🔎</span>
                <span>Periksa Status Tiket</span>
            </button>
        </form>

        <div class="pt-6 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-500 mb-2">Belum pernah mengajukan permohonan informasi?</p>
            <a href="{{ route('public.ppid.requests.create') }}" class="inline-flex items-center text-xs font-bold text-emerald-700 hover:text-emerald-900 space-x-1">
                <span>Ajukan Permohonan Informasi Daring Sekarang &rarr;</span>
            </a>
        </div>
    </div>
</div>
@endsection
