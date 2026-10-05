@extends('admin.layouts.app')

@section('title', 'Data Kartu Keluarga')

@section('content')
<div class="space-y-6">
    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Daftar Kartu Keluarga (KK)</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola data kepala keluarga, nomor KK, dan anggota keluarga desa.</p>
        </div>
        <a href="{{ route('admin.families.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm space-x-2">
            <span>➕</span>
            <span>Tambah KK Baru</span>
        </a>
    </div>

    @if(!empty($scopedRt))
    <!-- Banner Segmentasi Akses RT (UU PDP) -->
    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center justify-between text-xs text-emerald-900">
        <div class="flex items-center space-x-3">
            <span class="text-xl">🛡️</span>
            <div>
                <span class="font-bold">Segmentasi Akses Wilayah RT {{ $scopedRt }} {{ $scopedRw ? '/ RW ' . $scopedRw : '' }} Aktif</span>
                <p class="text-[11px] text-emerald-700 mt-0.5">
                    Sesuai asas <i>Need-to-Know</i> Pelindungan Data Pribadi (UU PDP No. 27/2022), data Kartu Keluarga dibatasi khusus untuk wilayah RT Anda.
                </p>
            </div>
        </div>
        <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-200 text-emerald-800">
            Terproteksi PDP
        </span>
    </div>
    @endif


    <!-- Filter & Search -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.families.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="sm:col-span-2">
                <input 
                    type="text" 
                    name="keyword" 
                    value="{{ $keyword }}" 
                    placeholder="Cari Nomor KK (16 digit) atau Nama Kepala Keluarga..." 
                    class="w-full px-4 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
            </div>
            <div class="flex space-x-2">
                <select name="hamlet" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="">Semua Dusun</option>
                    @foreach($hamlets as $h)
                        <option value="{{ $h }}" {{ $hamlet === $h ? 'selected' : '' }}>{{ $h }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-700 transition">
                    Cari
                </button>
                @if($keyword || $hamlet)
                    <a href="{{ route('admin.families.index') }}" class="px-3 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-semibold hover:bg-slate-200 transition flex items-center">
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
                        <th class="px-5 py-3.5">Nomor KK</th>
                        <th class="px-5 py-3.5">Kepala Keluarga</th>
                        <th class="px-5 py-3.5">Alamat & Dusun</th>
                        <th class="px-5 py-3.5 text-center">Anggota Aktif</th>
                        <th class="px-5 py-3.5">Status Ekonomi</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($families as $index => $family)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-4 text-slate-500">{{ $families->firstItem() + $index }}</td>
                            <td class="px-5 py-4 font-mono font-bold text-slate-800">
                                <a href="{{ route('admin.families.show', $family) }}" class="text-blue-600 hover:underline">
                                    {{ $family->family_card_number }}
                                </a>
                            </td>
                            <td class="px-5 py-4">
                                @if($family->headOfFamily)
                                    <div class="font-semibold text-slate-800">{{ $family->headOfFamily->name }}</div>
                                    <div class="text-[11px] text-slate-400 font-mono">NIK: {{ $family->headOfFamily->nik }}</div>
                                @else
                                    <span class="text-amber-600 italic">Belum ditentukan</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-slate-600">
                                <div>RT {{ $family->rt }} / RW {{ $family->rw }}</div>
                                <div class="text-[11px] text-slate-400">{{ $family->hamlet ?: '-' }}</div>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">
                                    {{ $family->activeMembers->count() }} Jiwa
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="capitalize px-2 py-0.5 rounded text-[11px] font-semibold {{ $family->economic_status === 'miskin' || $family->economic_status === 'sangat_miskin' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700' }}">
                                    {{ str_replace('_', ' ', $family->economic_status) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right space-x-2">
                                <a href="{{ route('admin.families.show', $family) }}" class="text-blue-600 hover:text-blue-800 font-semibold">Detail</a>
                                <a href="{{ route('admin.families.edit', $family) }}" class="text-slate-600 hover:text-slate-800 font-semibold">Edit</a>
                                <form action="{{ route('admin.families.destroy', $family) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus KK ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-slate-400">
                                Belum ada data Kartu Keluarga ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($families->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $families->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
