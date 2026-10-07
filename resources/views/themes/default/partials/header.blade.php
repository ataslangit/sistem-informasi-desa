<header class="bg-white border-b border-slate-100 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo & Brand -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                @if($logo = village_logo())
                    <img src="{{ $logo }}" alt="Logo {{ \App\Models\Setting::get('village_name', 'Desa') }}" class="w-12 h-12 object-contain rounded-xl p-1 bg-white border border-slate-200/80 shadow-xs">
                @else
                    <div class="w-12 h-12 rounded-xl bg-sky-600 text-white flex items-center justify-center text-2xl shadow-sm">
                        🏛️
                    </div>
                @endif
                <div>
                    <span class="block font-black text-xl text-slate-800 tracking-tight leading-tight">
                        {{ \App\Models\Setting::get('village_name', 'Desa Sukamaju') }}
                    </span>
                    <span class="block text-xs text-slate-500 font-medium">
                        {{ \App\Models\Setting::get('subdistrict_name', 'Kecamatan') }}, {{ \App\Models\Setting::get('district_name', 'Kabupaten') }}
                    </span>
                </div>
            </a>

            <!-- Navigation Links (Dynamic from Menu Management) -->
            <nav class="hidden md:flex items-center space-x-7">
                @php
                    $headerMenus = public_header_menus();
                @endphp

                @forelse($headerMenus as $navMenu)
                    @if($navMenu->children->isNotEmpty())
                        <!-- Dropdown Menu Item -->
                        <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                            <button @click="open = !open" type="button" class="inline-flex items-center space-x-1 text-sm font-medium text-slate-600 hover:text-sky-600 transition focus:outline-none">
                                <span>{{ $navMenu->name }}</span>
                                <svg class="w-3.5 h-3.5 text-slate-400 transition transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div 
                                x-show="open" 
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute left-0 mt-3 w-56 rounded-2xl bg-white shadow-xl border border-slate-100 py-2 z-50 divide-y divide-slate-50"
                                style="display: none;"
                            >
                                @if($navMenu->resolved_url !== '#' && $navMenu->type !== 'custom')
                                    <div class="px-3 pb-1 mb-1">
                                        <a href="{{ $navMenu->resolved_url }}" target="{{ $navMenu->target }}" class="block px-3 py-1.5 rounded-xl text-xs font-bold text-sky-700 hover:bg-sky-50 transition">
                                            Ringkasan {{ $navMenu->name }} &rarr;
                                        </a>
                                    </div>
                                @endif
                                <div class="py-1">
                                    @foreach($navMenu->children as $childMenu)
                                        <a href="{{ $childMenu->resolved_url }}" target="{{ $childMenu->target }}" class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-sky-600 transition">
                                            {{ $childMenu->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Regular Menu Link -->
                        <a href="{{ $navMenu->resolved_url }}" target="{{ $navMenu->target }}" class="text-sm font-medium transition {{ $navMenu->isCurrent() ? 'text-sky-600 font-semibold' : 'text-slate-600 hover:text-sky-600' }}">
                            {{ $navMenu->name }}
                        </a>
                    @endif
                @empty
                    <!-- Fallback default menu jika belum ada di database -->
                    <a href="{{ route('home') }}" class="text-sm font-semibold {{ request()->routeIs('home') ? 'text-sky-600' : 'text-slate-600 hover:text-sky-600' }}">Beranda</a>
                    <a href="{{ route('pages.show', 'profil-desa') }}" class="text-sm font-medium {{ request()->is('halaman*') ? 'text-sky-600 font-semibold' : 'text-slate-600 hover:text-sky-600' }} transition">Profil Desa</a>
                    <a href="{{ route('articles.index') }}" class="text-sm font-medium {{ request()->is('berita*') || request()->is('kategori*') ? 'text-sky-600 font-semibold' : 'text-slate-600 hover:text-sky-600' }} transition">Kabar Desa</a>
                    <a href="{{ route('budgets.index') }}" class="text-sm font-medium {{ request()->routeIs('budgets.*') ? 'text-sky-600 font-semibold' : 'text-slate-600 hover:text-sky-600' }} transition">APBDes</a>
                    <a href="{{ route('map.index') }}" class="text-sm font-medium {{ request()->routeIs('map.*') ? 'text-sky-600 font-semibold' : 'text-slate-600 hover:text-sky-600' }} transition">Peta Desa</a>
                    <a href="{{ route('citizen.letters.create') }}" class="text-sm font-medium text-slate-600 hover:text-sky-600 transition">Layanan Surat</a>
                @endforelse
            </nav>

            <!-- Actions / Login Button -->
            <div class="flex items-center space-x-3">
                @auth
                    @if(auth()->user()->hasRole(['superadmin', 'kades', 'perangkat']))
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold bg-sky-600 text-white hover:bg-sky-700 transition shadow-sm">
                            Dashboard Admin →
                        </a>
                    @elseif(auth()->user()->hasRole('rt'))
                        <a href="{{ route('admin.letter-requests.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold bg-amber-500 text-slate-950 hover:bg-amber-400 transition shadow-sm">
                            Panel RT/RW →
                        </a>
                    @else
                        <a href="{{ route('citizen.letters.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold bg-sky-600 text-white hover:bg-sky-700 transition shadow-sm">
                            ✉️ Layanan Surat Mandiri →
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition text-xs font-semibold" title="Keluar / Logout">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold bg-slate-900 text-white hover:bg-slate-800 transition shadow-sm">
                        Masuk / Layanan Warga
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>
