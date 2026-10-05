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
        <div x-show="activeTab === 'general'" class="space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="font-bold text-slate-800 text-sm">Pemerintahan &amp; Batas Administrasi Wilayah</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Identitas ini digunakan pada kop surat dinas, penomoran dokumen resmi, serta metadata agregat SIK.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Resmi Desa <span class="text-rose-500">*</span></label>
                        <input type="text" name="village_name" value="{{ old('village_name', $settings['village_name']) }}" required
                               placeholder="Contoh: Desa Sukamaju"
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 @error('village_name') border-rose-500 @enderror">
                        @error('village_name') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Wilayah Kemendagri Desa</label>
                        <input type="text" name="village_code" value="{{ old('village_code', $settings['village_code']) }}"
                               placeholder="Contoh: 3201012001"
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 font-mono @error('village_code') border-rose-500 @enderror">
                        @error('village_code') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                        <p class="text-[10px] text-slate-400 mt-1">10 digit kode wilayah resmi sesuai Kepmendagri.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Kecamatan <span class="text-rose-500">*</span></label>
                        <input type="text" name="subdistrict_name" value="{{ old('subdistrict_name', $settings['subdistrict_name']) }}" required
                               placeholder="Contoh: Kecamatan Cibinong"
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 @error('subdistrict_name') border-rose-500 @enderror">
                        @error('subdistrict_name') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Kabupaten / Kota <span class="text-rose-500">*</span></label>
                        <input type="text" name="district_name" value="{{ old('district_name', $settings['district_name']) }}" required
                               placeholder="Contoh: Kabupaten Bogor"
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 @error('district_name') border-rose-500 @enderror">
                        @error('district_name') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Provinsi <span class="text-rose-500">*</span></label>
                        <input type="text" name="province_name" value="{{ old('province_name', $settings['province_name']) }}" required
                               placeholder="Contoh: Jawa Barat"
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 @error('province_name') border-rose-500 @enderror">
                        @error('province_name') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Pos</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code', $settings['postal_code']) }}"
                               placeholder="Contoh: 16911"
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 font-mono @error('postal_code') border-rose-500 @enderror">
                        @error('postal_code') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Kepala Desa (Kades)</label>
                        <input type="text" name="village_head_name" value="{{ old('village_head_name', $settings['village_head_name']) }}"
                               placeholder="Contoh: H. Mulyadi, S.Sos."
                               class="w-full px-3 py-2 border rounded-xl text-xs bg-slate-50/50 focus:bg-white focus:ring-1 focus:ring-blue-500 @error('village_head_name') border-rose-500 @enderror">
                        @error('village_head_name') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                        <p class="text-[10px] text-slate-400 mt-1">Nama lengkap beserta gelar jabatan Kepala Desa yang menjabat.</p>
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
