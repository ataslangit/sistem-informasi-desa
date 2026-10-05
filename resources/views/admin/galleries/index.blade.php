@extends('admin.layouts.app')

@section('title', 'Manajemen Galeri & Album Foto Desa')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Album Galeri & Dokumentasi Kegiatan Desa</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola album foto dokumentasi pembangunan, kegiatan kemasyarakatan, dan potensi desa.</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('galleries.index') }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition space-x-1.5 border border-slate-300">
                <span>🌐</span>
                <span>Lihat Galeri di Portal</span>
            </a>
        </div>
    </div>

    <!-- Layout: Form Buat Album (1/3) & Grid Album (2/3) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Tambah Album Baru -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4 h-fit">
            <h3 class="font-bold text-slate-800 text-sm flex items-center space-x-2">
                <span>📁</span>
                <span>Buat Album Galeri Baru</span>
            </h3>

            <form action="{{ route('admin.galleries.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="title" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Judul Album / Kegiatan <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        value="{{ old('title') }}" 
                        required 
                        placeholder="Contoh: Kerja Bakti Normalisasi Saluran Irigasi"
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    @error('title')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image_url" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        URL Foto Sampul / Cover <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="url" 
                        id="image_url" 
                        name="image_url" 
                        value="{{ old('image_url') }}" 
                        required 
                        placeholder="https://... URL gambar sampul resolusi tinggi"
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    @error('image_url')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="summary" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Deskripsi / Keterangan Album
                    </label>
                    <textarea 
                        id="summary" 
                        name="summary" 
                        rows="3" 
                        placeholder="Keterangan singkat mengenai album kegiatan..."
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >{{ old('summary') }}</textarea>
                    @error('summary')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full px-4 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
                    Buat Album Galeri
                </button>
            </form>
        </div>

        <!-- Grid Album Galeri -->
        <div class="lg:col-span-2 space-y-4">
            <!-- Search & Filter Bar -->
            <form method="GET" action="{{ route('admin.galleries.index') }}" class="flex items-center space-x-2">
                <input 
                    type="text" 
                    name="keyword" 
                    value="{{ $keyword ?? '' }}" 
                    placeholder="Cari judul album galeri..." 
                    class="flex-1 px-4 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white"
                >
                <button type="submit" class="px-4 py-2 bg-slate-800 text-white rounded-xl text-xs font-semibold hover:bg-slate-900 transition">
                    Cari
                </button>
                @if(!empty($keyword))
                    <a href="{{ route('admin.galleries.index') }}" class="px-3 py-2 bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold hover:bg-slate-300 transition">
                        Reset
                    </a>
                @endif
            </form>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse($galleries as $gallery)
                    @php
                        $photoCount = $gallery->photos_count ?? $gallery->photos->count();
                    @endphp
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <div class="relative h-44 bg-slate-100 overflow-hidden">
                                <img src="{{ $gallery->cover_image }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover">
                                <span class="absolute top-2 right-2 px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-900/80 text-white backdrop-blur-sm border border-white/20">
                                    🖼️ {{ $photoCount }} Foto
                                </span>
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold text-slate-800 text-sm line-clamp-1 mb-1">
                                    {{ $gallery->title }}
                                </h4>
                                <p class="text-xs text-slate-500 line-clamp-2">
                                    {{ $gallery->summary }}
                                </p>
                            </div>
                        </div>
                        <div class="px-4 py-3 border-t border-slate-100 bg-slate-50 flex items-center justify-between text-xs">
                            <a href="{{ route('admin.galleries.show', $gallery) }}" class="inline-flex items-center space-x-1 font-semibold text-blue-600 hover:text-blue-800 transition">
                                <span>Kelola Foto ({{ $photoCount }})</span>
                                <span>&rarr;</span>
                            </a>
                            <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Hapus album ini beserta seluruh foto di dalamnya?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-700 font-semibold" title="Hapus Album">
                                    Hapus Album
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 p-12 text-center text-slate-400 bg-white rounded-2xl border border-slate-200">
                        <div class="text-4xl mb-3">🖼️</div>
                        <p class="text-sm font-semibold text-slate-600">Belum ada album galeri</p>
                        <p class="text-xs text-slate-400 mt-1">Tambahkan album dokumentasi kegiatan desa melalui form di sebelah kiri.</p>
                    </div>
                @endforelse
            </div>

            @if($galleries->hasPages())
                <div class="p-4 bg-white rounded-2xl border border-slate-200">
                    {{ $galleries->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
