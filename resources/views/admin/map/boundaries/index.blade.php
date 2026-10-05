@extends('admin.layouts.app')

@section('title', 'Manajemen Batas Wilayah Administratif Desa')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Batas Wilayah Administratif Desa</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola poligon koordinat spasial batas terluar desa, batas dusun, RW, dan RT.</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('map.index') }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition space-x-1.5 border border-slate-300">
                <span>🗺️</span>
                <span>Lihat Peta Web GIS</span>
            </a>
        </div>
    </div>

    <!-- Layout Form Tambah Batas (1/3) & Daftar Batas (2/3) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Tambah Batas -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4 h-fit">
            <h3 class="font-bold text-slate-800 text-sm flex items-center space-x-2">
                <span>➕</span>
                <span>Tambah Poligon Wilayah</span>
            </h3>

            <form action="{{ route('admin.boundaries.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Nama Wilayah / Batas <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        placeholder="Contoh: Wilayah Dusun Sukamaju 1"
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
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
                            <option value="dusun" {{ old('type') === 'dusun' ? 'selected' : '' }}>Dusun</option>
                            <option value="village" {{ old('type') === 'village' ? 'selected' : '' }}>Batas Desa</option>
                            <option value="rw" {{ old('type') === 'rw' ? 'selected' : '' }}>RW</option>
                            <option value="rt" {{ old('type') === 'rt' ? 'selected' : '' }}>RT</option>
                        </select>
                    </div>

                    <div>
                        <label for="color" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Warna Garis <span class="text-rose-500">*</span>
                        </label>
                        <div class="flex items-center space-x-2">
                            <input 
                                type="color" 
                                id="color" 
                                name="color" 
                                value="{{ old('color', '#0284c7') }}" 
                                class="h-9 w-12 rounded-lg cursor-pointer border border-slate-300 p-0.5"
                            >
                        </div>
                    </div>
                </div>

                <div>
                    <label for="area_hectares" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Perkiraan Luas (Hektar)
                    </label>
                    <input 
                        type="number" 
                        step="0.01" 
                        id="area_hectares" 
                        name="area_hectares" 
                        value="{{ old('area_hectares') }}" 
                        placeholder="Contoh: 125.50"
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none font-mono"
                    >
                </div>

                <div>
                    <label for="coordinates" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Koordinat Poligon JSON <span class="text-rose-500">*</span>
                    </label>
                    <textarea 
                        id="coordinates" 
                        name="coordinates" 
                        rows="5" 
                        required
                        placeholder='[[-6.91000, 107.60000], [-6.90800, 107.62000], [-6.92000, 107.61500], [-6.91000, 107.60000]]'
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >{{ old('coordinates') }}</textarea>
                    <p class="text-[10px] text-slate-400 mt-1">Array JSON berisi titik [[lat, lng], [lat, lng], ...].</p>
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
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="w-full px-4 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
                    Simpan Batas Wilayah
                </button>
            </form>
        </div>

        <!-- Tabel Daftar Batas Wilayah -->
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="p-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                    <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">
                        Daftar Poligon Batas Wilayah ({{ $boundaries->total() }})
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200 text-[11px]">
                                <th class="py-3 px-4">Nama Wilayah</th>
                                <th class="py-3 px-4">Tingkat</th>
                                <th class="py-3 px-4">Warna</th>
                                <th class="py-3 px-4">Luas</th>
                                <th class="py-3 px-4 text-center">Titik Koordinat</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($boundaries as $boundary)
                                <tr class="hover:bg-slate-50">
                                    <td class="py-3 px-4">
                                        <span class="font-bold text-slate-800 block">{{ $boundary->name }}</span>
                                        <span class="text-[11px] text-slate-400 line-clamp-1">{{ $boundary->description ?? '-' }}</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700">
                                            {{ $boundary->type_label }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center space-x-1.5">
                                            <span class="w-4 h-4 rounded-full border border-slate-300 shadow-xs" style="background-color: {{ $boundary->color }};"></span>
                                            <span class="font-mono text-[11px] text-slate-500">{{ $boundary->color }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 font-mono">
                                        {{ $boundary->area_hectares ? $boundary->area_hectares . ' Ha' : '-' }}
                                    </td>
                                    <td class="py-3 px-4 text-center font-mono text-[11px] text-slate-600">
                                        {{ is_array($boundary->coordinates) ? count($boundary->coordinates) : 0 }} titik
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <form action="{{ route('admin.boundaries.destroy', $boundary) }}" method="POST" onsubmit="return confirm('Hapus batas wilayah ini?');" class="inline">
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
                                    <td colspan="6" class="py-8 text-center text-slate-400">Belum ada poligon batas wilayah yang terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($boundaries->hasPages())
                <div class="p-4 bg-white rounded-2xl border border-slate-200">
                    {{ $boundaries->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
