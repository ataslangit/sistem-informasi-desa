@extends('admin.layouts.app')

@section('title', 'Edit Halaman Statis')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Edit Halaman Statis</h2>
            <p class="text-xs text-slate-500 mt-1">Perbarui isi konten halaman informasi resmi desa.</p>
        </div>
        <div class="flex items-center space-x-2">
            @if($page->status === 'published')
                <a href="{{ route('pages.show', $page->slug) }}" target="_blank" class="px-3.5 py-2 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition border border-emerald-200">
                    🌐 Tinjau di Portal
                </a>
            @endif
            <a href="{{ route('admin.pages.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition">
                &larr; Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.pages.update', $page) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

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
                    value="{{ old('title', $page->title) }}" 
                    required 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
                @error('title')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug URL -->
            <div>
                <label for="slug" class="block text-xs font-bold text-slate-700 uppercase mb-2">
                    Slug URL Halaman <span class="text-rose-500">*</span>
                </label>
                <div class="flex rounded-xl shadow-sm">
                    <span class="inline-flex items-center px-3.5 py-2.5 rounded-l-xl border border-r-0 border-slate-300 bg-slate-50 text-slate-500 text-xs font-mono whitespace-nowrap select-none flex-shrink-0">
                        /halaman/
                    </span>
                    <input 
                        type="text" 
                        id="slug" 
                        name="slug" 
                        value="{{ old('slug', $page->slug) }}" 
                        required 
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
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >{{ old('summary', $page->summary) }}</textarea>
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
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs leading-relaxed focus:ring-2 focus:ring-blue-500 focus:outline-none font-mono"
                >{{ old('body', $page->body) }}</textarea>
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
                        value="{{ old('sort_order', $page->sort_order) }}" 
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
                        <option value="published" {{ old('status', $page->status) === 'published' ? 'selected' : '' }}>Langsung Terbitkan (Tayang)</option>
                        <option value="draft" {{ old('status', $page->status) === 'draft' ? 'selected' : '' }}>Simpan Sebagai Draf</option>
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
                    value="{{ old('cover_image', $page->cover_image) }}" 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
                @if($page->cover_image)
                    <div class="mt-2">
                        <img src="{{ $page->cover_image }}" alt="Preview banner" class="h-28 w-auto rounded-xl object-cover border border-slate-200 shadow-sm">
                    </div>
                @endif
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
                Perbarui Halaman
            </button>
        </div>
    </form>
</div>
@endsection
