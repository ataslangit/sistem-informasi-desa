@extends('admin.layouts.app')

@section('title', 'Template Surat Desa')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Manajemen Template Surat</h2>
            <p class="text-xs text-slate-500 mt-1">Konfigurasi jenis surat pelayanan desa, format redaksi, dan placeholder otomatis.</p>
        </div>
        <div>
            <a href="{{ route('admin.letter-templates.create') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm space-x-1">
                <span>➕</span>
                <span>Tambah Template</span>
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-3 px-4">Kode</th>
                        <th class="py-3 px-4">Nama Surat</th>
                        <th class="py-3 px-4">Deskripsi</th>
                        <th class="py-3 px-4 text-center">Permohonan</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse($templates as $tpl)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3 px-4 font-mono font-bold text-blue-600">
                                {{ $tpl->code }}
                            </td>
                            <td class="py-3 px-4 font-semibold text-slate-800">
                                {{ $tpl->name }}
                            </td>
                            <td class="py-3 px-4 text-slate-500 text-[11px] max-w-xs truncate">
                                {{ $tpl->description ?? '-' }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-700">
                                    {{ $tpl->requests_count }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                @if($tpl->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-500">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center whitespace-nowrap space-x-1">
                                <a href="{{ route('admin.letter-templates.preview', $tpl) }}" class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-semibold hover:bg-blue-100 transition space-x-1">
                                    <span>👁️</span>
                                    <span>Pratinjau</span>
                                </a>
                                <a href="{{ route('admin.letter-templates.edit', $tpl) }}" class="inline-flex items-center px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 text-xs font-semibold hover:bg-amber-100 transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.letter-templates.destroy', $tpl) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus template surat ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-2.5 py-1 rounded-lg bg-rose-50 text-rose-700 text-xs font-semibold hover:bg-rose-100 transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">
                                Belum ada template surat yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($templates->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50">
                {{ $templates->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
