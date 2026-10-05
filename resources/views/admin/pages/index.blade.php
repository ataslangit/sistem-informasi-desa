@extends('admin.layouts.app')

@section('title', 'Halaman Statis Desa (CMS)')

@section('content')
<div class="space-y-6">
    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Halaman Statis Desa</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola laman informasi permanen seperti Profil Desa, Visi & Misi, Struktur Organisasi, dan Sejarah Desa.</p>
        </div>
        <div>
            <a href="{{ route('admin.pages.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm space-x-1">
                <span>➕</span>
                <span>Tambah Halaman Baru</span>
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200 uppercase">
                    <tr>
                        <th class="px-6 py-4">Urutan</th>
                        <th class="px-6 py-4">Judul Halaman</th>
                        <th class="px-6 py-4">Rute Publik</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Dibaca</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pages as $page)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4 font-mono font-semibold text-slate-400">
                                #{{ $page->sort_order }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800 text-sm hover:text-blue-600 transition">
                                    <a href="{{ route('admin.pages.edit', $page) }}">
                                        {{ $page->title }}
                                    </a>
                                </div>
                                <div class="text-slate-400 text-xs mt-0.5">
                                    {{ Str::limit($page->summary, 80) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono text-slate-600 text-xs">
                                /halaman/{{ $page->slug }}
                            </td>
                            <td class="px-6 py-4">
                                @if($page->status === 'published')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        ● Tayang
                                    </span>
                                @elseif($page->status === 'draft')
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
                                <span class="font-semibold text-slate-700">{{ number_format($page->view_count) }}</span> kali
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    @if($page->status === 'published')
                                        <a href="{{ route('pages.show', $page->slug) }}" target="_blank" class="p-1.5 text-slate-500 hover:text-blue-600 transition" title="Lihat di Portal Publik">
                                            🌐
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.pages.edit', $page) }}" class="p-1.5 text-slate-500 hover:text-amber-600 transition" title="Edit Halaman">
                                        ✏️
                                    </a>
                                    <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus halaman statis ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-500 hover:text-rose-600 transition" title="Hapus">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <div class="text-4xl mb-3">📄</div>
                                <p class="text-sm font-semibold text-slate-600">Belum ada halaman statis</p>
                                <p class="text-xs text-slate-400 mt-1">Buat profil desa atau informasi publik tetap untuk masyarakat.</p>
                                <a href="{{ route('admin.pages.create') }}" class="inline-flex items-center px-4 py-2 mt-4 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition">
                                    + Buat Halaman Pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pages->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $pages->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
