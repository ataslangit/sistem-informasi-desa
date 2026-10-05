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
        transition: transform 0.1s ease;
    }
    .vertex-marker:hover {
        transform: scale(1.3);
        border-color: #0369a1;
    }
    .vertex-marker:active {
        cursor: grabbing;
    }
    .midpoint-marker {
        background-color: rgba(255, 255, 255, 0.95);
        border: 2px dashed #0284c7;
        border-radius: 50%;
        width: 12px;
        height: 12px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.25);
        cursor: pointer;
        opacity: 0.85;
        transition: all 0.15s ease-in-out;
    }
    .midpoint-marker:hover {
        opacity: 1;
        background-color: #38bdf8;
        border-color: #0284c7;
        border-style: solid;
        transform: scale(1.4);
        box-shadow: 0 2px 8px rgba(2, 132, 199, 0.5);
    }
    .midpoint-marker:active {
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
                    <div class="absolute bottom-3 left-3 z-20 bg-white/95 backdrop-blur-md px-3.5 py-2 rounded-xl border border-slate-200 text-[11px] text-slate-700 shadow-sm max-w-sm pointer-events-none">
                        <div class="font-bold text-slate-800 flex items-center space-x-1.5 mb-1">
                            <span>💡</span>
                            <span>Panduan Titik & Garis Poligon:</span>
                        </div>
                        <ul class="text-[10px] text-slate-600 space-y-0.5 list-disc list-inside">
                            <li><b>Tambah Titik:</b> Klik area kosong di peta untuk menambah titik di akhir.</li>
                            <li><b>Sisipkan Titik di Tengah:</b> Klik atau geser titik putus-putus (<span class="inline-block w-2.5 h-2.5 rounded-full border border-dashed border-sky-600 bg-white align-middle"></span>) di antara 2 titik sudut.</li>
                            <li><b>Ubah Titik:</b> Geser titik sudut bulat (<span class="inline-block w-2.5 h-2.5 rounded-full border-2 border-sky-600 bg-white align-middle"></span>) ke posisi baru.</li>
                            <li><b>Hapus Titik:</b> Klik titik sudut lalu pilih hapus, atau klik kanan.</li>
                        </ul>
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
    let midpointMarkers = [];
    let activePolygon = null;
    let currentColor = '#0284c7';
    const existingBoundaries = @json($allBoundaries ?? $boundaries);
    const editingBoundaryData = @json($editingBoundary);

    document.addEventListener('DOMContentLoaded', function () {
        const colorInput = document.getElementById('color');
        if (colorInput) {
            currentColor = colorInput.value;
        }

        // 1. Inisialisasi Peta Leaflet
        const defaultCenter = [-6.914744, 107.609810];
        drawMap = L.map('drawMap').setView(defaultCenter, 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(drawMap);

        // 2. Gambar Batas Wilayah Lain sebagai Latar Belakang Transparan
        if (existingBoundaries && Array.isArray(existingBoundaries)) {
            existingBoundaries.forEach(b => {
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

        // 3. Event Klik pada Peta untuk Menambahkan Titik di Akhir
        drawMap.on('click', function (e) {
            addPoint([parseFloat(e.latlng.lat.toFixed(6)), parseFloat(e.latlng.lng.toFixed(6))]);
        });

        // 4. Jika sedang mengedit boundary, muat seluruh titik ke studio gambar
        if (editingBoundaryData && editingBoundaryData.coordinates && Array.isArray(editingBoundaryData.coordinates)) {
            currentPoints = editingBoundaryData.coordinates.map(pt => [parseFloat(pt[0]), parseFloat(pt[1])]);
            renderAll();

            if (currentPoints.length >= 3 && activePolygon) {
                drawMap.fitBounds(activePolygon.getBounds().pad(0.2));
            }
        } else {
            // Jika ada koordinat lama saat validasi gagal, muat kembali
            const oldCoordsVal = document.getElementById('coordinates').value.trim();
            if (oldCoordsVal) {
                try {
                    const parsed = JSON.parse(oldCoordsVal);
                    if (Array.isArray(parsed)) {
                        currentPoints = parsed.map(pt => [parseFloat(pt[0]), parseFloat(pt[1])]);
                        renderAll();
                    }
                } catch (err) {}
            }
        }

        // Sinkronisasi jika textarea koordinat diedit manual oleh pengguna
        const coordTextarea = document.getElementById('coordinates');
        if (coordTextarea) {
            coordTextarea.addEventListener('change', function () {
                try {
                    const parsed = JSON.parse(this.value.trim());
                    if (Array.isArray(parsed)) {
                        currentPoints = parsed.map(pt => [parseFloat(pt[0]), parseFloat(pt[1])]);
                        renderAll();
                        if (currentPoints.length >= 3 && activePolygon) {
                            drawMap.fitBounds(activePolygon.getBounds().pad(0.2));
                        }
                    }
                } catch (e) {}
            });
        }

        setTimeout(() => drawMap.invalidateSize(), 300);
    });

    // Bersihkan seluruh marker vertex & midpoint
    function clearMarkers() {
        currentMarkers.forEach(m => drawMap.removeLayer(m));
        currentMarkers = [];
        midpointMarkers.forEach(m => drawMap.removeLayer(m));
        midpointMarkers = [];
    }

    // Render ulang seluruh canvas poligon dan marker
    function renderAll() {
        clearMarkers();
        redrawPolygon();
        renderVertexMarkers();
        renderMidpointMarkers();
        updateInputsAndStats();
    }

    // Gambar ulang layer poligon
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

            // Mencegah klik di area poligon memicu drawMap.on('click')
            activePolygon.on('click', function (e) {
                L.DomEvent.stopPropagation(e);
            });
        }
    }

    // Render titik sudut utama (vertex) yang dapat digeser
    function renderVertexMarkers() {
        const vertexIcon = L.divIcon({
            className: 'vertex-marker',
            iconSize: [14, 14],
            iconAnchor: [7, 7]
        });

        currentPoints.forEach((pt, index) => {
            const marker = L.marker(pt, { icon: vertexIcon, draggable: true }).addTo(drawMap);
            marker._pointIndex = index;

            marker.bindTooltip(`Titik #${index + 1}`, {
                direction: 'top',
                offset: [0, -8],
                className: 'text-[11px] font-bold'
            });

            // Popup tombol hapus titik
            const popupDiv = document.createElement('div');
            popupDiv.className = 'text-center p-1.5 space-y-1';
            popupDiv.innerHTML = `
                <div class="font-bold text-xs text-slate-800">Titik Sudut #${index + 1}</div>
                <div class="font-mono text-[10px] text-slate-500 mb-2">${pt[0].toFixed(6)}, ${pt[1].toFixed(6)}</div>
                <button type="button" class="w-full px-2.5 py-1 rounded bg-rose-50 text-rose-600 hover:bg-rose-100 font-semibold text-[11px] border border-rose-200 transition" onclick="removePointAtIndex(${index})">
                    🗑️ Hapus Titik Ini
                </button>
            `;
            marker.bindPopup(popupDiv);

            // Drag titik sudut
            marker.on('drag', function (ev) {
                const pos = ev.target.getLatLng();
                currentPoints[index] = [parseFloat(pos.lat.toFixed(6)), parseFloat(pos.lng.toFixed(6))];
                if (activePolygon) {
                    activePolygon.setLatLngs(currentPoints);
                }
                updateInputsAndStats();
            });

            marker.on('dragend', function () {
                renderAll();
            });

            // Klik kanan untuk hapus cepat
            marker.on('contextmenu', function (ev) {
                L.DomEvent.stopPropagation(ev);
                if (confirm(`Hapus titik sudut #${index + 1}?`)) {
                    removePointAtIndex(index);
                }
            });

            currentMarkers.push(marker);
        });
    }

    // Render titik sisip tengah (midpoint) di setiap segmen garis
    function renderMidpointMarkers() {
        if (currentPoints.length < 2) return;

        const midpointIcon = L.divIcon({
            className: 'midpoint-marker',
            iconSize: [12, 12],
            iconAnchor: [6, 6]
        });

        const numPoints = currentPoints.length;
        // Jika 3 titik atau lebih, buat midpoint juga untuk garis penutup poligon (titik akhir ke titik awal)
        const numSegments = numPoints >= 3 ? numPoints : numPoints - 1;

        for (let i = 0; i < numSegments; i++) {
            const p1 = currentPoints[i];
            const p2 = currentPoints[(i + 1) % numPoints];

            const midLat = (p1[0] + p2[0]) / 2;
            const midLng = (p1[1] + p2[1]) / 2;
            const insertIndex = i + 1; // posisi index yang disisipkan

            const midMarker = L.marker([midLat, midLng], {
                icon: midpointIcon,
                draggable: true
            }).addTo(drawMap);

            midMarker.bindTooltip('➕ Klik atau geser untuk menyisipkan titik', {
                direction: 'top',
                offset: [0, -7],
                className: 'text-[10px]'
            });

            let isDragging = false;

            midMarker.on('dragstart', function (ev) {
                isDragging = true;
                const latlng = ev.target.getLatLng();
                currentPoints.splice(insertIndex, 0, [parseFloat(latlng.lat.toFixed(6)), parseFloat(latlng.lng.toFixed(6))]);
            });

            midMarker.on('drag', function (ev) {
                const latlng = ev.target.getLatLng();
                currentPoints[insertIndex] = [parseFloat(latlng.lat.toFixed(6)), parseFloat(latlng.lng.toFixed(6))];
                if (activePolygon) {
                    activePolygon.setLatLngs(currentPoints);
                }
                updateInputsAndStats();
            });

            midMarker.on('dragend', function () {
                setTimeout(() => { isDragging = false; }, 50);
                renderAll();
            });

            midMarker.on('click', function (ev) {
                L.DomEvent.stopPropagation(ev);
                if (isDragging) return;
                currentPoints.splice(insertIndex, 0, [parseFloat(midLat.toFixed(6)), parseFloat(midLng.toFixed(6))]);
                renderAll();
            });

            midpointMarkers.push(midMarker);
        }
    }

    // Update Input Form dan Estimasi Luas
    function updateInputsAndStats() {
        document.getElementById('vertexCounter').innerText = currentPoints.length + ' Titik Ditandai';

        const coordsJson = JSON.stringify(currentPoints);
        document.getElementById('coordinates').value = currentPoints.length > 0 ? coordsJson : '';

        if (currentPoints.length >= 3) {
            const calculatedArea = calculatePolygonAreaHectares(currentPoints);
            document.getElementById('areaEstimator').innerText = 'Estimasi Luas: ~' + calculatedArea + ' Ha';
            document.getElementById('area_hectares').value = calculatedArea;
        } else {
            document.getElementById('areaEstimator').innerText = 'Estimasi Luas: 0 Ha';
        }
    }

    // Tambah Titik di Akhir
    function addPoint(latlng) {
        currentPoints.push(latlng);
        renderAll();
    }

    // Hapus Titik Tertentu (dapat dipanggil dari popup tombol hapus)
    window.removePointAtIndex = function (index) {
        if (index >= 0 && index < currentPoints.length) {
            currentPoints.splice(index, 1);
            renderAll();
        }
    };

    // Hapus Titik Terakhir (Undo)
    function undoLastPoint() {
        if (currentPoints.length === 0) return;
        currentPoints.pop();
        renderAll();
    }

    // Reset Semua Titik
    function resetDrawing() {
        currentPoints = [];
        renderAll();
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
