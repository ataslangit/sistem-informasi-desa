<footer class="bg-slate-900 text-slate-300 pt-16 pb-12 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 pb-12 border-b border-slate-800">
            <!-- Col 1: Profil -->
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <span class="text-3xl">🏛️</span>
                    <h4 class="text-lg font-bold text-white">{{ \App\Models\Setting::get('village_name', 'Desa Sukamaju') }}</h4>
                </div>
                <p class="text-sm text-slate-400 leading-relaxed">
                    {{ \App\Models\Setting::get('app_tagline', 'Mewujudkan Desa Maju, Mandiri, dan Transparan Berbasis Digital') }}
                </p>
            </div>

            <!-- Col 2: Kontak -->
            <div class="space-y-4">
                <h4 class="text-sm font-bold text-white uppercase tracking-wider">Kontak & Alamat</h4>
                <ul class="text-sm text-slate-400 space-y-2">
                    <li>📍 {{ \App\Models\Setting::get('village_address', 'Jl. Raya Desa No. 01') }}</li>
                    <li>📞 {{ \App\Models\Setting::get('village_phone', '021-88889999') }}</li>
                    <li>✉️ {{ \App\Models\Setting::get('village_email', 'kantor@desa.id') }}</li>
                </ul>
            </div>

            <!-- Col 3: SiDesa Open Source -->
            <div class="space-y-4">
                <h4 class="text-sm font-bold text-white uppercase tracking-wider">Tentang SiDesa</h4>
                <p class="text-sm text-slate-400 leading-relaxed">
                    Sistem Informasi Desa berbasis *open-source* dengan lisensi GNU General Public License v3.0 (GPL-3.0).
                </p>
                <div class="pt-1">
                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-slate-800 text-sky-400 border border-slate-700">
                        Tema Aktif: {{ active_theme() }}
                    </span>
                </div>
            </div>
        </div>

        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} {{ \App\Models\Setting::get('village_name', 'Pemerintah Desa') }}. Hak Cipta Dilindungi.</p>
            <p class="mt-2 sm:mt-0">Didukung oleh SiDesa</p>
        </div>
    </div>
</footer>
