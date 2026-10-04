@extends('admin.layouts.app')

@section('title', 'Riwayat Mutasi Penduduk')

@section('content')
<div class="space-y-6">
    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Riwayat Mutasi Penduduk</h2>
            <p class="text-xs text-slate-500 mt-1">Log pencatatan peristiwa kependudukan (Kelahiran, Kematian, Pindah Datang, dan Pindah Keluar).</p>
        </div>
        <a href="{{ route('admin.mutations.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm space-x-1">
            <span>➕</span>
            <span>Catat Mutasi Baru</span>
        </a>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.mutations.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="sm:col-span-2">
                <input 
                    type="text" 
                    name="keyword" 
                    value="{{ $keyword }}" 
                    placeholder="Cari NIK atau Nama Penduduk..." 
                    class="w-full px-4 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
            </div>
            <div class="flex space-x-2">
                <select name="type" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="">Semua Jenis Mutasi</option>
                    <option value="birth" {{ $type === 'birth' ? 'selected' : '' }}>Kelahiran (Lahir)</option>
                    <option value="death" {{ $type === 'death' ? 'selected' : '' }}>Kematian (Meninggal)</option>
                    <option value="moved_out" {{ $type === 'moved_out' ? 'selected' : '' }}>Pindah Keluar</option>
                    <option value="moved_in" {{ $type === 'moved_in' ? 'selected' : '' }}>Pindah Datang</option>
                </select>
                <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-700 transition">
                    Filter
                </button>
                @if($keyword || $type)
                    <a href="{{ route('admin.mutations.index') }}" class="px-3 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-semibold hover:bg-slate-200 transition flex items-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table List -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                    <tr>
                        <th class="px-5 py-3.5">No</th>
                        <th class="px-5 py-3.5">Tanggal</th>
                        <th class="px-5 py-3.5">Jenis Mutasi</th>
                        <th class="px-5 py-3.5">Nama Penduduk & NIK</th>
                        <th class="px-5 py-3.5">Keterangan / Alasan</th>
                        <th class="px-5 py-3.5">No. Berkas</th>
                        <th class="px-5 py-3.5">Petugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($mutations as $index => $mut)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-4 text-slate-500">{{ $mutations->firstItem() + $index }}</td>
                            <td class="px-5 py-4 font-mono text-slate-700">
                                {{ $mut->date ? $mut->date->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold {{ $mut->type_badge_class }}">
                                    {{ $mut->type_label }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                @if($mut->resident)
                                    <a href="{{ route('admin.residents.show', $mut->resident) }}" class="font-bold text-slate-800 hover:text-blue-600 block">
                                        {{ $mut->resident->name }}
                                    </a>
                                    <span class="font-mono text-slate-400 text-[11px]">{{ $mut->resident->nik }}</span>
                                @else
                                    <span class="text-slate-400 italic">Data Terhapus</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-slate-700">
                                <div>{{ $mut->reason }}</div>
                                @if($mut->notes)
                                    <span class="text-slate-400 text-[11px] block">{{ $mut->notes }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-slate-500 font-mono">
                                {{ $mut->reference_number ?: '-' }}
                            </td>
                            <td class="px-5 py-4 text-slate-500">
                                {{ $mut->creator ? $mut->creator->name : 'Sistem' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-slate-400">
                                Belum ada riwayat mutasi kependudukan yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($mutations->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $mutations->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
