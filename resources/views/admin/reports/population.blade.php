@extends('admin.layouts.app')

@section('title', 'Laporan Statistik Kependudukan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Laporan Statistik & Agregat Penduduk</h2>
            <p class="text-xs text-slate-500 mt-1">Data statistik kependudukan agregat desa yang terupdate secara *real-time*.</p>
        </div>
        <button onclick="window.print()" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold bg-slate-800 text-white hover:bg-slate-700 transition shadow-sm space-x-2">
            <span>🖨️</span>
            <span>Cetak Laporan</span>
        </button>
    </div>

    <!-- KPI Summary Row -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Total Penduduk</span>
            <div class="text-3xl font-extrabold text-slate-800 mt-1">{{ number_format($summary['total_residents']) }}</div>
            <span class="text-[11px] text-emerald-600 font-medium">Jiwa Terdaftar</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Kepala Keluarga</span>
            <div class="text-3xl font-extrabold text-slate-800 mt-1">{{ number_format($summary['total_families']) }}</div>
            <span class="text-[11px] text-blue-600 font-medium">Kartu Keluarga (KK)</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Laki-laki</span>
            <div class="text-3xl font-extrabold text-sky-600 mt-1">{{ number_format($summary['total_males']) }}</div>
            <span class="text-[11px] text-slate-400">
                {{ $summary['total_residents'] > 0 ? round(($summary['total_males'] / $summary['total_residents']) * 100, 1) : 0 }}% dari Total
            </span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Perempuan</span>
            <div class="text-3xl font-extrabold text-pink-600 mt-1">{{ number_format($summary['total_females']) }}</div>
            <span class="text-[11px] text-slate-400">
                {{ $summary['total_residents'] > 0 ? round(($summary['total_females'] / $summary['total_residents']) * 100, 1) : 0 }}% dari Total
            </span>
        </div>
    </div>

    <!-- Monthly Mutation Summary -->
    <div class="bg-gradient-to-r from-slate-900 to-slate-800 rounded-2xl p-5 text-white shadow-sm">
        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-300 mb-3">Mutasi Kependudukan Bulan Ini</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
            <div class="p-3 bg-white/5 rounded-xl border border-white/10">
                <span class="text-2xl font-bold text-emerald-400 block">{{ $summary['births_this_month'] }}</span>
                <span class="text-[11px] text-slate-300">Kelahiran Baru</span>
            </div>
            <div class="p-3 bg-white/5 rounded-xl border border-white/10">
                <span class="text-2xl font-bold text-slate-300 block">{{ $summary['deaths_this_month'] }}</span>
                <span class="text-[11px] text-slate-300">Kematian</span>
            </div>
            <div class="p-3 bg-white/5 rounded-xl border border-white/10">
                <span class="text-2xl font-bold text-blue-400 block">{{ $summary['moved_in_this_month'] }}</span>
                <span class="text-[11px] text-slate-300">Pindah Datang</span>
            </div>
            <div class="p-3 bg-white/5 rounded-xl border border-white/10">
                <span class="text-2xl font-bold text-rose-400 block">{{ $summary['moved_out_this_month'] }}</span>
                <span class="text-[11px] text-slate-300">Pindah Keluar</span>
            </div>
        </div>
    </div>

    <!-- Breakdown Grid: Umur & Pendidikan -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Kelompok Umur -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center justify-between">
                <span>Distribusi Kelompok Umur</span>
                <span class="text-xs text-slate-400 font-normal">Kategori Usia</span>
            </h3>
            <div class="space-y-3">
                @foreach($ageGroups as $group => $total)
                    @php
                        $percentage = $summary['total_residents'] > 0 ? round(($total / $summary['total_residents']) * 100, 1) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-xs font-semibold text-slate-700 mb-1">
                            <span>{{ $group }}</span>
                            <span>{{ $total }} Jiwa ({{ $percentage }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tingkat Pendidikan -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center justify-between">
                <span>Distribusi Tingkat Pendidikan</span>
                <span class="text-xs text-slate-400 font-normal">Pendidikan Terakhir</span>
            </h3>
            <div class="space-y-3">
                @foreach($educations as $edu => $total)
                    @php
                        $percentage = $summary['total_residents'] > 0 ? round(($total / $summary['total_residents']) * 100, 1) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-xs font-semibold text-slate-700 mb-1">
                            <span>{{ $edu }}</span>
                            <span>{{ $total }} Jiwa ({{ $percentage }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-emerald-500 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Breakdown Grid: Wilayah Dusun & Pekerjaan -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Penduduk per Dusun -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-sm font-bold text-slate-800 mb-4">Sebaran per Wilayah (Dusun)</h3>
            <div class="space-y-3 text-xs">
                @forelse($hamlets as $hamlet => $total)
                    <div class="flex justify-between items-center p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="font-semibold text-slate-700">{{ $hamlet }}</span>
                        <span class="px-2 py-0.5 rounded-md bg-blue-100 text-blue-800 font-bold">{{ $total }} Jiwa</span>
                    </div>
                @empty
                    <p class="text-slate-400 italic">Belum ada data dusun.</p>
                @endforelse
            </div>
        </div>

        <!-- Status Ekonomi Keluarga -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-sm font-bold text-slate-800 mb-4">Klasifikasi Ekonomi Keluarga</h3>
            <div class="space-y-3 text-xs">
                @forelse($economicStatuses as $status => $total)
                    <div class="flex justify-between items-center p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="font-semibold text-slate-700 capitalize">{{ str_replace('_', ' ', $status) }}</span>
                        <span class="px-2 py-0.5 rounded-md bg-amber-100 text-amber-800 font-bold">{{ $total }} KK</span>
                    </div>
                @empty
                    <p class="text-slate-400 italic">Belum ada data status ekonomi.</p>
                @endforelse
            </div>
        </div>

        <!-- Pekerjaan Terbanyak -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-sm font-bold text-slate-800 mb-4">Pekerjaan Terbanyak (Top 5)</h3>
            <div class="space-y-2.5 text-xs">
                @php $topOccupations = array_slice($occupations, 0, 5, true); @endphp
                @forelse($topOccupations as $job => $total)
                    <div class="flex justify-between items-center py-1.5 border-b border-slate-100 last:border-0">
                        <span class="text-slate-700">{{ $job }}</span>
                        <span class="font-bold text-slate-800">{{ $total }} Jiwa</span>
                    </div>
                @empty
                    <p class="text-slate-400 italic">Belum ada data pekerjaan.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
