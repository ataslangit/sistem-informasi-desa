@extends('admin.layouts.app')

@section('title', 'Dokumen Publik PPID (DIP Desa)')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Daftar Informasi Publik (DIP) & Repositori Dokumen</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola dokumen berkala desa (RPJMDes, RKPDes, LPPD, LKPPD, dll) sesuai UU KIP No. 14/2008.</p>
        </div>
        <a href="{{ route('admin.ppid-documents.create') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs shadow-sm transition space-x-1.5">
            <span>➕</span>
            <span>Unggah Dokumen Publik</span>
        </a>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.ppid-documents.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div class="sm:col-span-2">
                <input 
                    type="text" 
                    name="keyword" 
                    value="{{ $keyword }}" 
                    placeholder="Cari judul dokumen..." 
                    class="w-full px-4 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
            </div>
            <div>
                <select name="category" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                    <option value="">Semua Kategori KIP</option>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ $category === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-700 transition">
                    Filter
                </button>
                @if($keyword || $category || $documentType || $year)
                    <a href="{{ route('admin.ppid-documents.index') }}" class="px-3 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-semibold hover:bg-slate-200 transition flex items-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Documents -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                    <tr>
                        <th class="px-5 py-3.5">Judul Dokumen</th>
                        <th class="px-5 py-3.5">Kategori / Tipe</th>
                        <th class="px-5 py-3.5">Tahun</th>
                        <th class="px-5 py-3.5">Ukuran / Unduhan</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($documents as $doc)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-4">
                                <span class="font-bold text-slate-800 block">{{ $doc->title }}</span>
                                <span class="text-[11px] text-slate-400 font-mono">{{ $doc->slug }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                    {{ $doc->document_type }}
                                </span>
                                <div class="text-[11px] text-slate-500 mt-0.5">{{ $doc->category_label }}</div>
                            </td>
                            <td class="px-5 py-4 text-slate-700 font-semibold">
                                {{ $doc->year ?? '-' }}
                            </td>
                            <td class="px-5 py-4 text-slate-500">
                                <div>{{ $doc->formatted_file_size }}</div>
                                <div class="text-[10px] text-slate-400">{{ $doc->download_count }} kali diunduh</div>
                            </td>
                            <td class="px-5 py-4">
                                @if($doc->is_published)
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Terbit
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                        Draf
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right whitespace-nowrap space-x-2">
                                <a href="{{ route('public.ppid.documents.download', $doc) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                    Unduh
                                </a>
                                <a href="{{ route('admin.ppid-documents.edit', $doc) }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                                    Edit
                                </a>
                                <form action="{{ route('admin.ppid-documents.destroy', $doc) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus dokumen ini dari repositori PPID?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-400">
                                Belum ada dokumen publik yang tersimpan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $documents->links() }}
        </div>
    </div>
</div>
@endsection
