@extends('admin.layouts.app')

@section('title', ($editingBoundary ? 'Edit Batas Wilayah: ' . $editingBoundary->name : 'Manajemen Batas Wilayah Administratif Desa'))

@section('content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<style>
    .vertex-marker {
        background-color: white;
        border: 2.5px solid #0284c7;
        border-radius: 50%;
        width: 14px;
        height: 14px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.35);
        cursor: grab;
    }
    .vertex-marker:active {
        cursor: grabbing;
    }
</style>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Batas Wilayah Administratif Desa</h2>
            <p class="text-xs text-slate-500 mt-1">Gambar, tentukan, dan edit poligon koordinat spasial batas desa, dusun, RW, dan RT secara interaktif langsung pada peta.</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('map.index') }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition space-x-1.5 border border-slate-300">
                <span>🗺️</span>
                <span>Lihat di Portal Web GIS</span>
            </a>
        </div>
    </div>

    <!-- Alert Mode Edit (Jika sedang mengedit) -->
    @if($editingBoundary)
        <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="text-xl">✏️</span>
                <div>
                    <h3 class="text-xs font-bold text-amber-900">Mode Edit Poligon Aktif: {{ $editingBoundary->name }}</h3>
                    <p class="text-[11px] text-amber-700 mt-0.5">Anda sedang mengubah batas wilayah ini. Geser titik sudut atau klik pada peta untuk menambah/menyesuaikan batas.</p>
                </div>
            </div>
            <a href="{{ route('admin.boundaries.index') }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-white border border-amber-300 text-amber-900 hover:bg-amber-100 transition shadow-2xs">
                Batal Edit
            </a>
        </div>
    @endif

    <!-- Layout: Studio Gambar Peta Interaktif & Formulir -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h3 class="text-base font-bold text-slate-800 flex items-center space-x-2" id="studioTitle">
                    @if($editingBoundary)
                        <span>✏️</span>
                        <span>Edit Poligon Batas: {{ $editingBoundary->name }}</span>
                    @else
                        <span>📐</span>
                        <span>Studio Gambar Poligon Batas Wilayah</span>
                    @endif
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Klik pada peta untuk menambah titik sudut, atau geser titik sudut bulat untuk menyesuaikan perbatasan wilayah.
                </p>
            </div>
            @if($editingBoundary)
                <a href="{{ route('admin.boundaries.index') }}" class="text-xs font-semibold text-rose-600 hover:text-rose-800 transition">
                    &times; Batal & Buat Baru
                </a>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Kolom Kiri: Peta Gambar Interaktif (7/12) -->
            <div class="lg:col-span-7 space-y-3">
                <!-- Toolbar Peta -->
                <div class="flex flex-wrap items-center justify-between gap-2 p-2.5 bg-slate-50 rounded-2xl border border-slate-200 text-xs">
                    <div class="flex items-center space-x-2">
                        <span class="px-2.5 py-1 rounded-lg bg-sky-100 text-sky-800 font-bold" id="vertexCounter">
                            0 Titik Ditandai
                        </span>
                        <span class="text-slate-600 font-medium text-[11px]" id="areaEstimator">
                            Estimasi Luas: 0 Ha
                        </span>
                    </div>

                    <div class="flex items-center space-x-2">
                        <button 
                            type="button" 
                            id="btnUndoVertex" 
                            onclick="undoLastPoint()" 
                            class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 font-semibold transition flex items-center space-x-1 shadow-2xs"
                            title="Hapus titik terakhir"
                        >
                            <span>↩️</span>
                            <span>Hapus Titik Terakhir</span>
                        </button>
                        <button 
                            type="button" 
                            id="btnClearPoints" 
                            onclick="resetDrawing()" 
                            class="px-3 py-1.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 hover:bg-rose-100 font-semibold transition flex items-center space-x-1"
                            title="Reset gambar"
                        >
                            <span>🗑️</span>
                            <span>Reset Poligon</span>
                        </button>
                    </div>
                </div>

                <!-- Kontainer Leaflet Canvas -->
                <div class="relative rounded-2xl border border-slate-200 overflow-hidden shadow-inner">
                    <div id="drawMap" class="w-full h-[470px] z-10"></div>
                    <div class="absolute bottom-3 left-3 z-20 bg-white/95 backdrop-blur-md px-3.5 py-1.5 rounded-xl border border-slate-200 text-[11px] text-slate-700 shadow-sm pointer-events-none">
                        💡 <b>Tips:</b> Klik peta untuk tambah titik, geser titik sudut untuk edit posisi koordinat.
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Form Data Wilayah (5/12) -->
            <div class="lg:col-span-5 bg-slate-50/70 p-5 rounded-2xl border border-slate-200">
                <form 
                    action="{{ $editingBoundary ? route('admin.boundaries.update', $editingBoundary) : route('admin.boundaries.store') }}" 
                    method="POST" 
                    id="boundaryForm" 
                    class="space-y-4"
                >
                    @csrf
                    @if($editingBoundary)
                        @method('PUT')
                    @endif
                    <input type="hidden" name="_method_placeholder" id="methodPlaceholder" value="{{ $editingBoundary ? 'PUT' : 'POST' }}">

                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Nama Wilayah / Batas <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', $editingBoundary?->name) }}" 
                            required 
                            placeholder="Contoh: Wilayah Dusun Sukamaju 3"
                            class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white"
                        >
                        @error('name')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="type" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Tingkat Wilayah <span class="text-rose-500">*</span>
                            </label>
                            <select 
                                id="type" 
                                name="type" 
                                class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white"
                            >
                                <option value="dusun" {{ old('type', $editingBoundary?->type) === 'dusun' ? 'selected' : '' }}>Dusun</option>
                                <option value="village" {{ old('type', $editingBoundary?->type) === 'village' ? 'selected' : '' }}>Batas Desa</option>
                                <option value="rw" {{ old('type', $editingBoundary?->type) === 'rw' ? 'selected' : '' }}>RW</option>
                                <option value="rt" {{ old('type', $editingBoundary?->type) === 'rt' ? 'selected' : '' }}>RT</option>
                            </select>
                        </div>

                        <div>
                            <label for="color" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                                Warna Poligon <span class="text-rose-500">*</span>
                            </label>
                            <div class="flex items-center space-x-2">
                                <input 
                                    type="color" 
                                    id="color" 
                                    name="color" 
                                    value="{{ old('color', $editingBoundary?->color ?? '#0284c7') }}" 
                                    onchange="updatePolygonColor(this.value)"
                                    class="h-9 w-12 rounded-lg cursor-pointer border border-slate-300 p-0.5 bg-white"
                                >
                                <span id="colorHexText" class="text-xs font-mono text-slate-600">
                                    {{ old('color', $editingBoundary?->color ?? '#0284c7') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="area_hectares" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Luas Wilayah (Hektar)
                        </label>
                        <input 
                            type="number" 
                            step="0.01" 
                            id="area_hectares" 
                            name="area_hectares" 
                            value="{{ old('area_hectares', $editingBoundary?->area_hectares) }}" 
                            placeholder="Otomatis terhitung dari peta..."
                            class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none font-mono bg-white"
                        >
                        <span class="text-[10px] text-slate-400 mt-0.5 block">Dihitung otomatis berdasarkan geometri titik pada peta (dapat disesuaikan).</span>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="coordinates" class="block text-xs font-bold text-slate-700 uppercase">
                                Koordinat Poligon JSON <span class="text-rose-500">*</span>
                            </label>
                            <button type="button" onclick="toggleJsonView()" class="text-[11px] text-blue-600 hover:text-blue-800 font-semibold">
                                <span id="jsonToggleText">Tampilkan Kode JSON</span>
                            </button>
                        </div>
                        <div id="jsonContainer" class="hidden">
                            <textarea 
                                id="coordinates" 
                                name="coordinates" 
                                rows="4" 
                                required
                                placeholder="[[-6.91000, 107.60000], ...]"
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white"
                            >{{ old('coordinates', $editingBoundary ? json_encode($editingBoundary->coordinates) : '') }}</textarea>
                            <p class="text-[10px] text-slate-400 mt-1">Koordinat otomatis terisi saat Anda mengklik atau menggeser titik di peta.</p>
                        </div>
                        @error('coordinates')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Keterangan Wilayah
                        </label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="2" 
                            placeholder="Cakupan RW/RT atau perbatasan..."
                            class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white"
                        >{{ old('description', $editingBoundary?->description) }}</textarea>
                    </div>

                    <div class="space-y-2">
                        <button type="submit" id="btnSubmitForm" class="w-full px-4 py-3 rounded-xl text-xs font-bold {{ $editingBoundary ? 'bg-amber-600 hover:bg-amber-700 text-white' : 'bg-blue-600 hover:bg-blue-700 text-white' }} transition shadow-md">
                            {{ $editingBoundary ? 'Perbarui Batas Wilayah' : 'Simpan Batas Wilayah Baru' }}
                        </button>

                        @if($editingBoundary)
                            <a href="{{ route('admin.boundaries.index') }}" class="w-full inline-block text-center py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 transition">
                                Batalkan Pengeditan
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Batas Wilayah yang Sudah Ada -->
    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="p-5 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 text-sm flex items-center space-x-2">
                <span>📋</span>
                <span>Daftar Batas Wilayah Terdaftar ({{ $boundaries->total() }})</span>
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200 text-[11px]">
                        <th class="py-3 px-5">Nama Wilayah</th>
                        <th class="py-3 px-5">Tingkat</th>
                        <th class="py-3 px-5">Warna</th>
                        <th class="py-3 px-5">Luas (Ha)</th>
                        <th class="py-3 px-5 text-center">Jumlah Titik</th>
                        <th class="py-3 px-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($boundaries as $boundary)
                        <tr class="hover:bg-slate-50/80 transition {{ ($editingBoundary && $editingBoundary->id === $boundary->id) ? 'bg-amber-50/60' : '' }}">
                            <td class="py-3.5 px-5">
                                <span class="font-bold text-slate-800 block text-xs">{{ $boundary->name }}</span>
                                <span class="text-[11px] text-slate-400 line-clamp-1">{{ $boundary->description ?? '-' }}</span>
                            </td>
                            <td class="py-3.5 px-5">
                                <span class="px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-slate-100 text-slate-700">
                                    {{ $boundary->type_label }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5">
                                <div class="flex items-center space-x-2">
                                    <span class="w-4 h-4 rounded-full border border-slate-300 shadow-2xs" style="background-color: {{ $boundary->color }};"></span>
                                    <span class="font-mono text-[11px] text-slate-500">{{ $boundary->color }}</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-5 font-mono font-medium text-slate-700">
                                {{ $boundary->area_hectares ? number_format($boundary->area_hectares, 2) . ' Ha' : '-' }}
                            </td>
                            <td class="py-3.5 px-5 text-center font-mono text-[11px] text-slate-600">
                                {{ is_array($boundary->coordinates) ? count($boundary->coordinates) : 0 }} titik
                            </td>
                            <td class="py-3.5 px-5 text-center">
                                <div class="inline-flex items-center space-x-1.5">
                                    <!-- Tombol Edit -->
                                    <a 
                                        href="{{ route('admin.boundaries.index', ['edit' => $boundary->id]) }}" 
                                        class="text-amber-700 hover:text-amber-900 font-semibold text-[11px] px-2 py-1 rounded bg-amber-50 hover:bg-amber-100 transition border border-amber-200"
                                        title="Edit poligon batas wilayah"
                                    >
                                        ✏️ Edit
                                    </a>

                                    <!-- Tombol Lihat di Peta -->
                                    <button 
                                        type="button" 
                                        onclick="previewBoundary({{ json_encode($boundary->coordinates) }}, '{{ addslashes($boundary->name) }}', '{{ $boundary->color }}')"
                                        class="text-blue-600 hover:text-blue-800 font-semibold text-[11px] px-2 py-1 rounded bg-blue-50 hover:bg-blue-100 transition border border-blue-200"
                                        title="Fokuskan peta ke wilayah ini"
                                    >
                                        👁️ Lihat
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.boundaries.destroy', $boundary) }}" method="POST" onsubmit="return confirm('Hapus batas wilayah ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold text-[11px] px-2 py-1 rounded hover:bg-rose-50 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Belum ada poligon batas wilayah yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($boundaries->hasPages())
            <div class="p-4 bg-white border-t border-slate-100">
                {{ $boundaries->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    let drawMap;
    let currentPoints = [];
    let currentMarkers = [];
    let activePolygon = null;
    let currentColor = '#0284c7';
    const existingBoundaries = @json($allBoundaries ?? $boundaries);
    const editingBoundaryData = @json($editingBoundary);

    document.addEventListener('DOMContentLoaded', function () {
        const colorInput = document.getElementById('color');
        if (colorInput) {
            currentColor = colorInput.value;
        }

        // 1. Inisialisasi Peta
        const defaultCenter = [-6.914744, 107.609810];
        drawMap = L.map('drawMap').setView(defaultCenter, 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(drawMap);

        // 2. Gambar Batas Wilayah Lain yang Sudah Ada sebagai Latar Belakang (Transparan)
        if (existingBoundaries && Array.isArray(existingBoundaries)) {
            existingBoundaries.forEach(b => {
                // Jangan gambar boundary yang sedang diedit sebagai background agar tidak tumpang tindih
                if (editingBoundaryData && b.id === editingBoundaryData.id) {
                    return;
                }

                if (b.coordinates && Array.isArray(b.coordinates) && b.coordinates.length >= 3) {
                    const poly = L.polygon(b.coordinates, {
                        color: b.color || '#94a3b8',
                        weight: 1.5,
                        dashArray: '4, 4',
                        opacity: 0.6,
                        fillColor: b.color || '#94a3b8',
                        fillOpacity: 0.08
                    }).addTo(drawMap);

                    poly.bindPopup(`
                        <div class="p-1">
                            <span class="text-[10px] font-bold uppercase text-slate-400">${b.type}</span>
                            <h4 class="font-bold text-slate-800 text-xs">${b.name}</h4>
                            ${b.area_hectares ? `<p class="text-[11px] text-slate-500">Luas: ${b.area_hectares} Ha</p>` : ''}
                        </div>
                    `);
                }
            });
        }

        // 3. Event Klik pada Peta untuk Menambahkan Titik
        drawMap.on('click', function (e) {
            addPoint([parseFloat(e.latlng.lat.toFixed(6)), parseFloat(e.latlng.lng.toFixed(6))]);
        });

        // 4. Jika sedang mengedit boundary, muat seluruh titik ke studio gambar
        if (editingBoundaryData && editingBoundaryData.coordinates && Array.isArray(editingBoundaryData.coordinates)) {
            editingBoundaryData.coordinates.forEach(pt => addPoint(pt, false));
            redrawPolygon();

            if (currentPoints.length >= 3 && activePolygon) {
                drawMap.fitBounds(activePolygon.getBounds().pad(0.2));
            }
        } else {
            // Jika ada koordinat lama (old input) saat validasi gagal, muat kembali
            const oldCoordsVal = document.getElementById('coordinates').value.trim();
            if (oldCoordsVal) {
                try {
                    const parsed = JSON.parse(oldCoordsVal);
                    if (Array.isArray(parsed)) {
                        parsed.forEach(pt => addPoint(pt, false));
                        redrawPolygon();
                    }
                } catch (err) {}
            }
        }

        setTimeout(() => drawMap.invalidateSize(), 300);
    });

    // Menambah Titik Koordinat
    function addPoint(latlng, autoRedraw = true) {
        currentPoints.push(latlng);

        // Marker bulat di setiap titik sudut yang bisa digeser
        const vertexIcon = L.divIcon({
            className: 'vertex-marker',
            iconSize: [14, 14],
            iconAnchor: [7, 7]
        });

        const marker = L.marker(latlng, { icon: vertexIcon, draggable: true }).addTo(drawMap);
        const pointIndex = currentPoints.length - 1;

        marker.on('drag', function (ev) {
            const pos = ev.target.getLatLng();
            currentPoints[pointIndex] = [parseFloat(pos.lat.toFixed(6)), parseFloat(pos.lng.toFixed(6))];
            redrawPolygon();
        });

        marker.on('dragend', function (ev) {
            const pos = ev.target.getLatLng();
            currentPoints[pointIndex] = [parseFloat(pos.lat.toFixed(6)), parseFloat(pos.lng.toFixed(6))];
            redrawPolygon();
        });

        currentMarkers.push(marker);

        if (autoRedraw) {
            redrawPolygon();
        }
    }

    // Menggambar Ulang Poligon Aktif
    function redrawPolygon() {
        if (activePolygon) {
            drawMap.removeLayer(activePolygon);
            activePolygon = null;
        }

        if (currentPoints.length >= 2) {
            activePolygon = L.polygon(currentPoints, {
                color: currentColor,
                weight: 3,
                opacity: 0.9,
                fillColor: currentColor,
                fillOpacity: 0.25
            }).addTo(drawMap);
        }

        // Update indikator teks & form inputs
        document.getElementById('vertexCounter').innerText = currentPoints.length + ' Titik Ditandai';

        const coordsJson = JSON.stringify(currentPoints);
        document.getElementById('coordinates').value = currentPoints.length > 0 ? coordsJson : '';

        // Hitung estimasi luas poligon jika sudah minimal 3 titik
        if (currentPoints.length >= 3) {
            const calculatedArea = calculatePolygonAreaHectares(currentPoints);
            document.getElementById('areaEstimator').innerText = 'Estimasi Luas: ~' + calculatedArea + ' Ha';
            document.getElementById('area_hectares').value = calculatedArea;
        } else {
            document.getElementById('areaEstimator').innerText = 'Estimasi Luas: 0 Ha';
        }
    }

    // Hapus Titik Terakhir (Undo)
    function undoLastPoint() {
        if (currentPoints.length === 0) return;

        currentPoints.pop();
        const lastMarker = currentMarkers.pop();
        if (lastMarker) {
            drawMap.removeLayer(lastMarker);
        }

        redrawPolygon();
    }

    // Reset Semua Titik
    function resetDrawing() {
        currentPoints = [];
        currentMarkers.forEach(m => drawMap.removeLayer(m));
        currentMarkers = [];

        if (activePolygon) {
            drawMap.removeLayer(activePolygon);
            activePolygon = null;
        }

        redrawPolygon();
    }

    // Update Warna Poligon Real-Time
    function updatePolygonColor(hex) {
        currentColor = hex;
        document.getElementById('colorHexText').innerText = hex;
        if (activePolygon) {
            activePolygon.setStyle({
                color: hex,
                fillColor: hex
            });
        }
    }

    // Toggle Tampilan Input JSON
    function toggleJsonView() {
        const container = document.getElementById('jsonContainer');
        const text = document.getElementById('jsonToggleText');
        if (container.classList.contains('hidden')) {
            container.classList.remove('hidden');
            text.innerText = 'Sembunyikan Kode JSON';
        } else {
            container.classList.add('hidden');
            text.innerText = 'Tampilkan Kode JSON';
        }
    }

    // Preview Batas yang Ada dari Tabel
    function previewBoundary(coords, name, color) {
        if (!coords || !Array.isArray(coords) || coords.length < 3) return;

        const tempPoly = L.polygon(coords, {
            color: color || '#0284c7',
            weight: 3,
            fillColor: color || '#0284c7',
            fillOpacity: 0.35
        }).addTo(drawMap);

        drawMap.fitBounds(tempPoly.getBounds().pad(0.2));
        tempPoly.bindPopup(`<h4 class="font-bold text-xs">${name}</h4>`).openPopup();
    }

    // Perhitungan Luas Poligon dalam Hektar (Geodesic / Spherical Polygon Area)
    function calculatePolygonAreaHectares(coords) {
        if (!coords || coords.length < 3) return 0;
        const earthRadius = 6378137; // radius bumi dalam meter
        let area = 0;
        const len = coords.length;

        for (let i = 0; i < len; i++) {
            const p1 = coords[i];
            const p2 = coords[(i + 1) % len];
            const lat1 = p1[0] * Math.PI / 180;
            const lat2 = p2[0] * Math.PI / 180;
            const lon1 = p1[1] * Math.PI / 180;
            const lon2 = p2[1] * Math.PI / 180;
            area += (lon2 - lon1) * (2 + Math.sin(lat1) + Math.sin(lat2));
        }

        area = Math.abs(area * earthRadius * earthRadius / 2.0);
        return parseFloat((area / 10000).toFixed(2));
    }
</script>
@endsection
