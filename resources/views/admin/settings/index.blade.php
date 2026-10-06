@extends('admin.layouts.app')

@section('title', 'Pengaturan Situs & Profil Desa')

@section('content')
<div class="space-y-6" x-data="{ activeTab: 'general' }">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Pengaturan Situs &amp; Profil Desa</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola identitas resmi pemerintahan desa, kontak kantor, tampilan metadata portal publik, dan integrasi media sosial.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold bg-white text-slate-700 border border-slate-200 hover:bg-slate-50 shadow-sm transition">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                <span>Lihat Portal Publik &rarr;</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center space-x-3 text-xs text-emerald-800 animate-fade-in">
            <span class="text-lg">✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl text-xs text-rose-800 space-y-1">
            <div class="font-bold flex items-center gap-1.5">
                <span>⚠️</span>
                <span>Terdapat kesalahan pada isian formulir:</span>
            </div>
            <ul class="list-disc pl-6 space-y-0.5 text-[11px]">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Tab Navigasi -->
    <div class="flex border-b border-slate-200 overflow-x-auto space-x-2">
        <button type="button" @click="activeTab = 'general'"
                :class="activeTab === 'general' ? 'border-blue-600 text-blue-600 font-bold bg-blue-50/50' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 font-medium'"
                class="px-4 py-2.5 text-xs border-b-2 rounded-t-xl transition whitespace-nowrap flex items-center gap-2">
            <span>🏛️</span>
            <span>Identitas &amp; Wilayah</span>
        </button>
        <button type="button" @click="activeTab = 'contact'"
                :class="activeTab === 'contact' ? 'border-blue-600 text-blue-600 font-bold bg-blue-50/50' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 font-medium'"
                class="px-4 py-2.5 text-xs border-b-2 rounded-t-xl transition whitespace-nowrap flex items-center gap-2">
            <span>📍</span>
            <span>Kontak &amp; Kantor</span>
        </button>
        <button type="button" @click="activeTab = 'portal'"
                :class="activeTab === 'portal' ? 'border-blue-600 text-blue-600 font-bold bg-blue-50/50' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 font-medium'"
                class="px-4 py-2.5 text-xs border-b-2 rounded-t-xl transition whitespace-nowrap flex items-center gap-2">
            <span>🌐</span>
            <span>Portal Publik &amp; SEO</span>
        </button>
        <button type="button" @click="activeTab = 'social'"
                :class="activeTab === 'social' ? 'border-blue-600 text-blue-600 font-bold bg-blue-50/50' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 font-medium'"
                class="px-4 py-2.5 text-xs border-b-2 rounded-t-xl transition whitespace-nowrap flex items-center gap-2">
            <span>📱</span>
            <span>Media Sosial &amp; Logo</span>
        </button>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- TAB 1: IDENTITAS & WILAYAH DESA -->
        <div x-show="activeTab === 'general'" class="space-y-6"
             x-data="{
                manualMode: false,
                loadingProvinces: false,
                loadingRegencies: false,
                loadingDistricts: false,
                loadingVillages: false,
                provinces: [],
                regencies: [],
                districts: [],
                villages: [],
                selectedProvinceCode: '',
                selectedRegencyCode: '',
                selectedDistrictCode: '',
                selectedVillageCode: '',
                provinceName: '{{ old('province_name', $settings['province_name']) }}',
                districtName: '{{ old('district_name', $settings['district_name']) }}',
                subdistrictName: '{{ old('subdistrict_name', $settings['subdistrict_name']) }}',
                villageName: '{{ old('village_name', $settings['village_name']) }}',
                villageCode: '{{ old('village_code', $settings['village_code']) }}',

                normalize(str) {
                    return (str || '').toLowerCase()
                        .replace(/^desa\s+/, '')
                        .replace(/^kelurahan\s+/, '')
                        .replace(/^kecamatan\s+/, '')
                        .replace(/^kabupaten\s+/, '')
                        .replace(/^kota\s+/, '')
                        .trim();
                },

                async init() {
                    await this.loadProvinces();
                    if (this.provinceName) {
                        const prov = this.provinces.find(p => this.normalize(p.name) === this.normalize(this.provinceName));
                        if (prov) {
                            this.selectedProvinceCode = prov.code;
                            await this.loadRegencies(prov.code);
                            if (this.districtName) {
                                const reg = this.regencies.find(r => this.normalize(r.name) === this.normalize(this.districtName));
                                if (reg) {
                                    this.selectedRegencyCode = reg.code;
                                    await this.loadDistricts(reg.code);
                                    if (this.subdistrictName) {
                                        const dist = this.districts.find(d => this.normalize(d.name) === this.normalize(this.subdistrictName));
                                        if (dist) {
                                            this.selectedDistrictCode = dist.code;
                                            await this.loadVillages(dist.code);
                                            if (this.villageName) {
                                                const vil = this.villages.find(v => this.normalize(v.name) === this.normalize(this.villageName));
                                                if (vil) {
                                                    this.selectedVillageCode = vil.code;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                },

                async loadProvinces() {
                    this.loadingProvinces = true;
                    try {
                        const res = await fetch('{{ route('admin.api.wilayah.provinces') }}');
                        const json = await res.json();
                        this.provinces = json.data || [];
                    } catch (e) {
                        console.error('Gagal memuat provinsi:', e);
                    } finally {
                        this.loadingProvinces = false;
                    }
                },

                async onProvinceSelect() {
                    const prov = this.provinces.find(p => p.code === this.selectedProvinceCode);
                    this.provinceName = prov ? prov.name : '';
                    this.selectedRegencyCode = '';
                    this.districtName = '';
                    this.selectedDistrictCode = '';
                    this.subdistrictName = '';
                    this.selectedVillageCode = '';
                    this.villageName = '';
                    this.regencies = [];
                    this.districts = [];
                    this.villages = [];
                    if (this.selectedProvinceCode) {
                        await this.loadRegencies(this.selectedProvinceCode);
                    }
                },

                async loadRegencies(provCode) {
                    this.loadingRegencies = true;
                    try {
                        const res = await fetch(`{{ url('/admin/api/wilayah/regencies') }}/${provCode}`);
                        const json = await res.json();
                        this.regencies = json.data || [];
                    } catch (e) {
                        console.error('Gagal memuat kabupaten:', e);
                    } finally {
                        this.loadingRegencies = false;
                    }
                },

                async onRegencySelect() {
                    const reg = this.regencies.find(r => r.code === this.selectedRegencyCode);
                    this.districtName = reg ? reg.name : '';
                    this.selectedDistrictCode = '';
                    this.subdistrictName = '';
                    this.selectedVillageCode = '';
                    this.villageName = '';
                    this.districts = [];
                    this.villages = [];
                    if (this.selectedRegencyCode) {
                        await this.loadDistricts(this.selectedRegencyCode);
                    }
                },

                async loadDistricts(regCode) {
                    this.loadingDistricts = true;
                    try {
                        const res = await fetch(`{{ url('/admin/api/wilayah/districts') }}/${regCode}`);
                        const json = await res.json();
                        this.districts = json.data || [];
                    } catch (e) {
                        console.error('Gagal memuat kecamatan:', e);
                    } finally {
                        this.loadingDistricts = false;
                    }
                },

                async onDistrictSelect() {
                    const dist = this.districts.find(d => d.code === this.selectedDistrictCode);
                    this.subdistrictName = dist ? (dist.name.toLowerCase().startsWith('kecamatan') ? dist.name : ('Kecamatan ' + dist.name)) : '';
                    this.selectedVillageCode = '';
                    this.villageName = '';
                    this.villages = [];
                    if (this.selectedDistrictCode) {
                        await this.loadVillages(this.selectedDistrictCode);
                    }
                },

                async loadVillages(distCode) {
                    this.loadingVillages = true;
                    try {
                        const res = await fetch(`{{ url('/admin/api/wilayah/villages') }}/${distCode}`);
                        const json = await res.json();
                        this.villages = json.data || [];
                    } catch (e) {
                        console.error('Gagal memuat desa:', e);
                    } finally {
                        this.loadingVillages = false;
                    }
                },

                onVillageSelect() {
                    const vil = this.villages.find(v => v.code === this.selectedVillageCode);
                    if (vil) {
                        this.villageName = (vil.name.toLowerCase().startsWith('desa') || vil.name.toLowerCase().startsWith('kelurahan'))
                            ? vil.name
                            : ('Desa ' + vil.name);
                        this.villageCode = vil.code.replace(/\./g, '');
                    }
                }
             }">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-5">
                <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">Pemerintahan &amp; Batas Administrasi Wilayah</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Pilih langsung wilayah desa Anda melalui database resmi Kemendagri (wilayah.id).</p>
                    </div>
                    <button type="button" @click="manualMode = !manualMode"
                            class="px-3 py-1.5 rounded-xl text-xs font-semibold border transition shadow-sm flex items-center gap-1.5 self-start sm:self-auto"
                            :class="manualMode ? 'bg-blue-50 border-blue-200 text-blue-700' : 'bg-slate-50 border-slate-200 text-slate-600 hover:bg-slate-100'">
                        <span x-text="manualMode ? '🔄 Beralih ke Dropdown Wilayah.id' : '✏️ Mode Input Teks Manual'"></span>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- 1. Provinsi -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Provinsi <span class="text-rose-500">*</span>
                            <span x-show="loadingProvinces" class="text-blue-600 font-normal italic text-[11px]">(Memuat...)</span>
                        </label>
                        <template x-if="!manualMode">
                            <select x-model="selectedProvinceCode" @change="onProvinceSelect()" :required="!manualMode"
                                    class="w-full px-3 py-2 border rounded-xl text-xs bg-white text-slate-800 focus:ring-1 focus:ring-blue-500 border-slate-300">
                                <option value="">-- Pilih Provinsi --</option>
                                <template x-for="p in provinces" :key="p.code">
                                    <option :value="p.code" x-text="p.name" :selected="p.code === selectedProvinceCode"></option>
                                </template>
                            </select>
                        </template>
                        <input type="text" name="province_name" x-model="provinceName" :required="manualMode"
                               :class="!manualMode ? 'hidden' : 'block'"
                               placeholder="Contoh: Jawa Barat"
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 @error('province_name') border-rose-500 @enderror">
                        @error('province_name') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- 2. Kabupaten / Kota -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Kabupaten / Kota <span class="text-rose-500">*</span>
                            <span x-show="loadingRegencies" class="text-blue-600 font-normal italic text-[11px]">(Memuat...)</span>
                        </label>
                        <template x-if="!manualMode">
                            <select x-model="selectedRegencyCode" @change="onRegencySelect()" :disabled="!selectedProvinceCode || loadingRegencies" :required="!manualMode"
                                    class="w-full px-3 py-2 border rounded-xl text-xs bg-white text-slate-800 disabled:bg-slate-100 disabled:text-slate-400 focus:ring-1 focus:ring-blue-500 border-slate-300">
                                <option value="">-- Pilih Kabupaten/Kota --</option>
                                <template x-for="r in regencies" :key="r.code">
                                    <option :value="r.code" x-text="r.name" :selected="r.code === selectedRegencyCode"></option>
                                </template>
                            </select>
                        </template>
                        <input type="text" name="district_name" x-model="districtName" :required="manualMode"
                               :class="!manualMode ? 'hidden' : 'block'"
                               placeholder="Contoh: Kabupaten Bogor"
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 @error('district_name') border-rose-500 @enderror">
                        @error('district_name') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- 3. Kecamatan -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Kecamatan <span class="text-rose-500">*</span>
                            <span x-show="loadingDistricts" class="text-blue-600 font-normal italic text-[11px]">(Memuat...)</span>
                        </label>
                        <template x-if="!manualMode">
                            <select x-model="selectedDistrictCode" @change="onDistrictSelect()" :disabled="!selectedRegencyCode || loadingDistricts" :required="!manualMode"
                                    class="w-full px-3 py-2 border rounded-xl text-xs bg-white text-slate-800 disabled:bg-slate-100 disabled:text-slate-400 focus:ring-1 focus:ring-blue-500 border-slate-300">
                                <option value="">-- Pilih Kecamatan --</option>
                                <template x-for="d in districts" :key="d.code">
                                    <option :value="d.code" x-text="d.name" :selected="d.code === selectedDistrictCode"></option>
                                </template>
                            </select>
                        </template>
                        <input type="text" name="subdistrict_name" x-model="subdistrictName" :required="manualMode"
                               :class="!manualMode ? 'hidden' : 'block'"
                               placeholder="Contoh: Kecamatan Cibinong"
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 @error('subdistrict_name') border-rose-500 @enderror">
                        @error('subdistrict_name') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- 4. Nama Resmi Desa -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Nama Resmi Desa <span class="text-rose-500">*</span>
                            <span x-show="loadingVillages" class="text-blue-600 font-normal italic text-[11px]">(Memuat...)</span>
                        </label>
                        <template x-if="!manualMode">
                            <select x-model="selectedVillageCode" @change="onVillageSelect()" :disabled="!selectedDistrictCode || loadingVillages" :required="!manualMode"
                                    class="w-full px-3 py-2 border rounded-xl text-xs bg-white text-slate-800 disabled:bg-slate-100 disabled:text-slate-400 focus:ring-1 focus:ring-blue-500 border-slate-300">
                                <option value="">-- Pilih Desa/Kelurahan --</option>
                                <template x-for="v in villages" :key="v.code">
                                    <option :value="v.code" x-text="v.name" :selected="v.code === selectedVillageCode"></option>
                                </template>
                            </select>
                        </template>
                        <input type="text" name="village_name" x-model="villageName" :required="manualMode"
                               :class="!manualMode ? 'hidden' : 'block'"
                               placeholder="Contoh: Desa Sukamaju"
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 @error('village_name') border-rose-500 @enderror">
                        @error('village_name') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- 5. Kode Wilayah Kemendagri Desa -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Kode Wilayah Kemendagri Desa
                            <span class="text-slate-400 font-normal">(Otomatis terisi saat memilih desa)</span>
                        </label>
                        <input type="text" name="village_code" x-model="villageCode"
                               placeholder="Contoh: 3201012001"
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 font-mono @error('village_code') border-rose-500 @enderror">
                        @error('village_code') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                        <p class="text-[10px] text-slate-400 mt-1">10 digit kode wilayah resmi sesuai Kepmendagri.</p>
                    </div>

                    <!-- 6. Kode Pos -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Pos</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code', $settings['postal_code']) }}"
                               placeholder="Contoh: 16911"
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 font-mono @error('postal_code') border-rose-500 @enderror">
                        @error('postal_code') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- 7. Nama Kepala Desa -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Kepala Desa (Kades)</label>
                        <input type="text" name="village_head_name" value="{{ old('village_head_name', $settings['village_head_name']) }}"
                               placeholder="Contoh: H. Mulyadi, S.Sos."
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 @error('village_head_name') border-rose-500 @enderror">
                        @error('village_head_name') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                        <p class="text-[10px] text-slate-400 mt-1">Nama lengkap beserta gelar jabatan Kepala Desa.</p>
                    </div>

                    <!-- 8. Zona Waktu Wilayah (WIB / WITA / WIT) -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Zona Waktu Wilayah (Timezone) <span class="text-rose-500">*</span>
                        </label>
                        <select name="timezone" required
                                class="w-full px-3 py-2 border rounded-xl text-xs bg-white text-slate-800 focus:ring-1 focus:ring-blue-500 border-slate-300 @error('timezone') border-rose-500 @enderror">
                            @foreach(indonesian_timezones() as $tzKey => $tzLabel)
                                <option value="{{ $tzKey }}" {{ old('timezone', $settings['timezone'] ?? 'Asia/Jakarta') === $tzKey ? 'selected' : '' }}>
                                    {{ $tzLabel }}
                                </option>
                            @endforeach
                        </select>
                        @error('timezone') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                        <p class="text-[10px] text-slate-400 mt-1">Digunakan untuk penanggalan surat resmi, audit trail, dan jam layanan desa.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: KONTAK & KANTOR DESA -->
        <div x-show="activeTab === 'contact'" class="space-y-6" style="display: none;">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="font-bold text-slate-800 text-sm">Alamat Kantor &amp; Layanan Pengaduan Warga</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Informasi kontak ini ditampilkan pada footer tema publik, dokumen persuratan, dan layanan informasi.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Lengkap Kantor Desa <span class="text-rose-500">*</span></label>
                        <textarea name="village_address" rows="3" required
                                  placeholder="Contoh: Jl. Raya Desa Sukamaju No. 01, RT 001/RW 002..."
                                  class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 @error('village_address') border-rose-500 @enderror">{{ old('village_address', $settings['village_address']) }}</textarea>
                        @error('village_address') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor Telepon / WhatsApp <span class="text-rose-500">*</span></label>
                        <input type="text" name="village_phone" value="{{ old('village_phone', $settings['village_phone']) }}" required
                               placeholder="Contoh: 021-87654321 / 081234567890"
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 @error('village_phone') border-rose-500 @enderror">
                        @error('village_phone') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Email Resmi Kantor Desa <span class="text-rose-500">*</span></label>
                        <input type="email" name="village_email" value="{{ old('village_email', $settings['village_email']) }}" required
                               placeholder="Contoh: kantor@sukamaju.desa.id"
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 @error('village_email') border-rose-500 @enderror">
                        @error('village_email') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Jam Operasional Pelayanan Kantor</label>
                        <input type="text" name="office_hours" value="{{ old('office_hours', $settings['office_hours']) }}"
                               placeholder="Contoh: Senin - Kamis: 08.00 - 15.00 WIB, Jumat: 08.00 - 11.30 WIB"
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 @error('office_hours') border-rose-500 @enderror">
                        @error('office_hours') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 3: PORTAL PUBLIK & SEO -->
        <div x-show="activeTab === 'portal'" class="space-y-6" style="display: none;">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="font-bold text-slate-800 text-sm">Judul Website, Tagline &amp; Optimalisasi SEO</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Konfigurasi teks judul peramban (*browser tab title*), slogan promosi desa, dan meta search engine.</p>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Situs Portal Publik (Site Title) <span class="text-rose-500">*</span></label>
                        <input type="text" name="app_title" value="{{ old('app_title', $settings['app_title']) }}" required
                               placeholder="Contoh: SiDesa - Portal Resmi Desa Sukamaju"
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 @error('app_title') border-rose-500 @enderror">
                        @error('app_title') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Slogan / Tagline Resmi Desa <span class="text-rose-500">*</span></label>
                        <input type="text" name="app_tagline" value="{{ old('app_tagline', $settings['app_tagline']) }}" required
                               placeholder="Contoh: Mewujudkan Desa Maju, Mandiri, dan Transparan Berbasis Digital"
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 @error('app_tagline') border-rose-500 @enderror">
                        @error('app_tagline') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Ringkas SEO (Meta Description)</label>
                        <textarea name="meta_description" rows="3"
                                  placeholder="Contoh: Portal resmi Sistem Informasi Desa Sukamaju menyajikan transparansi publik, administrasi persuratan mandiri..."
                                  class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 @error('meta_description') border-rose-500 @enderror">{{ old('meta_description', $settings['meta_description']) }}</textarea>
                        @error('meta_description') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                        <p class="text-[10px] text-slate-400 mt-1">Maksimal 150-160 karakter untuk pratinjau mesin pencari Google.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Kata Kunci Pencarian (Meta Keywords)</label>
                        <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $settings['meta_keywords']) }}"
                               placeholder="Contoh: desa sukamaju, sistem informasi desa, sid, ppid desa, apbdes, surat desa"
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 @error('meta_keywords') border-rose-500 @enderror">
                        @error('meta_keywords') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                        <p class="text-[10px] text-slate-400 mt-1">Pisahkan tiap kata kunci menggunakan tanda koma (,).</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 4: MEDIA SOSIAL & LOGO -->
        <div x-show="activeTab === 'social'" class="space-y-6" style="display: none;">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="font-bold text-slate-800 text-sm">Logo Resmi &amp; Akun Media Sosial</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Tautan akun jejaring sosial resmi untuk menjalin interaksi dan keterhubungan dengan warganet.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Logo Desa -->
                    <div class="md:col-span-2 p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-3">
                        <label class="block text-xs font-semibold text-slate-700">Logo Resmi Pemerintah Desa</label>
                        <div class="flex items-center gap-4">
                            @if(!empty($settings['village_logo']))
                                <img src="{{ $settings['village_logo'] }}" alt="Logo Desa" class="w-16 h-16 object-contain rounded-xl bg-white p-2 border border-slate-200 shadow-sm">
                            @else
                                <div class="w-16 h-16 rounded-xl bg-white border border-dashed border-slate-300 flex items-center justify-center text-2xl text-slate-300">
                                    🏛️
                                </div>
                            @endif
                            <div class="space-y-1">
                                <input type="file" name="village_logo" accept="image/*" class="text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="text-[10px] text-slate-400">Format yang didukung: PNG, JPG, SVG, WebP. Maksimal 2 MB.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Halaman Facebook</label>
                        <input type="url" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url']) }}"
                               placeholder="https://facebook.com/..."
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 @error('facebook_url') border-rose-500 @enderror">
                        @error('facebook_url') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Akun Instagram</label>
                        <input type="url" name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url']) }}"
                               placeholder="https://instagram.com/..."
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 @error('instagram_url') border-rose-500 @enderror">
                        @error('instagram_url') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Kanal YouTube</label>
                        <input type="url" name="youtube_url" value="{{ old('youtube_url', $settings['youtube_url']) }}"
                               placeholder="https://youtube.com/@..."
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 @error('youtube_url') border-rose-500 @enderror">
                        @error('youtube_url') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Akun Twitter / X</label>
                        <input type="url" name="twitter_url" value="{{ old('twitter_url', $settings['twitter_url']) }}"
                               placeholder="https://twitter.com/..."
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 @error('twitter_url') border-rose-500 @enderror">
                        @error('twitter_url') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi Simpan -->
        <div class="flex items-center justify-between pt-4 border-t border-slate-200">
            <span class="text-xs text-slate-400">Seluruh perubahan akan langsung berdampak pada portal publik dan naskah persuratan.</span>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 text-white text-xs font-bold hover:bg-blue-700 shadow-md shadow-blue-600/20 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>Simpan Pengaturan Situs</span>
            </button>
        </div>
    </form>
</div>
@endsection
