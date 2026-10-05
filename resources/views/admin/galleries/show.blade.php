@extends('admin.layouts.app')

@section('title', 'Kelola Foto Album - ' . $gallery->title)

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb & Top Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.galleries.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition" title="Kembali">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-bold text-slate-800">Kelola Foto: {{ $gallery->title }}</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola foto-foto dokumentasi yang termasuk ke dalam album ini.</p>
            </div>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('galleries.show', $gallery->slug) }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-semibold bg-sky-50 text-sky-700 hover:bg-sky-100 transition space-x-1.5 border border-sky-200">
                <span>🌐</span>
                <span>Lihat di Portal Publik</span>
            </a>
        </div>
    </div>

    <!-- Album Detail Banner -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-5 items-start md:items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="w-20 h-20 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                <img src="{{ $gallery->cover_image }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover">
            </div>
            <div>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-blue-50 text-blue-700 mb-1">
                    📁 Album Galeri
                </span>
                <h3 class="font-bold text-slate-800 text-base leading-snug">{{ $gallery->title }}</h3>
                <p class="text-xs text-slate-500 line-clamp-1 mt-0.5">{{ $gallery->summary }}</p>
                <div class="mt-2 flex items-center space-x-3 text-xs text-slate-400">
                    <span>📅 {{ optional($gallery->published_at)->translatedFormat('d F Y') }}</span>
                    <span>•</span>
                    <span>🖼️ {{ $gallery->photos->count() }} Foto tersimpan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Layout Form Tambah Foto (1/3) & Grid Foto (2/3) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Upload Foto ke Album -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4 h-fit">
            <h3 class="font-bold text-slate-800 text-sm flex items-center space-x-2">
                <span>➕</span>
                <span>Tambah Foto ke Album</span>
            </h3>

            <form action="{{ route('admin.galleries.photos.store', $gallery) }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="image_url" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        URL Gambar Foto <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="url" 
                        id="image_url" 
                        name="image_url" 
                        value="{{ old('image_url') }}" 
                        required 
                        placeholder="https://... URL gambar resolusi tinggi"
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    @error('image_url')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="caption" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Keterangan / Caption Foto
                    </label>
                    <textarea 
                        id="caption" 
                        name="caption" 
                        rows="3" 
                        placeholder="Keterangan momen atau dokumentasi foto ini..."
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >{{ old('caption') }}</textarea>
                    @error('caption')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full px-4 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
                    Tambahkan Foto ke Album
                </button>
            </form>
        </div>

        <!-- Daftar Foto dalam Album -->
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-slate-200">
                <h3 class="text-sm font-bold text-slate-800">
                    Foto dalam Album ({{ $gallery->photos->count() }})
                </h3>
            </div>

            @if($gallery->photos->isEmpty())
                <div class="p-12 text-center text-slate-400 bg-white rounded-2xl border border-slate-200">
                    <div class="text-4xl mb-3">📸</div>
                    <p class="text-sm font-semibold text-slate-600">Belum ada foto dalam album ini</p>
                    <p class="text-xs text-slate-400 mt-1">Tambahkan foto pertama melalui formulir di sebelah kiri.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($gallery->photos as $photo)
                        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm flex flex-col justify-between group">
                            <div>
                                <div class="relative aspect-video bg-slate-100 overflow-hidden">
                                    <img src="{{ $photo->image_url }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover">
                                    <span class="absolute top-2 left-2 px-2 py-0.5 rounded text-[10px] font-semibold bg-black/60 text-white">
                                        #{{ $photo->sort_order }}
                                    </span>
                                </div>
                                <div class="p-3">
                                    <p class="text-xs text-slate-700 line-clamp-2 leading-relaxed">
                                        {{ $photo->caption ?? '-' }}
                                    </p>
                                </div>
                            </div>
                            <div class="p-3 pt-0 flex justify-end">
                                <form action="{{ route('admin.galleries.photos.destroy', [$gallery, $photo]) }}" method="POST" onsubmit="return confirm('Hapus foto ini dari album?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-800 transition">
                                        Hapus Foto
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
