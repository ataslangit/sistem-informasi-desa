@extends('admin.layouts.app')

@section('title', 'Manajemen Fasilitas & Infrastruktur Desa')

@section('content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Fasilitas Umum & Infrastruktur Desa</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola data titik lokasi koordinat sarana publik, kantor pelayanan, tempat ibadah, dan infrastruktur desa.</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('map.index') }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition space-x-1.5 border border-slate-300">
                <span>🗺️</span>
                <span>Buka Peta Web GIS</span>
            </a>
        </div>
    </div>

    <!-- Layout Form Tambah Fasilitas (1/3) & Daftar Fasilitas (2/3) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Tambah Titik Fasilitas -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4 h-fit">
            <h3 class="font-bold text-slate-800 text-sm flex items-center space-x-2">
                <span>📍</span>
                <span>Tambah Titik Fasilitas Baru</span>
            </h3>

            <form action="{{ route('admin.facilities.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Nama Sarana / Fasilitas <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        placeholder="Contoh: Puskesmas Pembantu Sukamaju"
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
                                <option value="{{ $key }}" {{ old('category') === $key ? 'selected' : '' }}>
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
                            <option value="baik" {{ old('condition') === 'baik' ? 'selected' : '' }}>Kondisi Baik</option>
                            <option value="rusak_ringan" {{ old('condition') === 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="rusak_berat" {{ old('condition') === 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                    </div>
                </div>

                <!-- Leaflet Interactive Point Picker -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Pilih Titik di Peta (Klik pada Peta)
                    </label>
                    <div id="pickerMap" class="w-full h-44 rounded-xl border border-slate-200 overflow-hidden mb-2 z-10"></div>
                    <span class="text-[10px] text-slate-400 block">Klik pada peta di atas untuk mengisi koordinat otomatis.</span>
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
                            value="{{ old('latitude', '-6.914744') }}" 
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
                            value="{{ old('longitude', '107.609810') }}" 
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
                        value="{{ old('address') }}" 
                        placeholder="Contoh: Jl. Raya Desa No. 12 RT 01/02"
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>

                <div>
                    <label for="image_url" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        URL Foto Dokumentasi
                    </label>
                    <input 
                        type="url" 
                        id="image_url" 
                        name="image_url" 
                        value="{{ old('image_url') }}" 
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
                        placeholder="Fasilitas penunjang, jam buka, dll..."
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="w-full px-4 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
                    Simpan Titik Fasilitas
                </button>
            </form>
        </div>

        <!-- Tabel Daftar Fasilitas -->
        <div class="lg:col-span-2 space-y-4">
            <!-- Filter Kategori Tabs -->
            <div class="flex items-center space-x-2 overflow-x-auto pb-1 scrollbar-none">
                <a 
                    href="{{ route('admin.facilities.index') }}" 
                    class="px-3 py-1.5 rounded-xl text-xs font-bold transition whitespace-nowrap {{ empty($category) ? 'bg-slate-800 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}"
                >
                    Semua
                </a>
                @foreach($categories as $key => $cat)
                    <a 
                        href="{{ route('admin.facilities.index', ['category' => $key]) }}" 
                        class="px-3 py-1.5 rounded-xl text-xs font-bold transition whitespace-nowrap {{ $category === $key ? 'bg-slate-800 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}"
                    >
                        <span>{{ $cat['icon'] }}</span>
                        <span class="ml-1">{{ $cat['label'] }}</span>
                    </a>
                @endforeach
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200 text-[11px]">
                                <th class="py-3 px-4">Fasilitas / Sarana</th>
                                <th class="py-3 px-4">Kategori</th>
                                <th class="py-3 px-4">Koordinat Lat / Lng</th>
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
                                                <span class="font-bold text-slate-800 block truncate">{{ $facility->name }}</span>
                                                <span class="text-[11px] text-slate-400 truncate block">{{ $facility->address ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700 whitespace-nowrap">
                                            {{ $facility->category_meta['icon'] }} {{ $facility->category_meta['label'] }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 font-mono text-[11px] text-slate-600 whitespace-nowrap">
                                        {{ number_format($facility->latitude, 5) }}, {{ number_format($facility->longitude, 5) }}
                                    </td>
                                    <td class="py-3 px-4 whitespace-nowrap">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $facility->condition === 'baik' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                            {{ $facility->condition_label }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center">
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
    });
</script>
@endsection
