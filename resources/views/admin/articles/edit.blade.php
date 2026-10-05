@extends('admin.layouts.app')

@section('title', 'Edit Artikel Berita')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Edit Kabar Desa</h2>
            <p class="text-xs text-slate-500 mt-1">Perbarui konten artikel berita, dokumentasi, atau status publikasi.</p>
        </div>
        <div class="flex items-center space-x-2">
            @if($article->status === 'published')
                <a href="{{ route('articles.show', $article->slug) }}" target="_blank" class="px-3.5 py-2 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition border border-emerald-200">
                    🌐 Tinjau di Portal
                </a>
            @endif
            <a href="{{ route('admin.articles.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition">
                &larr; Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-6">
            <!-- Judul -->
            <div>
                <label for="title" class="block text-xs font-bold text-slate-700 uppercase mb-2">
                    Judul Artikel <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title', $article->title) }}" 
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
                        /berita/
                    </span>
                    <input 
                        type="text" 
                        id="slug" 
                        name="slug" 
                        value="{{ old('slug', $article->slug) }}" 
                        required 
                        class="flex-1 min-w-0 block w-full px-4 py-2.5 rounded-none rounded-r-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>
                @error('slug')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ringkasan / Summary -->
            <div>
                <label for="summary" class="block text-xs font-bold text-slate-700 uppercase mb-2">
                    Ringkasan Singkat (Lead Paragraph)
                </label>
                <textarea 
                    id="summary" 
                    name="summary" 
                    rows="2" 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >{{ old('summary', $article->summary) }}</textarea>
                @error('summary')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Isi Berita -->
            <div>
                <label for="body" class="block text-xs font-bold text-slate-700 uppercase mb-2">
                    Isi Konten Berita <span class="text-rose-500">*</span>
                </label>
                <textarea 
                    id="body" 
                    name="body" 
                    rows="14" 
                    required 
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs leading-relaxed focus:ring-2 focus:ring-blue-500 focus:outline-none font-mono"
                >{{ old('body', $article->body) }}</textarea>
                @error('body')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">
                    Kategori Berita
                </label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 bg-slate-50 p-4 rounded-xl border border-slate-200">
                    @forelse($categories as $category)
                        <label class="inline-flex items-center space-x-2 text-xs text-slate-700 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="categories[]" 
                                value="{{ $category->id }}"
                                {{ (is_array(old('categories')) && in_array($category->id, old('categories'))) || in_array($category->id, $selectedCategories) ? 'checked' : '' }}
                                class="rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                            >
                            <span>{{ $category->name }}</span>
                        </label>
                    @empty
                        <p class="text-xs text-slate-400 col-span-4">Belum ada kategori.</p>
                    @endforelse
                </div>
                @error('categories')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gambar Sampul (Dual-Mode: Upload Berkas / URL) -->
            <div x-data="{ 
                mode: 'upload', 
                previewUrl: null,
                onFileSelected(e) {
                    const file = e.target.files[0];
                    if (file) {
                        this.previewUrl = URL.createObjectURL(file);
                    }
                }
            }" class="space-y-2">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-bold text-slate-700 uppercase">
                        Gambar Sampul (Cover Image)
                    </label>
                    <div class="flex items-center bg-slate-100 p-0.5 rounded-lg text-[11px] font-medium">
                        <button type="button" @click="mode = 'upload'" :class="mode === 'upload' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500'" class="px-2.5 py-1 rounded-md transition">📁 Unggah Berkas Baru</button>
                        <button type="button" @click="mode = 'url'" :class="mode === 'url' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500'" class="px-2.5 py-1 rounded-md transition">🌐 Tautan URL</button>
                    </div>
                </div>

                @if($article->cover_image)
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex items-center space-x-3">
                        <img src="{{ $article->cover_image }}" alt="Current cover" class="h-16 w-24 rounded-lg object-cover border border-slate-200 shadow-sm shrink-0">
                        <div class="text-xs text-slate-500">
                            <span class="font-semibold text-slate-700 block">Gambar Sampul Saat Ini</span>
                            <span class="text-[11px] text-slate-400 truncate block max-w-md">{{ $article->cover_image }}</span>
                        </div>
                    </div>
                @endif

                <!-- Mode 1: File Upload -->
                <div x-show="mode === 'upload'" class="space-y-2">
                    <input 
                        type="file" 
                        name="cover_image_file" 
                        id="cover_image_file" 
                        accept="image/*"
                        @change="onFileSelected($event)"
                        class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                    >
                    <p class="text-[11px] text-slate-400">Pilih berkas baru jika ingin mengganti gambar sampul (Maks. 3MB).</p>
                    <template x-if="previewUrl">
                        <div class="mt-2">
                            <p class="text-[11px] font-semibold text-emerald-600 mb-1">Pratinjau Berkas Baru:</p>
                            <img :src="previewUrl" alt="Pratinjau Foto Baru" class="h-28 w-auto rounded-xl object-cover border border-slate-200 shadow-sm">
                        </div>
                    </template>
                    @error('cover_image_file') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Mode 2: External URL -->
                <div x-show="mode === 'url'" class="space-y-1" style="display: none;">
                    <input 
                        type="url" 
                        id="cover_image" 
                        name="cover_image" 
                        value="{{ old('cover_image', $article->cover_image) }}" 
                        placeholder="https://... URL gambar baru"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    <p class="text-[11px] text-slate-400">Tautan URL gambar eksternal.</p>
                    @error('cover_image') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Status Publikasi & Jadwal -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-slate-200">
                <div>
                    <label for="status" class="block text-xs font-bold text-slate-700 uppercase mb-2">
                        Status Publikasi <span class="text-rose-500">*</span>
                    </label>
                    <select id="status" name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="published" {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>Langsung Terbitkan (Tayang)</option>
                        <option value="draft" {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}>Simpan Sebagai Draf</option>
                        <option value="archived" {{ old('status', $article->status) === 'archived' ? 'selected' : '' }}>Arsipkan</option>
                    </select>
                    @error('status')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="published_at" class="block text-xs font-bold text-slate-700 uppercase mb-2">
                        Waktu Tayang
                    </label>
                    <input 
                        type="datetime-local" 
                        id="published_at" 
                        name="published_at" 
                        value="{{ old('published_at', optional($article->published_at)->format('Y-m-d\TH:i')) }}" 
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    @error('published_at')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- SEO Meta (Opsional) -->
            <div class="pt-4 border-t border-slate-200 space-y-4">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Optimasi Mesin Pencari (SEO) - Opsional</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="seo_title" class="block text-xs font-medium text-slate-600 mb-1">Judul SEO</label>
                        <input 
                            type="text" 
                            id="seo_title" 
                            name="seo_title" 
                            value="{{ old('seo_title', $article->meta['seo_title'] ?? '') }}" 
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>
                    <div>
                        <label for="seo_description" class="block text-xs font-medium text-slate-600 mb-1">Deskripsi SEO</label>
                        <input 
                            type="text" 
                            id="seo_description" 
                            name="seo_description" 
                            value="{{ old('seo_description', $article->meta['seo_description'] ?? '') }}" 
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('admin.articles.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
                Perbarui Artikel
            </button>
        </div>
    </form>
</div>
@endsection
