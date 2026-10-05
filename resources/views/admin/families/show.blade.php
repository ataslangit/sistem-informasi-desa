@extends('admin.layouts.app')

@section('title', 'Detail Kartu Keluarga: ' . $family->family_card_number)

@section('content')
<div class="space-y-6">
    <!-- Top Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.families.index') }}" class="text-xs text-slate-500 hover:text-slate-800">Kartu Keluarga</a>
                <span class="text-xs text-slate-400">/</span>
                <span class="text-xs font-semibold text-slate-700">Detail KK</span>
            </div>
            <h2 class="text-xl font-bold font-mono text-slate-800 mt-1">NO. KK: {{ $family->family_card_number }}</h2>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.families.pdf', $family) }}" target="_blank" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold bg-rose-600 text-white hover:bg-rose-700 transition shadow-sm space-x-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span>Unduh PDF KK</span>
            </a>
            <a href="{{ route('admin.residents.create', ['family_id' => $family->id, 'from_family' => 1]) }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold bg-emerald-600 text-white hover:bg-emerald-700 transition shadow-sm space-x-1">
                <span>➕</span>
                <span>Tambah Anggota</span>
            </a>
            <a href="{{ route('admin.families.edit', $family) }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold bg-slate-800 text-white hover:bg-slate-700 transition shadow-sm">
                Edit KK
            </a>
        </div>
    </div>

    <!-- KK Information Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Kepala Keluarga</span>
            <div class="mt-2">
                @if($family->headOfFamily)
                    <h3 class="text-base font-bold text-slate-800">{{ $family->headOfFamily->name }}</h3>
                    <p class="text-xs text-slate-500 font-mono mt-0.5">NIK: {{ $family->headOfFamily->nik }}</p>
                @else
                    <span class="text-xs text-amber-600 font-semibold italic">Belum ditentukan</span>
                @endif
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Alamat Wilayah</span>
            <div class="mt-2 text-xs text-slate-700 space-y-1">
                <p class="font-medium">{{ $family->address ?: 'Alamat belum diisi' }}</p>
                <p class="text-slate-500">RT {{ $family->rt }} / RW {{ $family->rw }} &bull; {{ $family->hamlet ?: '-' }}</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Sosial & Ekonomi</span>
            <div class="mt-2 flex flex-wrap gap-2 items-center">
                <span class="px-2.5 py-1 rounded-md text-xs font-semibold capitalize {{ $family->economic_status === 'miskin' || $family->economic_status === 'sangat_miskin' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700' }}">
                    Status: {{ str_replace('_', ' ', $family->economic_status) }}
                </span>
                @if($family->social_assistance_status)
                    <span class="px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-100 text-emerald-800">
                        Bansos: {{ $family->social_assistance_status }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Family Members Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-sm text-slate-800">Daftar Anggota Keluarga</h3>
                <p class="text-xs text-slate-400">Total {{ $family->members->count() }} orang tercatat dalam kartu keluarga ini.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                    <tr>
                        <th class="px-5 py-3">No</th>
                        <th class="px-5 py-3">NIK</th>
                        <th class="px-5 py-3">Nama Lengkap</th>
                        <th class="px-5 py-3">Hubungan</th>
                        <th class="px-5 py-3">Jenis Kelamin</th>
                        <th class="px-5 py-3">TTL / Umur</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($family->members as $index => $member)
                        <tr class="hover:bg-slate-50 transition {{ $member->is_head_of_family ? 'bg-blue-50/40' : '' }}">
                            <td class="px-5 py-3 text-slate-500">{{ $index + 1 }}</td>
                            <td class="px-5 py-3 font-mono font-bold text-slate-800">
                                <a href="{{ route('admin.residents.show', $member) }}" class="text-blue-600 hover:underline">
                                    {{ $member->nik }}
                                </a>
                            </td>
                            <td class="px-5 py-3">
                                <div class="font-semibold text-slate-800 flex items-center space-x-2">
                                    <span>{{ $member->name }}</span>
                                    @if($member->is_head_of_family)
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-600 text-white">Kepala</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-3 text-slate-600 font-medium">
                                {{ $member->family_relationship_status }}
                            </td>
                            <td class="px-5 py-3 text-slate-600">
                                {{ $member->gender_label }}
                            </td>
                            <td class="px-5 py-3 text-slate-600">
                                <div>{{ $member->birth_date ? $member->birth_date->format('d/m/Y') : '-' }}</div>
                                <span class="text-[11px] text-slate-400">({{ $member->age }} th)</span>
                            </td>
                            <td class="px-5 py-3">
                                @if($member->status === 'active')
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-medium bg-emerald-100 text-emerald-800">Aktif</span>
                                @elseif($member->status === 'deceased')
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-medium bg-slate-200 text-slate-800">Meninggal</span>
                                @elseif($member->status === 'moved')
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-medium bg-rose-100 text-rose-800">Pindah</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-medium bg-amber-100 text-amber-800">{{ $member->status }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right space-x-2">
                                <a href="{{ route('admin.residents.show', $member) }}" class="text-blue-600 hover:text-blue-800 font-semibold">Biodata</a>
                                <a href="{{ route('admin.residents.edit', $member) }}" class="text-slate-600 hover:text-slate-800 font-semibold">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-8 text-center text-slate-400">
                                Belum ada anggota keluarga dalam Kartu Keluarga ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
