@extends('admin.layouts.app')

@section('title', 'Manajemen Transparansi APBDes')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Transparansi APBDes & Keuangan Desa</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola data Anggaran Pendapatan dan Belanja Desa (APBDes) per tahun anggaran untuk transparansi publik.</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('budgets.index') }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition space-x-1.5 border border-slate-300">
                <span>🌐</span>
                <span>Lihat APBDes di Portal</span>
            </a>
        </div>
    </div>

    <!-- Layout Form Buat APBDes & Daftar APBDes -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Tambah Tahun Anggaran -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4 h-fit">
            <h3 class="font-bold text-slate-800 text-sm flex items-center space-x-2">
                <span>➕</span>
                <span>Buat Tahun Anggaran Baru</span>
            </h3>

            <form action="{{ route('admin.budgets.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="year" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Tahun Anggaran <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="year" 
                        name="year" 
                        value="{{ old('year', date('Y')) }}" 
                        required 
                        min="2000" 
                        max="2100"
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    @error('year')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="title" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Judul APBDes <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        value="{{ old('title', 'Anggaran Pendapatan dan Belanja Desa Tahun ' . date('Y')) }}" 
                        required 
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    @error('title')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Status Publikasi <span class="text-rose-500">*</span>
                    </label>
                    <select 
                        id="status" 
                        name="status" 
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white"
                    >
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publikasikan (Terbit)</option>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draf (Internal)</option>
                        <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Arsip</option>
                    </select>
                    @error('status')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Keterangan Singkat
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="2" 
                        placeholder="Deskripsi singkat APBDes..."
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full px-4 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
                    Buat & Kelola Rincian
                </button>
            </form>
        </div>

        <!-- Daftar Tahun Anggaran APBDes -->
        <div class="lg:col-span-2 space-y-4">
            <div class="space-y-4">
                @forelse($budgets as $budget)
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-4 hover:shadow-md transition">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-3 border-b border-slate-100">
                            <div>
                                <span class="px-2.5 py-0.5 rounded text-[11px] font-bold {{ $budget->status === 'published' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600' }}">
                                    {{ strtoupper($budget->status) }}
                                </span>
                                <h3 class="font-bold text-slate-800 text-base mt-1">{{ $budget->title }}</h3>
                            </div>
                            <span class="text-lg font-black text-slate-700">Tahun {{ $budget->year }}</span>
                        </div>

                        <!-- Mini Stats -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs">
                            <div class="p-3 bg-emerald-50/60 rounded-xl border border-emerald-100">
                                <span class="text-[10px] font-bold uppercase text-emerald-700 block">Total Pendapatan</span>
                                <span class="font-bold text-slate-800 mt-0.5 block">Rp {{ number_format($budget->total_realized_revenue, 0, ',', '.') }}</span>
                                <span class="text-[10px] text-slate-400">Target: Rp {{ number_format($budget->total_budgeted_revenue, 0, ',', '.') }}</span>
                            </div>
                            <div class="p-3 bg-rose-50/60 rounded-xl border border-rose-100">
                                <span class="text-[10px] font-bold uppercase text-rose-700 block">Total Belanja</span>
                                <span class="font-bold text-slate-800 mt-0.5 block">Rp {{ number_format($budget->total_realized_expenditure, 0, ',', '.') }}</span>
                                <span class="text-[10px] text-slate-400">Target: Rp {{ number_format($budget->total_budgeted_expenditure, 0, ',', '.') }}</span>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 col-span-2 sm:col-span-1">
                                <span class="text-[10px] font-bold uppercase text-slate-600 block">Surplus / Defisit</span>
                                <span class="font-bold {{ $budget->surplus_deficit_realized >= 0 ? 'text-emerald-600' : 'text-rose-600' }} mt-0.5 block">
                                    Rp {{ number_format($budget->surplus_deficit_realized, 0, ',', '.') }}
                                </span>
                                <span class="text-[10px] text-slate-400">{{ $budget->items->count() }} rekening item</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-2 text-xs">
                            <a href="{{ route('admin.budgets.show', $budget) }}" class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 font-semibold transition">
                                <span>📋 Kelola Rincian Item ({{ $budget->items->count() }})</span>
                                <span>&rarr;</span>
                            </a>
                            <form action="{{ route('admin.budgets.destroy', $budget) }}" method="POST" onsubmit="return confirm('Hapus seluruh data APBDes tahun ini beserta rincian itemnya?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center text-slate-400 bg-white rounded-2xl border border-slate-200">
                        <div class="text-4xl mb-3">📊</div>
                        <p class="text-sm font-semibold text-slate-600">Belum ada data APBDes</p>
                        <p class="text-xs text-slate-400 mt-1">Tambahkan tahun anggaran APBDes melalui form di sebelah kiri.</p>
                    </div>
                @endforelse
            </div>

            @if($budgets->hasPages())
                <div class="p-4 bg-white rounded-2xl border border-slate-200">
                    {{ $budgets->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
