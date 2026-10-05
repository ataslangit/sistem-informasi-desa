@extends('themes.emerald.layouts.app')

@section('title', 'Peta Wilayah & Web GIS Fasilitas Desa - ' . \App\Models\Setting::get('village_name', 'Desa Sukamaju'))

@section('content')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<style>
    .facility-marker-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: transform 0.2s ease, filter 0.2s ease;
    }
    .facility-marker-icon:hover {
        transform: scale(1.18);
        filter: drop-shadow(0 4px 6px rgba(0,0,0,0.3));
        z-index: 1000 !important;
    }
    .leaflet-popup-content-wrapper {
        border-radius: 1rem;
        padding: 0.25rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    }
</style>

<!-- Banner Hero Hijau Zamrud (Jumbotron Peta Web GIS Tema Emerald) -->
<section class="relative px-4 sm:px-6 lg:px-8 pt-6 pb-4">
    <div class="max-w-7xl mx-auto">
        <div class="relative rounded-3xl overflow-hidden shadow-2xl shadow-emerald-950/20 bg-gradient-to-br from-emerald-950 via-emerald-900 to-teal-950 py-12 sm:py-16 px-6 sm:px-12 text-white">
            <!-- Background Landscape Overlay -->
            <div class="absolute inset-0 bg-cover bg-center opacity-15 mix-blend-overlay pointer-events-none" style="background-image: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=1600&q=80');"></div>
            <!-- Radial Glow Ornaments -->
            <div class="absolute -right-10 -bottom-10 w-80 h-80 bg-emerald-400/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-10 -top-10 w-72 h-72 bg-teal-300/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-4xl space-y-4">
                <!-- Breadcrumbs Cerah Kontras Tinggi -->
                <nav class="flex flex-wrap items-center gap-2 text-xs text-emerald-300 font-medium">
                    <a href="/" class="hover:text-white transition flex items-center gap-1">
                        <span>🏡</span>
                        <span>Beranda</span>
                    </a>
                    <span class="text-emerald-500">/</span>
                    <span class="text-white font-semibold">Peta Digital & Wilayah GIS</span>
                </nav>

                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-200 text-xs font-bold backdrop-blur-md">
                    <span>🗺️</span>
                    <span>Sistem Informasi Geografis (Web GIS) Desa Sukamaju</span>
                </div>

                <!-- Judul Halaman Putih Kontras Tinggi -->
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight drop-shadow-sm">
                    Peta Digital & Fasilitas Desa
                </h1>

                <p class="text-sm sm:text-base lg:text-lg text-emerald-100/90 leading-relaxed font-normal max-w-3xl">
                    Eksplorasi batas administratif wilayah, pembagian zonasi dusun/RW, serta persebaran titik fasilitas publik dan infrastruktur desa secara interaktif.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Filter & Map Container -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <!-- Category Filter Bar -->
    <div class="flex items-center space-x-2 overflow-x-auto pb-2 scrollbar-none" id="categoryFilters">
        <button 
            type="button" 
            onclick="filterCategory('all')" 
            id="btn-all"
            class="filter-btn active px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap bg-sky-600 text-white shadow-sm"
        >
            🌐 Semua Fasilitas ({{ $facilities->count() }})
        </button>
        @foreach($categories as $key => $cat)
            @php
                $count = $facilities->where('category', $key)->count();
            @endphp
            @if($count > 0)
                <button 
                    type="button" 
                    onclick="filterCategory('{{ $key }}')" 
                    id="btn-{{ $key }}"
                    class="filter-btn px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap bg-white text-slate-700 hover:bg-slate-100 border border-slate-200"
                >
                    <span>{{ $cat['icon'] }}</span>
                    <span class="ml-1">{{ $cat['label'] }} ({{ $count }})</span>
                </button>
            @endif
        @endforeach
    </div>

    <!-- Map & Sidebar Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Leaflet Map Container -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm relative">
            <div id="villageMap" class="w-full h-[550px] z-10"></div>
            <!-- Legend Overlay -->
            <div class="absolute bottom-4 left-4 z-20 bg-white/95 backdrop-blur-md p-3.5 rounded-2xl border border-slate-200 shadow-lg text-xs space-y-2 hidden sm:block">
                <span class="font-bold text-slate-800 block text-[11px] uppercase tracking-wider">Legenda Batas</span>
                @foreach($boundaries as $boundary)
                    <div class="flex items-center space-x-2">
                        <span class="w-3.5 h-3.5 rounded" style="background-color: {{ $boundary->color }}40; border: 2px solid {{ $boundary->color }};"></span>
                        <span class="text-slate-700 text-[11px] font-medium">{{ $boundary->name }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Directory Fasilitas List -->
        <div class="bg-white rounded-3xl border border-slate-200 p-5 shadow-sm space-y-4 flex flex-col justify-between max-h-[550px]">
            <div>
                <h3 class="font-bold text-slate-800 text-sm flex items-center justify-between pb-3 border-b border-slate-100">
                    <span class="flex items-center space-x-1.5">
                        <span>📍</span>
                        <span>Daftar Fasilitas Desa</span>
                    </span>
                    <span class="text-xs text-slate-400 font-normal" id="visibleCount">{{ $facilities->count() }} titik</span>
                </h3>
                <div class="overflow-y-auto space-y-2.5 mt-3 pr-1 max-h-[440px]" id="facilityList">
                    @forelse($facilities as $facility)
                        <div 
                            onclick="focusFacility({{ $facility->latitude }}, {{ $facility->longitude }}, '{{ addslashes($facility->name) }}')"
                            data-category="{{ $facility->category }}"
                            class="facility-item p-3 rounded-2xl border border-slate-100 hover:border-sky-300 hover:bg-sky-50/50 transition cursor-pointer group flex items-start space-x-3"
                        >
                            <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-lg shrink-0 group-hover:scale-105 transition">
                                {{ $facility->category_meta['icon'] ?? '📍' }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="text-xs font-bold text-slate-800 group-hover:text-sky-700 transition truncate">
                                    {{ $facility->name }}
                                </h4>
                                <p class="text-[11px] text-slate-500 truncate mt-0.5">
                                    {{ $facility->address ?? ($facility->category_meta['label'] ?? ucfirst($facility->category)) }}
                                </p>
                                <span class="inline-block mt-1 text-[10px] font-semibold px-2 py-0.5 rounded-full {{ $facility->condition === 'baik' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                    {{ $facility->condition_label ?? 'Kondisi Baik' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-400">
                            <p class="text-xs">Belum ada titik fasilitas yang tersimpan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    let map;
    let markers = [];
    const facilitiesData = @json($facilities);
    const boundariesData = @json($boundaries);
    const categoriesMap = @json($categories);

    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi Peta
        const defaultCenter = [-6.914744, 107.609810];
        map = L.map('villageMap').setView(defaultCenter, 14);

        // Tambahkan Tile OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(map);

        // Gambar Poligon Batas Wilayah
        boundariesData.forEach(boundary => {
            if (boundary.coordinates && Array.isArray(boundary.coordinates) && boundary.coordinates.length > 0) {
                const polygon = L.polygon(boundary.coordinates, {
                    color: boundary.color || '#0284c7',
                    weight: 2,
                    opacity: 0.85,
                    fillColor: boundary.color || '#0284c7',
                    fillOpacity: 0.15
                }).addTo(map);

                polygon.bindPopup(`
                    <div class="p-2">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">${(boundary.type || 'WILAYAH').toUpperCase()}</span>
                        <h4 class="font-bold text-slate-800 text-sm">${boundary.name}</h4>
                        ${boundary.area_hectares ? `<p class="text-xs text-slate-600 mt-1">Luas: <b>${boundary.area_hectares} Ha</b></p>` : ''}
                        ${boundary.description ? `<p class="text-xs text-slate-500 mt-1">${boundary.description}</p>` : ''}
                    </div>
                `);
            }
        });

        // Tambahkan Markers Fasilitas
        facilitiesData.forEach(item => {
            const meta = item.category_meta || categoriesMap[item.category] || {
                label: item.category,
                icon: '📍',
                color: '#2563eb'
            };
            const condLabel = item.condition_label || (item.condition === 'baik' ? 'Kondisi Baik' : 'Perlu Perbaikan');

            const iconHtml = `
                <div class="facility-marker-icon" style="background-color: white; border: 2.5px solid ${meta.color}; border-radius: 50%; width: 36px; height: 36px; font-size: 17px; box-shadow: 0 4px 10px rgba(0,0,0,0.25);">
                    ${meta.icon}
                </div>
            `;

            const customIcon = L.divIcon({
                html: iconHtml,
                className: '',
                iconSize: [36, 36],
                iconAnchor: [18, 18],
                popupAnchor: [0, -20]
            });

            const marker = L.marker([item.latitude, item.longitude], { icon: customIcon }).addTo(map);

            const popupContent = `
                <div class="p-1 max-w-[240px]">
                    ${item.image_url ? `<img src="${item.image_url}" alt="${item.name}" class="w-full h-28 object-cover rounded-xl mb-2">` : ''}
                    <span class="text-[10px] font-bold uppercase tracking-wider block" style="color: ${meta.color};">
                        ${meta.icon} ${meta.label}
                    </span>
                    <h4 class="font-bold text-slate-800 text-xs mt-0.5 leading-snug">${item.name}</h4>
                    ${item.address ? `<p class="text-[11px] text-slate-500 mt-1">📍 ${item.address}</p>` : ''}
                    ${item.description ? `<p class="text-[11px] text-slate-600 mt-1 line-clamp-2">${item.description}</p>` : ''}
                    <div class="mt-2.5 pt-1.5 border-t border-slate-100 flex items-center justify-between text-[10px]">
                        <span class="text-slate-400">Kondisi:</span>
                        <span class="font-bold ${item.condition === 'baik' ? 'text-emerald-600' : 'text-amber-600'}">${condLabel}</span>
                    </div>
                </div>
            `;

            marker.bindPopup(popupContent);
            marker.category = item.category;
            marker.facilityName = item.name;
            markers.push(marker);
        });

        // Fit bounds agar seluruh titik fasilitas & batas wilayah otomatis terlihat
        if (markers.length > 0) {
            const group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds().pad(0.2));
        }

        // Pastikan ukuran Leaflet terkalkulasi dengan benar setelah load
        setTimeout(() => {
            map.invalidateSize();
        }, 300);
    });

    // Filter Kategori
    function filterCategory(category) {
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.className = 'filter-btn px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap bg-white text-slate-700 hover:bg-slate-100 border border-slate-200';
        });
        const activeBtn = document.getElementById('btn-' + category);
        if (activeBtn) {
            activeBtn.className = 'filter-btn active px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap bg-sky-600 text-white shadow-sm';
        }

        let visibleCount = 0;
        const visibleMarkers = [];

        markers.forEach(marker => {
            if (category === 'all' || marker.category === category) {
                map.addLayer(marker);
                visibleMarkers.push(marker);
                visibleCount++;
            } else {
                map.removeLayer(marker);
            }
        });

        // Filter list di sidebar
        document.querySelectorAll('.facility-item').forEach(item => {
            if (category === 'all' || item.getAttribute('data-category') === category) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });

        const countEl = document.getElementById('visibleCount');
        if (countEl) {
            countEl.innerText = visibleCount + ' titik';
        }

        if (visibleMarkers.length > 0) {
            const group = new L.featureGroup(visibleMarkers);
            map.fitBounds(group.getBounds().pad(0.25));
        }
    }

    // Fokus ke Fasilitas
    function focusFacility(lat, lng, name) {
        map.flyTo([lat, lng], 17, { duration: 1.2 });
        const targetMarker = markers.find(m => m.facilityName === name);
        if (targetMarker) {
            setTimeout(() => targetMarker.openPopup(), 1250);
        }
    }
</script>
@endsection
