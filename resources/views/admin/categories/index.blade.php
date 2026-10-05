@extends('admin.layouts.app')

@section('title', 'Kategori & Taksonomi CMS')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Kategori & Taksonomi Konten</h2>
            <p class="text-xs text-slate-500 mt-1">Klasifikasikan artikel berita dan informasi publik desa agar mudah ditemukan oleh warga.</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.articles.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition">
                &larr; Kembali ke Berita
            </a>
        </div>
    </div>

    <!-- Layout Grid: Form Tambah (1/3) & List (2/3) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Tambah Baru -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4 h-fit">
            <h3 class="font-bold text-slate-800 text-sm flex items-center space-x-2">
                <span>➕</span>
                <span>Tambah Kategori / Tag Baru</span>
            </h3>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Nama <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        placeholder="Contoh: Pembangunan, Bantuan Sosial"
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    @error('name')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="type" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Jenis Taksonomi <span class="text-rose-500">*</span>
                    </label>
                    <select id="type" name="type" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="category" {{ old('type') === 'category' ? 'selected' : '' }}>Kategori Berita</option>
                        <option value="tag" {{ old('type') === 'tag' ? 'selected' : '' }}>Tag Kata Kunci</option>
                    </select>
                    @error('type')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Slug URL (Opsional)
                    </label>
                    <input 
                        type="text" 
                        id="slug" 
                        name="slug" 
                        value="{{ old('slug') }}" 
                        placeholder="Otomatis dari nama jika kosong"
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    @error('slug')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full px-4 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
                    Simpan Taksonomi
                </button>
            </form>
        </div>

        <!-- Tabel List Kategori & Tag -->
        <div class="lg:col-span-2 space-y-4">
            <!-- Filter Pills -->
            <div class="flex space-x-2">
                <a href="{{ route('admin.categories.index') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-medium border transition {{ empty($type) ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                    Semua ({{ $counts['all'] }})
                </a>
                <a href="{{ route('admin.categories.index', ['type' => 'category']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-medium border transition {{ $type === 'category' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                    Kategori ({{ $counts['categories'] }})
                </a>
                <a href="{{ route('admin.categories.index', ['type' => 'tag']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-medium border transition {{ $type === 'tag' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                    Tag ({{ $counts['tags'] }})
                </a>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200 uppercase">
                            <tr>
                                <th class="px-6 py-4">Nama</th>
                                <th class="px-6 py-4">Slug</th>
                                <th class="px-6 py-4">Tipe</th>
                                <th class="px-6 py-4 text-center">Jumlah Konten</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($categories as $category)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-6 py-4 font-bold text-slate-800">
                                        {{ $category->name }}
                                    </td>
                                    <td class="px-6 py-4 font-mono text-slate-500 text-[11px]">
                                        {{ $category->slug }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($category->type === 'category')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                                                📁 Kategori
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                                🏷️ Tag
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                            {{ $category->contents_count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus taksonomi ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 transition" title="Hapus">
                                                🗑️
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                                        Belum ada kategori atau tag terdaftar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($categories->hasPages())
                    <div class="p-4 border-t border-slate-200">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
