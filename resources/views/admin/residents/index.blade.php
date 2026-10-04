@extends('admin.layouts.app')

@section('title', 'Buku Induk Kependudukan')

@section('content')
<div class="space-y-6">
    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Buku Induk Penduduk</h2>
            <p class="text-xs text-slate-500 mt-1">Daftar lengkap seluruh penduduk desa berdasarkan NIK 16 digit dan biodata resmi.</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.mutations.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-slate-800 text-white hover:bg-slate-700 transition shadow-sm space-x-1">
                <span>🔄</span>
                <span>Catat Mutasi</span>
            </a>
            <a href="{{ route('admin.residents.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm space-x-1">
                <span>➕</span>
                <span>Tambah Penduduk</span>
            </a>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.residents.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div class="sm:col-span-2">
                <input 
                    type="text" 
                    name="keyword" 
                    value="{{ $keyword }}" 
                    placeholder="Cari NIK (16 digit) atau Nama Penduduk..." 
                    class="w-full px-4 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
            </div>
            <div>
                <select name="gender" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="">Semua Jenis Kelamin</option>
                    <option value="L" {{ $gender === 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                    <option value="P" {{ $gender === 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                </select>
            </div>
            <div class="flex space-x-2">
                <select name="status" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="">Semua Status</option>
                    <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="moved" {{ $status === 'moved' ? 'selected' : '' }}>Pindah</option>
                    <option value="deceased" {{ $status === 'deceased' ? 'selected' : '' }}>Meninggal</option>
                    <option value="temporary" {{ $status === 'temporary' ? 'selected' : '' }}>Sementara</option>
                </select>
                <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-700 transition">
                    Cari
                </button>
                @if($keyword || $gender || ($status && $status !== 'active'))
                    <a href="{{ route('admin.residents.index') }}" class="px-3 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-semibold hover:bg-slate-200 transition flex items-center">
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
                        <th class="px-5 py-3.5">NIK & Nama</th>
                        <th class="px-5 py-3.5">No. KK</th>
                        <th class="px-5 py-3.5">JK / Umur</th>
                        <th class="px-5 py-3.5">Hubungan</th>
                        <th class="px-5 py-3.5">Pekerjaan</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($residents as $index => $resident)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-4 text-slate-500">{{ $residents->firstItem() + $index }}</td>
                            <td class="px-5 py-4">
                                <a href="{{ route('admin.residents.show', $resident) }}" class="font-bold text-slate-800 hover:text-blue-600 block">
                                    {{ $resident->name }}
                                </a>
                                <span class="font-mono text-slate-400 text-[11px]">NIK: {{ $resident->nik }}</span>
                            </td>
                            <td class="px-5 py-4">
                                @if($resident->family)
                                    <a href="{{ route('admin.families.show', $resident->family) }}" class="font-mono text-blue-600 hover:underline">
                                        {{ $resident->family->family_card_number }}
                                    </a>
                                    <div class="text-[10px] text-slate-400">RT {{ $resident->family->rt }} / RW {{ $resident->family->rw }}</div>
                                @else
                                    <span class="text-slate-400 italic">Tanpa KK</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-slate-600">
                                <div>{{ $resident->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                                <span class="text-[11px] text-slate-400">{{ $resident->age }} Tahun</span>
                            </td>
                            <td class="px-5 py-4 text-slate-600 font-medium">
                                {{ $resident->family_relationship_status }}
                            </td>
                            <td class="px-5 py-4 text-slate-600">
                                {{ $resident->occupation }}
                            </td>
                            <td class="px-5 py-4">
                                @if($resident->status === 'active')
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-emerald-100 text-emerald-800">Aktif</span>
                                @elseif($resident->status === 'deceased')
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-slate-100 text-slate-800">Meninggal</span>
                                @elseif($resident->status === 'moved')
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-rose-100 text-rose-800">Pindah</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-amber-100 text-amber-800">{{ $resident->status }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right space-x-2">
                                <a href="{{ route('admin.residents.show', $resident) }}" class="text-blue-600 hover:text-blue-800 font-semibold">Detail</a>
                                <a href="{{ route('admin.residents.edit', $resident) }}" class="text-slate-600 hover:text-slate-800 font-semibold">Edit</a>
                                <form action="{{ route('admin.residents.destroy', $resident) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus penduduk ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-8 text-center text-slate-400">
                                Belum ada data penduduk ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($residents->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $residents->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
