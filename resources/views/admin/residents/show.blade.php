@extends('admin.layouts.app')

@section('title', 'Biodata Penduduk: ' . $resident->name)

@section('content')
<div class="space-y-6">
    <!-- Top Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.residents.index') }}" class="text-xs text-slate-500 hover:text-slate-800">Buku Induk</a>
                <span class="text-xs text-slate-400">/</span>
                <span class="text-xs font-semibold text-slate-700">Biodata Penduduk</span>
            </div>
            <h2 class="text-xl font-bold text-slate-800 mt-1">{{ $resident->name }}</h2>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.residents.edit', $resident) }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
                Edit Biodata
            </a>
            <a href="{{ route('admin.residents.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                Kembali
            </a>
        </div>
    </div>

    <!-- Main Biodata Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Col 1: Summary Card -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex flex-col items-center text-center">
            <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-bold flex items-center justify-center text-4xl shadow-md mb-4">
                {{ strtoupper(substr($resident->name, 0, 1)) }}
            </div>
            <h3 class="text-lg font-bold text-slate-800">{{ $resident->name }}</h3>
            <p class="font-mono text-sm text-slate-500 mt-0.5">{{ $resident->nik }}</p>

            <div class="mt-4 flex flex-wrap justify-center gap-2">
                @if($resident->status === 'active')
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">Warga Aktif</span>
                @elseif($resident->status === 'deceased')
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-200 text-slate-800">Meninggal Dunia</span>
                @elseif($resident->status === 'moved')
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">Pindah Keluar</span>
                @else
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">{{ $resident->status }}</span>
                @endif

                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                    {{ $resident->gender_label }} &bull; {{ $resident->age }} Th
                </span>
            </div>

            <div class="w-full mt-6 pt-6 border-t border-slate-100 text-left space-y-3 text-xs">
                <div>
                    <span class="text-slate-400 block">Hubungan dalam Keluarga</span>
                    <span class="font-bold text-slate-800 text-sm">{{ $resident->family_relationship_status }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Pekerjaan</span>
                    <span class="font-semibold text-slate-800">{{ $resident->occupation }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Pendidikan Terakhir</span>
                    <span class="font-semibold text-slate-800">{{ $resident->education_level }}</span>
                </div>
            </div>
        </div>

        <!-- Col 2: Detailed Attributes -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-6">
            <div>
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">
                    Informasi Demografi & Akta
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-3 bg-slate-50 rounded-xl">
                        <span class="text-slate-500 block mb-0.5">Tempat & Tanggal Lahir</span>
                        <span class="font-bold text-slate-800">{{ $resident->formatted_ttl }}</span>
                    </div>

                    <div class="p-3 bg-slate-50 rounded-xl">
                        <span class="text-slate-500 block mb-0.5">Golongan Darah</span>
                        <span class="font-bold text-slate-800">{{ $resident->blood_type ?: '-' }}</span>
                    </div>

                    <div class="p-3 bg-slate-50 rounded-xl">
                        <span class="text-slate-500 block mb-0.5">Agama</span>
                        <span class="font-bold text-slate-800">{{ $resident->religion }}</span>
                    </div>

                    <div class="p-3 bg-slate-50 rounded-xl">
                        <span class="text-slate-500 block mb-0.5">Status Perkawinan</span>
                        <span class="font-bold text-slate-800">{{ $resident->marital_status }}</span>
                    </div>

                    <div class="p-3 bg-slate-50 rounded-xl">
                        <span class="text-slate-500 block mb-0.5">Nama Ayah</span>
                        <span class="font-bold text-slate-800">{{ $resident->father_name ?: '-' }}</span>
                    </div>

                    <div class="p-3 bg-slate-50 rounded-xl">
                        <span class="text-slate-500 block mb-0.5">Nama Ibu</span>
                        <span class="font-bold text-slate-800">{{ $resident->mother_name ?: '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Family Card Link -->
            <div>
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 border-b border-slate-100 pb-2">
                    Kartu Keluarga (KK)
                </h4>
                @if($resident->family)
                    <div class="p-4 bg-blue-50/50 rounded-xl border border-blue-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <span class="text-xs text-blue-600 font-semibold block">Nomor KK:</span>
                            <span class="font-mono text-base font-bold text-slate-800">{{ $resident->family->family_card_number }}</span>
                            <p class="text-xs text-slate-500 mt-1">{{ $resident->family->full_address }}</p>
                        </div>
                        <a href="{{ route('admin.families.show', $resident->family) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl text-center transition">
                            Lihat Kartu Keluarga →
                        </a>
                    </div>
                @else
                    <div class="p-4 bg-slate-50 rounded-xl text-xs text-slate-500">
                        Penduduk ini belum terdaftar di dalam Kartu Keluarga mana pun.
                    </div>
                @endif
            </div>

            <!-- Mutation History -->
            <div>
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 border-b border-slate-100 pb-2">
                    Riwayat Mutasi Kependudukan
                </h4>
                @if($resident->mutations->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($resident->mutations as $mut)
                            <div class="p-3.5 rounded-xl border border-slate-100 bg-slate-50 flex items-start justify-between text-xs">
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $mut->type_badge_class }}">
                                            {{ $mut->type_label }}
                                        </span>
                                        <span class="text-slate-400 font-mono">{{ $mut->date ? $mut->date->translatedFormat('d F Y') : '-' }}</span>
                                    </div>
                                    <p class="font-medium text-slate-700 mt-1">{{ $mut->reason }}</p>
                                    @if($mut->notes)
                                        <p class="text-slate-500 mt-0.5 text-[11px]">{{ $mut->notes }}</p>
                                    @endif
                                </div>
                                @if($mut->reference_number)
                                    <span class="text-[11px] text-slate-400 font-mono">No: {{ $mut->reference_number }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-slate-400 italic">Belum ada catatan mutasi untuk warga ini.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
