@extends('admin.layouts.app')

@section('title', 'Tulis Artikel Berita Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Tulis Kabar Desa Baru</h2>
            <p class="text-xs text-slate-500 mt-1">Publikasikan informasi, agenda kegiatan, atau laporan transparansi desa ke portal publik.</p>
        </div>
        <a href="{{ route('admin.articles.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition">
            &larr; Kembali
        </a>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.articles.store') }}" method="POST" class="space-y-6">
        @csrf

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
                    value="{{ old('title') }}" 
                    required 
                    placeholder="Contoh: Musyawarah Perencanaan Pembangunan Desa Tahun Anggaran 2026"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
                @error('title')
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
                    placeholder="Penjelasan singkat sekitar 1-2 kalimat yang menarik minat warga pembaca..."
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >{{ old('summary') }}</textarea>
                <p class="text-[11px] text-slate-400 mt-1">Jika dikosongkan, ringkasan akan dipotong secara otomatis dari paragraf pertama isi berita.</p>
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
                    rows="12" 
                    required 
                    placeholder="Tuliskan berita lengkap mengenai kegiatan, narasumber, kronologi, serta hasil pertemuan..."
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs leading-relaxed focus:ring-2 focus:ring-blue-500 focus:outline-none font-mono"
                >{{ old('body') }}</textarea>
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
                                {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}
                                class="rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                            >
                            <span>{{ $category->name }}</span>
                        </label>
                    @empty
                        <p class="text-xs text-slate-400 col-span-4">Belum ada kategori. Tambahkan di menu Kategori & Tag.</p>
                    @endforelse
                </div>
                @error('categories')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gambar Sampul (URL) -->
            <div>
                <label for="cover_image" class="block text-xs font-bold text-slate-700 uppercase mb-2">
                    URL Gambar Sampul (Cover Image)
                </label>
                <input 
                    type="url" 
                    id="cover_image" 
                    name="cover_image" 
                    value="{{ old('cover_image') }}" 
                    placeholder="https://images.unsplash.com/... atau URL gambar dokumentasi"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
                <p class="text-[11px] text-slate-400 mt-1">Tautan URL gambar untuk ditampilkan sebagai banner utama pada berita.</p>
                @error('cover_image')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status Publikasi & Jadwal -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-slate-200">
                <div>
                    <label for="status" class="block text-xs font-bold text-slate-700 uppercase mb-2">
                        Status Publikasi <span class="text-rose-500">*</span>
                    </label>
                    <select id="status" name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="published" {{ old('status', 'published') === 'published' ? 'selected' : '' }}>Langsung Terbitkan (Tayang)</option>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Simpan Sebagai Draf</option>
                        <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Arsipkan</option>
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
                        value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}" 
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
                            value="{{ old('seo_title') }}" 
                            placeholder="Judul untuk Google Search..."
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>
                    <div>
                        <label for="seo_description" class="block text-xs font-medium text-slate-600 mb-1">Deskripsi SEO</label>
                        <input 
                            type="text" 
                            id="seo_description" 
                            name="seo_description" 
                            value="{{ old('seo_description') }}" 
                            placeholder="Deskripsi singkat mesin pencari..."
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
                Simpan & Publikasikan
            </button>
        </div>
    </form>
</div>
@endsection
