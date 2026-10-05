@extends('admin.layouts.app')

@section('title', 'Kabar & Berita Desa (CMS)')

@section('content')
<div class="space-y-6">
    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Kabar & Berita Desa</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola artikel, dokumentasi kegiatan, dan pengumuman resmi desa untuk portal publik.</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition space-x-1 border border-slate-300">
                <span>🏷️</span>
                <span>Kategori & Tag</span>
            </a>
            <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm space-x-1">
                <span>✍️</span>
                <span>Tulis Berita Baru</span>
            </a>
        </div>
    </div>

    <!-- Stats Filter Pills -->
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.articles.index') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-medium border transition {{ empty($status) ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
            Semua ({{ $counts['all'] }})
        </a>
        <a href="{{ route('admin.articles.index', ['status' => 'published']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-medium border transition {{ $status === 'published' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
            Tayang ({{ $counts['published'] }})
        </a>
        <a href="{{ route('admin.articles.index', ['status' => 'draft']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-medium border transition {{ $status === 'draft' ? 'bg-amber-600 text-white border-amber-600' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
            Draf ({{ $counts['draft'] }})
        </a>
        <a href="{{ route('admin.articles.index', ['status' => 'archived']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-medium border transition {{ $status === 'archived' ? 'bg-slate-700 text-white border-slate-700' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
            Arsip ({{ $counts['archived'] }})
        </a>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.articles.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            @if($status)
                <input type="hidden" name="status" value="{{ $status }}">
            @endif
            <div class="sm:col-span-2">
                <input 
                    type="text" 
                    name="keyword" 
                    value="{{ $keyword }}" 
                    placeholder="Cari judul berita atau isi konten..." 
                    class="w-full px-4 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
            </div>
            <div>
                <select name="category_id" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-700 transition">
                    Cari
                </button>
                @if($keyword || $categoryId || $status)
                    <a href="{{ route('admin.articles.index') }}" class="px-3 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-semibold hover:bg-slate-200 transition flex items-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200 uppercase">
                    <tr>
                        <th class="px-6 py-4">Judul Artikel</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Penulis</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Dibaca</th>
                        <th class="px-6 py-4">Tanggal Tayang</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($articles as $article)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800 text-sm hover:text-blue-600 transition">
                                    <a href="{{ route('admin.articles.edit', $article) }}">
                                        {{ $article->title }}
                                    </a>
                                </div>
                                <div class="text-slate-400 text-xs mt-0.5 font-mono">
                                    /berita/{{ $article->slug }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($article->categories as $category)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                                            {{ $category->name }}
                                        </span>
                                    @empty
                                        <span class="text-slate-400 italic text-[11px]">-</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-slate-700">{{ $article->author->name ?? 'Aparatur Desa' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($article->status === 'published')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        ● Tayang
                                    </span>
                                @elseif($article->status === 'draft')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        ● Draf
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-300">
                                        ● Arsip
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-slate-700">{{ number_format($article->view_count) }}</span> kali
                            </td>
                            <td class="px-6 py-4">
                                @if($article->published_at)
                                    <span class="text-slate-700">{{ $article->published_at->translatedFormat('d M Y, H:i') }}</span>
                                @else
                                    <span class="text-slate-400 italic">Belum terbit</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    @if($article->status === 'published')
                                        <a href="{{ route('articles.show', $article->slug) }}" target="_blank" class="p-1.5 text-slate-500 hover:text-blue-600 transition" title="Lihat di Portal Publik">
                                            🌐
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.articles.edit', $article) }}" class="p-1.5 text-slate-500 hover:text-amber-600 transition" title="Edit Artikel">
                                        ✏️
                                    </a>
                                    <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel berita ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-500 hover:text-rose-600 transition" title="Hapus Artikel">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                <div class="text-4xl mb-3">📰</div>
                                <p class="text-sm font-semibold text-slate-600">Belum ada artikel berita ditemukan</p>
                                <p class="text-xs text-slate-400 mt-1">Mulai tulis kabar dan kegiatan desa untuk dibagikan kepada warga.</p>
                                <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center px-4 py-2 mt-4 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition">
                                    + Tulis Berita Pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($articles->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
