@extends('admin.layouts.app')

@section('title', 'Tambah Halaman Statis Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Tambah Halaman Statis Baru</h2>
            <p class="text-xs text-slate-500 mt-1">Buat halaman profil desa, visi & misi, atau informasi statis lainnya.</p>
        </div>
        <a href="{{ route('admin.pages.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition">
            &larr; Kembali
        </a>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.pages.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-6">
            <!-- Judul Halaman -->
            <div>
                <label for="title" class="block text-xs font-bold text-slate-700 uppercase mb-2">
                    Judul Halaman <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title') }}" 
                    required 
                    placeholder="Contoh: Profil & Sejarah Desa"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
                @error('title')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug URL -->
            <div>
                <label for="slug" class="block text-xs font-bold text-slate-700 uppercase mb-2">
                    Slug URL (Opsional)
                </label>
                <div class="flex rounded-xl shadow-sm">
                    <span class="inline-flex items-center px-3.5 py-2.5 rounded-l-xl border border-r-0 border-slate-300 bg-slate-50 text-slate-500 text-xs font-mono whitespace-nowrap select-none flex-shrink-0">
                        /halaman/
                    </span>
                    <input 
                        type="text" 
                        id="slug" 
                        name="slug" 
                        value="{{ old('slug') }}" 
                        placeholder="profil-desa (otomatis jika dikosongkan)"
                        class="flex-1 min-w-0 block w-full px-4 py-2.5 rounded-none rounded-r-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>
                @error('slug')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ringkasan -->
            <div>
                <label for="summary" class="block text-xs font-bold text-slate-700 uppercase mb-2">
                    Ringkasan Singkat
                </label>
                <textarea 
                    id="summary" 
                    name="summary" 
                    rows="2" 
                    placeholder="Deskripsi singkat halaman..."
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >{{ old('summary') }}</textarea>
                @error('summary')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konten Halaman -->
            <div>
                <label for="body" class="block text-xs font-bold text-slate-700 uppercase mb-2">
                    Konten Lengkap Halaman <span class="text-rose-500">*</span>
                </label>
                <textarea 
                    id="body" 
                    name="body" 
                    rows="14" 
                    required 
                    placeholder="Tuliskan isi informasi, narasi sejarah, atau rincian struktural secara rinci..."
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs leading-relaxed focus:ring-2 focus:ring-blue-500 focus:outline-none font-mono"
                >{{ old('body') }}</textarea>
                @error('body')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Urutan & Status -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-slate-200">
                <div>
                    <label for="sort_order" class="block text-xs font-bold text-slate-700 uppercase mb-2">
                        Nomor Urutan Tampilan
                    </label>
                    <input 
                        type="number" 
                        id="sort_order" 
                        name="sort_order" 
                        value="{{ old('sort_order', 0) }}" 
                        min="0"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    @error('sort_order')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-xs font-bold text-slate-700 uppercase mb-2">
                        Status Halaman <span class="text-rose-500">*</span>
                    </label>
                    <select id="status" name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="published" {{ old('status', 'published') === 'published' ? 'selected' : '' }}>Langsung Terbitkan (Tayang)</option>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Simpan Sebagai Draf</option>
                    </select>
                    @error('status')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Gambar Sampul -->
            <div>
                <label for="cover_image" class="block text-xs font-bold text-slate-700 uppercase mb-2">
                    URL Gambar Sampul / Banner
                </label>
                <input 
                    type="url" 
                    id="cover_image" 
                    name="cover_image" 
                    value="{{ old('cover_image') }}" 
                    placeholder="https://... URL banner untuk header halaman"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
                @error('cover_image')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('admin.pages.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
                Simpan Halaman
            </button>
        </div>
    </form>
</div>
@endsection
