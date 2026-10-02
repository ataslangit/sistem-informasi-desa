<header class="bg-white border-b border-slate-100 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo & Brand -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <div class="w-12 h-12 rounded-xl bg-sky-600 text-white flex items-center justify-center text-2xl shadow-sm">
                    🏛️
                </div>
                <div>
                    <span class="block font-black text-xl text-slate-800 tracking-tight leading-tight">
                        {{ \App\Models\Setting::get('village_name', 'Desa Sukamaju') }}
                    </span>
                    <span class="block text-xs text-slate-500 font-medium">
                        {{ \App\Models\Setting::get('subdistrict_name', 'Kecamatan') }}, {{ \App\Models\Setting::get('district_name', 'Kabupaten') }}
                    </span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-sm font-semibold text-sky-600 hover:text-sky-700">Beranda</a>
                <a href="#profil" class="text-sm font-medium text-slate-600 hover:text-sky-600 transition">Profil Desa</a>
                <a href="#layanan" class="text-sm font-medium text-slate-600 hover:text-sky-600 transition">Layanan Surat</a>
                <a href="#informasi" class="text-sm font-medium text-slate-600 hover:text-sky-600 transition">Kabar Desa</a>
            </nav>

            <!-- Actions / Login Button -->
            <div class="flex items-center space-x-3">
                @auth
                    @if(auth()->user()->hasRole(['superadmin', 'kades', 'perangkat']))
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold bg-sky-600 text-white hover:bg-sky-700 transition shadow-sm">
                            Dashboard Admin →
                        </a>
                    @else
                        <span class="text-xs text-slate-600 font-medium">Halo, {{ auth()->user()->name }}</span>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold bg-slate-900 text-white hover:bg-slate-800 transition shadow-sm">
                        Masuk Petugas
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>
