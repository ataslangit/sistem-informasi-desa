@extends('installer.layout')

@section('title', 'Langkah 3: Identitas Desa & Administrator')

@section('content')
<div class="space-y-6" x-data="{
    // State form wilayah
    provinceCode: '',
    provinceName: '{{ old('province_name', '') }}',
    regencyCode: '',
    districtName: '{{ old('district_name', '') }}',
    subdistrictCode: '',
    subdistrictName: '{{ old('subdistrict_name', '') }}',
    villageCode: '{{ old('village_code', '') }}',
    villageName: '{{ old('village_name', '') }}',
    villageAddress: '{{ old('village_address', '') }}',
    postalCode: '{{ old('postal_code', '') }}',
    villagePhone: '{{ old('village_phone', '') }}',
    villageEmail: '{{ old('village_email', '') }}',
    timezone: '{{ old('timezone', config('app.timezone', 'Asia/Jakarta')) }}',

    // Daftar referensi
    provinces: {{ \Illuminate\Support\Js::from($provinces ?? []) }},
    regencies: [],
    districts: [],
    villages: [],

    // Status loading
    loadingRegencies: false,
    loadingDistricts: false,
    loadingVillages: false,

    // Aksi saat provinsi dipilih
    onProvinceChange() {
        const p = this.provinces.find(item => item.code === this.provinceCode);
        if (p) {
            this.provinceName = p.name;
            const code = p.code;
            if (['81', '82', '91', '92', '93', '94', '95', '96'].includes(code)) {
                this.timezone = 'Asia/Jayapura';
            } else if (['51', '52', '53', '63', '64', '65', '71', '72', '73', '74', '75', '76'].includes(code)) {
                this.timezone = 'Asia/Makassar';
            } else {
                this.timezone = 'Asia/Jakarta';
            }
        }
        this.regencyCode = '';
        this.districtName = '';
        this.subdistrictCode = '';
        this.subdistrictName = '';
        this.villageCode = '';
        this.villageName = '';
        this.regencies = [];
        this.districts = [];
        this.villages = [];

        if (this.provinceCode) {
            this.loadingRegencies = true;
            fetch('{{ route('installer.wilayah.regencies', '') }}/' + this.provinceCode)
                .then(res => res.json())
                .then(json => {
                    this.regencies = json.data || [];
                })
                .catch(() => {
                    this.regencies = [];
                })
                .finally(() => {
                    this.loadingRegencies = false;
                });
        }
    },

    // Aksi saat kabupaten/kota dipilih
    onRegencyChange() {
        const r = this.regencies.find(item => item.code === this.regencyCode);
        if (r) {
            this.districtName = r.name;
        }
        this.subdistrictCode = '';
        this.subdistrictName = '';
        this.villageCode = '';
        this.villageName = '';
        this.districts = [];
        this.villages = [];

        if (this.regencyCode) {
            this.loadingDistricts = true;
            fetch('{{ route('installer.wilayah.districts', '') }}/' + this.regencyCode)
                .then(res => res.json())
                .then(json => {
                    this.districts = json.data || [];
                })
                .catch(() => {
                    this.districts = [];
                })
                .finally(() => {
                    this.loadingDistricts = false;
                });
        }
    },

    // Aksi saat kecamatan dipilih
    onDistrictChange() {
        const d = this.districts.find(item => item.code === this.subdistrictCode);
        if (d) {
            this.subdistrictName = 'Kecamatan ' + d.name;
        }
        this.villageCode = '';
        this.villageName = '';
        this.villages = [];

        if (this.subdistrictCode) {
            this.loadingVillages = true;
            fetch('{{ route('installer.wilayah.villages', '') }}/' + this.subdistrictCode)
                .then(res => res.json())
                .then(json => {
                    this.villages = json.data || [];
                })
                .catch(() => {
                    this.villages = [];
                })
                .finally(() => {
                    this.loadingVillages = false;
                });
        }
    },

    // Aksi saat desa/kelurahan dipilih
    onVillageChange(event) {
        const code = event.target.value;
        const v = this.villages.find(item => item.code === code);
        if (v) {
            this.villageCode = v.code;
            this.villageName = 'Desa ' + v.name;
            this.villageAddress = 'Jl. Raya ' + this.villageName + ' No. 01, ' + this.subdistrictName + ', ' + this.districtName;
            const cleanSlug = v.name.toLowerCase().replace(/[^a-z0-9]/g, '');
            this.villageEmail = 'kantor@' + (cleanSlug || 'desa') + '.desa.id';
        }
    }
}">
    <!-- Header -->
    <div class="border-b border-slate-100 pb-4">
        <h2 class="text-lg font-bold text-slate-800">Langkah 3: Identitas Desa & Akun Administrator</h2>
        <p class="text-xs text-slate-500 mt-1">
            Lengkapi data identitas wilayah pemerintahan desa (didukung API Wilayah Indonesia resmi) dan buat akun Super Administrator pertama.
        </p>
    </div>

    <form action="{{ route('installer.process') }}" method="POST" class="space-y-6">
        @csrf

        <!-- 1. Identitas Wilayah Desa -->
        <div class="space-y-4">
            <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center space-x-2">
                <span>🏛️</span>
                <span>Identitas Wilayah Pemerintahan Desa</span>
            </h3>

            <!-- Kotak Penelusuran Wilayah Otomatis (Didukung WilayahService) -->
            <div class="p-4 bg-slate-50/80 rounded-2xl border border-slate-200 space-y-3">
                <div class="flex items-center space-x-2 text-xs font-bold text-slate-800">
                    <span class="text-blue-600">🗺️</span>
                    <span>Pilih Wilayah via Basis Data Kemendagri (Otomatis)</span>
                </div>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    Pilih hierarki wilayah Anda di bawah ini untuk mengisi nama provinsi, kabupaten, kecamatan, nama desa, dan kode wilayah Kemendagri secara presisi.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                    <!-- Dropdown Provinsi -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">
                            1. Provinsi
                        </label>
                        <select 
                            x-model="provinceCode" 
                            @change="onProvinceChange()" 
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                            <option value="">-- Pilih Provinsi --</option>
                            <template x-for="p in provinces" :key="p.code">
                                <option :value="p.code" x-text="p.name"></option>
                            </template>
                        </select>
                    </div>

                    <!-- Dropdown Kabupaten / Kota -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1 flex items-center justify-between">
                            <span>2. Kabupaten / Kota</span>
                            <span x-show="loadingRegencies" class="text-[10px] text-blue-600 animate-pulse font-normal">Memuat data...</span>
                        </label>
                        <select 
                            x-model="regencyCode" 
                            @change="onRegencyChange()" 
                            :disabled="!provinceCode || loadingRegencies"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none disabled:bg-slate-100 disabled:text-slate-400"
                        >
                            <option value="">-- Pilih Kabupaten / Kota --</option>
                            <template x-for="r in regencies" :key="r.code">
                                <option :value="r.code" x-text="r.name"></option>
                            </template>
                        </select>
                    </div>

                    <!-- Dropdown Kecamatan -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1 flex items-center justify-between">
                            <span>3. Kecamatan</span>
                            <span x-show="loadingDistricts" class="text-[10px] text-blue-600 animate-pulse font-normal">Memuat data...</span>
                        </label>
                        <select 
                            x-model="subdistrictCode" 
                            @change="onDistrictChange()" 
                            :disabled="!regencyCode || loadingDistricts"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none disabled:bg-slate-100 disabled:text-slate-400"
                        >
                            <option value="">-- Pilih Kecamatan --</option>
                            <template x-for="d in districts" :key="d.code">
                                <option :value="d.code" x-text="d.name"></option>
                            </template>
                        </select>
                    </div>

                    <!-- Dropdown Desa / Kelurahan -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1 flex items-center justify-between">
                            <span>4. Desa / Kelurahan</span>
                            <span x-show="loadingVillages" class="text-[10px] text-blue-600 animate-pulse font-normal">Memuat data...</span>
                        </label>
                        <select 
                            @change="onVillageChange($event)" 
                            :disabled="!subdistrictCode || loadingVillages"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none disabled:bg-slate-100 disabled:text-slate-400"
                        >
                            <option value="">-- Pilih Desa / Kelurahan --</option>
                            <template x-for="v in villages" :key="v.code">
                                <option :value="v.code" x-text="v.name"></option>
                            </template>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Field Input Form Hasil Pilihan (Dapat Disesuaikan Bebas) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label for="village_name" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Nama Resmi Desa <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="village_name" 
                        name="village_name" 
                        x-model="villageName" 
                        required 
                        placeholder="Contoh: Desa Sukamaju / Desa Mandiri Jaya"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    @error('village_name')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="village_code" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Kode Wilayah Kemendagri
                    </label>
                    <input 
                        type="text" 
                        id="village_code" 
                        name="village_code" 
                        x-model="villageCode" 
                        placeholder="Contoh: 32.01.01.2001"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    <span class="text-[10px] text-slate-400 mt-0.5 block">Kode referensi Kemendagri (terisi otomatis dari pilihan).</span>
                </div>

                <div>
                    <label for="subdistrict_name" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Nama Kecamatan <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="subdistrict_name" 
                        name="subdistrict_name" 
                        x-model="subdistrictName" 
                        required 
                        placeholder="Contoh: Kecamatan Makmur"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    @error('subdistrict_name')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="district_name" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Nama Kabupaten / Kota <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="district_name" 
                        name="district_name" 
                        x-model="districtName" 
                        required 
                        placeholder="Contoh: Kabupaten Bogor"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    @error('district_name')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="province_name" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Nama Provinsi <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="province_name" 
                        name="province_name" 
                        x-model="provinceName" 
                        required 
                        placeholder="Contoh: Jawa Barat"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    @error('province_name')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="timezone" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Zona Waktu Operasional <span class="text-rose-500">*</span>
                    </label>
                    <select 
                        id="timezone" 
                        name="timezone" 
                        x-model="timezone" 
                        required 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                        @foreach(indonesian_timezones() as $tzKey => $tzDesc)
                            <option value="{{ $tzKey }}">{{ $tzDesc }}</option>
                        @endforeach
                    </select>
                    <span class="text-[10px] text-slate-400 mt-0.5 block">Zona waktu resmi untuk penanggalan surat, presensi, berita, dan log audit.</span>
                    @error('timezone')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="village_address" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Alamat Kantor Desa <span class="text-rose-500">*</span> <span class="text-slate-400 font-normal text-[11px]">(Ditampilkan di Footer Website & KOP Surat Resmi)</span>
                    </label>
                    <textarea 
                        id="village_address" 
                        name="village_address" 
                        rows="2"
                        x-model="villageAddress" 
                        placeholder="Contoh: Jl. Raya Desa No. 01, RT 01/RW 02"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    ></textarea>
                    <span class="text-[10px] text-slate-400 mt-0.5 block">Alamat ini otomatis disinkronkan ke footer tema dan surat resmi desa.</span>
                    @error('village_address')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="postal_code" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Kode Pos
                    </label>
                    <input 
                        type="text" 
                        id="postal_code" 
                        name="postal_code" 
                        x-model="postalCode" 
                        placeholder="Contoh: 16911"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    @error('postal_code')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="village_phone" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Telepon / WhatsApp Kantor
                    </label>
                    <input 
                        type="text" 
                        id="village_phone" 
                        name="village_phone" 
                        x-model="villagePhone" 
                        placeholder="Contoh: 081234567890 / 021-88889999"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>

                <div class="sm:col-span-2">
                    <label for="village_email" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Alamat Email Resmi Desa
                    </label>
                    <input 
                        type="email" 
                        id="village_email" 
                        name="village_email" 
                        x-model="villageEmail" 
                        placeholder="Contoh: kantor@desa.id"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    @error('village_email')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- 2. Akun Super Administrator Utama -->
        <div class="space-y-4">
            <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center space-x-2">
                <span>👤</span>
                <span>Akun Super Administrator Utama</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label for="admin_name" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Nama Lengkap Administrator <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="admin_name" 
                        name="admin_name" 
                        value="{{ old('admin_name', 'Administrator Desa') }}" 
                        required 
                        placeholder="Contoh: Budi Prasetyo, S.Kom."
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    @error('admin_name')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="admin_username" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Username Login <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="admin_username" 
                        name="admin_username" 
                        value="{{ old('admin_username', 'admin') }}" 
                        required 
                        placeholder="admin"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    <span class="text-[10px] text-slate-400 mt-0.5 block">Huruf kecil, angka atau garis bawah (_).</span>
                    @error('admin_username')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="admin_email" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="email" 
                        id="admin_email" 
                        name="admin_email" 
                        value="{{ old('admin_email', 'admin@desa.id') }}" 
                        required 
                        placeholder="admin@desa.id"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    @error('admin_email')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="admin_password" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Kata Sandi (Password) <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="password" 
                        id="admin_password" 
                        name="admin_password" 
                        required 
                        placeholder="Minimal 8 karakter..."
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    @error('admin_password')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="admin_password_confirmation" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Ulangi Kata Sandi <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="password" 
                        id="admin_password_confirmation" 
                        name="admin_password_confirmation" 
                        required 
                        placeholder="Ulangi kata sandi..."
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>

                <div class="sm:col-span-2">
                    <label for="admin_phone" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Nomor Kontak / WhatsApp
                    </label>
                    <input 
                        type="text" 
                        id="admin_phone" 
                        name="admin_phone" 
                        value="{{ old('admin_phone') }}" 
                        placeholder="081234567890"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>
            </div>
        </div>

        <!-- 3. Pilihan Memuat Data Demo -->
        <div class="p-4 bg-blue-50/60 rounded-2xl border border-blue-200">
            <label class="flex items-start space-x-3 cursor-pointer">
                <input 
                    type="checkbox" 
                    name="load_demo_data" 
                    value="1" 
                    {{ old('load_demo_data') ? 'checked' : '' }}
                    class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-4 h-4 mt-0.5"
                >
                <div class="text-xs text-blue-900">
                    <span class="font-bold block">Muat Data Demo / Contoh untuk Uji Coba</span>
                    <span class="text-[11px] text-blue-700 leading-relaxed block mt-0.5">
                        Centang opsi ini jika Anda ingin sistem langsung memiliki contoh data penduduk, artikel berita, dokumen PPID, sarana GIS, dan APBDes untuk dipelajari. Kosongkan jika ingin memulai dengan basis data bersih (*clean database*).
                    </span>
                </div>
            </label>
        </div>

        <!-- Tombol Aksi -->
        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('installer.database') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition">
                &larr; Kembali ke Basis Data
            </a>

            <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm flex items-center space-x-2">
                <span>Pasang SiDesa Sekarang</span>
                <span>&rarr;</span>
            </button>
        </div>
    </form>
</div>
@endsection
