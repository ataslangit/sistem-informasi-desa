@extends('admin.layouts.app')

@section('title', ($editingFacility ? 'Edit Fasilitas: ' . $editingFacility->name : 'Manajemen Fasilitas & Aset Desa (GIS)'))

@section('content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Fasilitas Umum & Infrastruktur Desa (Web GIS)</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola data titik koordinat sarana publik, infrastruktur desa, dan inventarisasi aset desa sesuai Permendagri No. 1/2016.</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('map.index') }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition space-x-1.5 border border-slate-300">
                <span>🗺️</span>
                <span>Buka Peta Web GIS</span>
            </a>
        </div>
    </div>

    <!-- Alert Mode Edit (Jika sedang mengedit) -->
    @if($editingFacility)
        <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="text-xl">✏️</span>
                <div>
                    <h3 class="text-xs font-bold text-amber-900">Mode Edit Titik Fasilitas: {{ $editingFacility->name }}</h3>
                    <p class="text-[11px] text-amber-700 mt-0.5">Anda sedang mengubah data sarana/fasilitas ini. Geser marker di peta atau klik lokasi baru untuk memperbarui koordinat.</p>
                </div>
            </div>
            <a href="{{ route('admin.facilities.index') }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-white border border-amber-300 text-amber-900 hover:bg-amber-100 transition shadow-2xs">
                Batal Edit
            </a>
        </div>
    @endif

    <!-- Layout Form Tambah/Edit Fasilitas (1/3) & Daftar Fasilitas (2/3) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Fasilitas -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4 h-fit">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-slate-800 text-sm flex items-center space-x-2">
                    <span>📍</span>
                    <span>{{ $editingFacility ? 'Edit Titik Fasilitas & Aset' : 'Tambah Titik Fasilitas & Aset' }}</span>
                </h3>
                @if($editingFacility)
                    <a href="{{ route('admin.facilities.index') }}" class="text-[11px] text-rose-600 hover:text-rose-800 font-semibold">
                        &times; Batal
                    </a>
                @endif
            </div>

            <form action="{{ $editingFacility ? route('admin.facilities.update', $editingFacility) : route('admin.facilities.store') }}" method="POST" class="space-y-4">
                @csrf
                @if($editingFacility)
                    @method('PUT')
                @endif

                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Nama Sarana / Fasilitas <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $editingFacility?->name) }}" 
                        required 
                        placeholder="Contoh: Kantor Kepala Desa Sukamaju"
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    @error('name')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="category" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Kategori <span class="text-rose-500">*</span>
                        </label>
                        <select 
                            id="category" 
                            name="category" 
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white"
                        >
                            @foreach($categories as $key => $cat)
                                <option value="{{ $key }}" {{ old('category', $editingFacility?->category) === $key ? 'selected' : '' }}>
                                    {{ $cat['icon'] }} {{ $cat['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="condition" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Kondisi Fisik <span class="text-rose-500">*</span>
                        </label>
                        <select 
                            id="condition" 
                            name="condition" 
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white"
                        >
                            <option value="baik" {{ old('condition', $editingFacility?->condition) === 'baik' ? 'selected' : '' }}>Kondisi Baik</option>
                            <option value="rusak_ringan" {{ old('condition', $editingFacility?->condition) === 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="rusak_berat" {{ old('condition', $editingFacility?->condition) === 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                    </div>
                </div>

                <!-- Leaflet Interactive Point Picker -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Pilih Titik di Peta (Klik pada Peta)
                    </label>
                    <div id="pickerMap" class="w-full h-44 rounded-xl border border-slate-200 overflow-hidden mb-2 z-10"></div>
                    <span class="text-[10px] text-slate-400 block">Klik pada peta di atas atau geser pin untuk memperbarui koordinat.</span>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="latitude" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Latitude <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            step="any" 
                            id="latitude" 
                            name="latitude" 
                            value="{{ old('latitude', $editingFacility ? $editingFacility->latitude : '-6.914744') }}" 
                            required 
                            class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none font-mono"
                        >
                        @error('latitude')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="longitude" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Longitude <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            step="any" 
                            id="longitude" 
                            name="longitude" 
                            value="{{ old('longitude', $editingFacility ? $editingFacility->longitude : '107.609810') }}" 
                            required 
                            class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none font-mono"
                        >
                        @error('longitude')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="address" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Alamat / Lokasi
                    </label>
                    <input 
                        type="text" 
                        id="address" 
                        name="address" 
                        value="{{ old('address', $editingFacility?->address) }}" 
                        placeholder="Contoh: Jl. Raya Desa No. 12 RT 01/02"
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>

                <!-- Bagian Atribut Yuridis Aset Desa (Permendagri No. 1/2016) -->
                <div class="pt-3 border-t border-slate-200 space-y-3" x-data="{ isAsset: {{ old('is_village_asset', $editingFacility?->is_village_asset) ? 'true' : 'false' }} }">
                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-200">
                        <label class="flex items-center space-x-2.5 cursor-pointer select-none">
                            <input 
                                type="checkbox" 
                                name="is_village_asset" 
                                value="1" 
                                x-model="isAsset"
                                class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4 cursor-pointer"
                            >
                            <div>
                                <span class="text-xs font-bold text-slate-800 block">🏛️ Aset Resmi Milik Desa</span>
                                <span class="text-[10px] text-slate-500 block">Tercatat dalam inventarisasi barang desa</span>
                            </div>
                        </label>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">
                            Permendagri 1/2016
                        </span>
                    </div>

                    <div x-show="isAsset" x-transition class="space-y-3 bg-blue-50/50 p-3.5 rounded-xl border border-blue-200">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label for="kib_type" class="block text-[11px] font-bold text-slate-700 uppercase mb-1">
                                    Klasifikasi KIB
                                </label>
                                <select 
                                    id="kib_type" 
                                    name="kib_type" 
                                    class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 bg-white"
                                >
                                    <option value="">-- Pilih Kode KIB --</option>
                                    @foreach($kibMetas as $code => $kib)
                                        <option value="{{ $code }}" {{ old('kib_type', $editingFacility?->kib_type) === $code ? 'selected' : '' }}>
                                            {{ $kib['code'] }}: {{ $kib['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="ownership_status" class="block text-[11px] font-bold text-slate-700 uppercase mb-1">
                                    Status Hak Kepemilikan
                                </label>
                                <select 
                                    id="ownership_status" 
                                    name="ownership_status" 
                                    class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 bg-white"
                                >
                                    <option value="">-- Status Kepemilikan --</option>
                                    @foreach($ownershipStatuses as $code => $own)
                                        <option value="{{ $code }}" {{ old('ownership_status', $editingFacility?->ownership_status) === $code ? 'selected' : '' }}>
                                            {{ $own['short_label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="register_code" class="block text-[11px] font-bold text-slate-700 uppercase mb-1">
                                Kode Register / Inventaris (KIB)
                            </label>
                            <input 
                                type="text" 
                                id="register_code" 
                                name="register_code" 
                                value="{{ old('register_code', $editingFacility?->register_code) }}" 
                                placeholder="Contoh: KIB-C.001.2024"
                                class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 bg-white font-mono"
                            >
                        </div>

                        <div class="grid grid-cols-3 gap-2">
                            <div>
                                <label for="surface_area" class="block text-[10px] font-bold text-slate-700 uppercase mb-1">
                                    Luas (m²)
                                </label>
                                <input 
                                    type="number" 
                                    step="0.01" 
                                    id="surface_area" 
                                    name="surface_area" 
                                    value="{{ old('surface_area', $editingFacility?->surface_area) }}" 
                                    placeholder="0.00"
                                    class="w-full px-2 py-1.5 rounded-lg border border-slate-300 text-xs bg-white"
                                >
                            </div>

                            <div>
                                <label for="acquisition_year" class="block text-[10px] font-bold text-slate-700 uppercase mb-1">
                                    Tahun
                                </label>
                                <input 
                                    type="number" 
                                    id="acquisition_year" 
                                    name="acquisition_year" 
                                    value="{{ old('acquisition_year', $editingFacility?->acquisition_year) }}" 
                                    placeholder="{{ date('Y') }}"
                                    class="w-full px-2 py-1.5 rounded-lg border border-slate-300 text-xs bg-white"
                                >
                            </div>

                            <div>
                                <label for="asset_value" class="block text-[10px] font-bold text-slate-700 uppercase mb-1">
                                    Nilai Aset (Rp)
                                </label>
                                <input 
                                    type="number" 
                                    step="1" 
                                    id="asset_value" 
                                    name="asset_value" 
                                    value="{{ old('asset_value', $editingFacility?->asset_value) }}" 
                                    placeholder="0"
                                    class="w-full px-2 py-1.5 rounded-lg border border-slate-300 text-xs bg-white"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="image_url" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        URL Foto Dokumentasi
                    </label>
                    <input 
                        type="url" 
                        id="image_url" 
                        name="image_url" 
                        value="{{ old('image_url', $editingFacility?->image_url) }}" 
                        placeholder="https://... URL gambar"
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>

                <div>
                    <label for="description" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Keterangan Singkat
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="2" 
                        placeholder="Fasilitas penunjang, jam buka, dokumen bukti kepemilikan..."
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >{{ old('description', $editingFacility?->description) }}</textarea>
                </div>

                <div class="space-y-2">
                    <button type="submit" class="w-full px-4 py-2.5 rounded-xl text-xs font-semibold {{ $editingFacility ? 'bg-amber-600 hover:bg-amber-700' : 'bg-blue-600 hover:bg-blue-700' }} text-white transition shadow-sm">
                        {{ $editingFacility ? 'Perbarui Titik Fasilitas / Aset' : 'Simpan Titik Fasilitas / Aset' }}
                    </button>
                    @if($editingFacility)
                        <a href="{{ route('admin.facilities.index') }}" class="w-full inline-block text-center py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 transition">
                            Batalkan Pengeditan
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tabel Daftar Fasilitas -->
        <div class="lg:col-span-2 space-y-4">
            <!-- Filter Kategori & Filter Aset Tabs -->
            <div class="space-y-2.5 bg-white p-4 rounded-2xl border border-slate-200">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-700">Filter Data:</span>
                    <div class="flex items-center space-x-2">
                        <a 
                            href="{{ route('admin.facilities.index', array_merge(request()->query(), ['is_village_asset' => request('is_village_asset') === '1' ? null : '1'])) }}" 
                            class="px-2.5 py-1 rounded-lg text-[11px] font-bold border transition {{ request('is_village_asset') === '1' ? 'bg-blue-600 text-white border-blue-600' : 'bg-slate-50 text-slate-600 border-slate-200 hover:bg-slate-100' }}"
                        >
                            🏛️ Hanya Aset Desa
                        </a>
                        @if(request()->anyFilled(['category', 'kib_type', 'ownership_status', 'is_village_asset']))
                            <a href="{{ route('admin.facilities.index') }}" class="text-[11px] text-rose-600 hover:underline">
                                Reset Filter
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Filter Kategori Tabs -->
                <div class="flex items-center space-x-1.5 overflow-x-auto pb-1 scrollbar-none">
                    <a 
                        href="{{ route('admin.facilities.index', array_merge(request()->query(), ['category' => null])) }}" 
                        class="px-2.5 py-1 rounded-lg text-[11px] font-semibold transition whitespace-nowrap {{ empty($category) ? 'bg-slate-800 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                    >
                        Semua Kategori
                    </a>
                    @foreach($categories as $key => $cat)
                        <a 
                            href="{{ route('admin.facilities.index', array_merge(request()->query(), ['category' => $key])) }}" 
                            class="px-2.5 py-1 rounded-lg text-[11px] font-semibold transition whitespace-nowrap {{ $category === $key ? 'bg-slate-800 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                        >
                            <span>{{ $cat['icon'] }}</span>
                            <span class="ml-1">{{ $cat['label'] }}</span>
                        </a>
                    @endforeach
                </div>

                <!-- Filter KIB Tabs -->
                <div class="flex items-center space-x-1.5 overflow-x-auto pt-1 border-t border-slate-100 scrollbar-none">
                    <span class="text-[10px] font-bold uppercase text-slate-400 shrink-0">KIB:</span>
                    <a 
                        href="{{ route('admin.facilities.index', array_merge(request()->query(), ['kib_type' => null])) }}" 
                        class="px-2 py-0.5 rounded text-[10px] font-bold transition whitespace-nowrap {{ empty($kibType) ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                    >
                        Semua KIB
                    </a>
                    @foreach($kibMetas as $kCode => $kib)
                        <a 
                            href="{{ route('admin.facilities.index', array_merge(request()->query(), ['kib_type' => $kCode])) }}" 
                            class="px-2 py-0.5 rounded text-[10px] font-bold transition whitespace-nowrap {{ $kibType === $kCode ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                        >
                            {{ $kib['code'] }}: {{ $kib['name'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200 text-[11px]">
                                <th class="py-3 px-4">Fasilitas / Sarana</th>
                                <th class="py-3 px-4">Klasifikasi Yuridis Aset</th>
                                <th class="py-3 px-4">Kategori</th>
                                <th class="py-3 px-4">Kondisi</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($facilities as $facility)
                                <tr class="hover:bg-slate-50">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center space-x-3">
                                            @if($facility->image_url)
                                                <img src="{{ $facility->image_url }}" alt="{{ $facility->name }}" class="w-10 h-10 rounded-lg object-cover shrink-0">
                                            @else
                                                <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-lg shrink-0">
                                                    {{ $facility->category_meta['icon'] }}
                                                </div>
                                            @endif
                                            <div class="min-w-0">
                                                <div class="flex items-center space-x-1.5 flex-wrap">
                                                    <span class="font-bold text-slate-800 truncate">{{ $facility->name }}</span>
                                                    @if($facility->is_village_asset)
                                                        <span class="px-1.5 py-0.2 rounded text-[9px] font-bold bg-blue-100 text-blue-700">
                                                            Aset Desa
                                                        </span>
                                                    @endif
                                                </div>
                                                <span class="text-[11px] text-slate-400 truncate block">{{ $facility->address ?? '-' }}</span>
                                                @if($facility->register_code)
                                                    <span class="font-mono text-[10px] text-indigo-600 block">No. Reg: {{ $facility->register_code }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($facility->is_village_asset || $facility->kib_type || $facility->ownership_status)
                                            <div class="space-y-1">
                                                @if($facility->kib_meta)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                                        {{ $facility->kib_meta['code'] }}: {{ $facility->kib_meta['name'] }}
                                                    </span>
                                                @endif
                                                @if($facility->ownership_meta)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200 block w-fit">
                                                        {{ $facility->ownership_meta['icon'] }} {{ $facility->ownership_meta['short_label'] }}
                                                    </span>
                                                @endif
                                                @if($facility->surface_area)
                                                    <span class="text-[10px] text-slate-500 block">Luas: {{ number_format($facility->surface_area, 0, ',', '.') }} m²</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-slate-400 text-[11px] italic">Non-Aset Desa</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700 whitespace-nowrap">
                                            {{ $facility->category_meta['icon'] }} {{ $facility->category_meta['label'] }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 whitespace-nowrap">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $facility->condition === 'baik' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                            {{ $facility->condition_label }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center whitespace-nowrap space-x-2">
                                        <a href="{{ route('admin.facilities.index', ['edit' => $facility->id]) }}" class="text-amber-600 hover:text-amber-800 font-semibold text-[11px] inline-flex items-center space-x-1">
                                            <span>✏️</span>
                                            <span>Edit</span>
                                        </a>
                                        <form action="{{ route('admin.facilities.destroy', $facility) }}" method="POST" onsubmit="return confirm('Hapus fasilitas umum ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold text-[11px]">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-400">Belum ada titik fasilitas yang sesuai.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($facilities->hasPages())
                <div class="p-4 bg-white rounded-2xl border border-slate-200">
                    {{ $facilities->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        const initialLat = parseFloat(latInput.value) || -6.914744;
        const initialLng = parseFloat(lngInput.value) || 107.609810;

        const pickerMap = L.map('pickerMap').setView([initialLat, initialLng], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap',
            maxZoom: 19
        }).addTo(pickerMap);

        let marker = L.marker([initialLat, initialLng], { draggable: true }).addTo(pickerMap);

        @if($editingFacility)
            marker.bindPopup("<b>{{ addslashes($editingFacility->name) }}</b><br><span class='text-[10px] text-slate-500'>Geser pin untuk memindahkan lokasi</span>").openPopup();
        @endif

        marker.on('dragend', function (e) {
            const coord = marker.getLatLng();
            latInput.value = coord.lat.toFixed(6);
            lngInput.value = coord.lng.toFixed(6);
        });

        pickerMap.on('click', function (e) {
            marker.setLatLng(e.latlng);
            latInput.value = e.latlng.lat.toFixed(6);
            lngInput.value = e.latlng.lng.toFixed(6);
        });

        setTimeout(function () {
            pickerMap.invalidateSize();
        }, 200);
    });
</script>
@endsection
