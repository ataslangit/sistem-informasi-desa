@extends('admin.layouts.app')

@section('title', 'Rincian APBDes ' . $budget->year . ' - ' . $budget->title)

@section('content')
<div class="space-y-6">
    <!-- Header & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.budgets.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition" title="Kembali">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-bold text-slate-800">Kelola Rincian: APBDes {{ $budget->year }}</h2>
                <p class="text-xs text-slate-500 mt-0.5">{{ $budget->title }}</p>
            </div>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('budgets.index', ['year' => $budget->year]) }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition space-x-1.5 border border-emerald-200">
                <span>🌐</span>
                <span>Lihat di Portal Publik</span>
            </a>
        </div>
    </div>

    <!-- Ringkasan Anggaran & Metadata Update Form -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <form action="{{ route('admin.budgets.update', $budget) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
            @csrf
            @method('PUT')

            <div class="sm:col-span-2">
                <label for="title" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                    Judul Publikasi APBDes <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title', $budget->title) }}" 
                    required 
                    class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
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
                    <option value="published" {{ $budget->status === 'published' ? 'selected' : '' }}>Publikasikan (Terbit)</option>
                    <option value="draft" {{ $budget->status === 'draft' ? 'selected' : '' }}>Draf (Internal)</option>
                    <option value="archived" {{ $budget->status === 'archived' ? 'selected' : '' }}>Arsip</option>
                </select>
            </div>

            <div>
                <button type="submit" class="w-full px-4 py-2.5 rounded-xl text-xs font-semibold bg-slate-800 text-white hover:bg-slate-900 transition shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Layout Form Tambah Item (1/3) & Tabel Rincian (2/3) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Tambah Item Anggaran -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4 h-fit">
            <h3 class="font-bold text-slate-800 text-sm flex items-center space-x-2">
                <span>➕</span>
                <span>Tambah Item Anggaran</span>
            </h3>

            <form action="{{ route('admin.budgets.items.store', $budget) }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="type" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Pilar Akun APBDes <span class="text-rose-500">*</span>
                    </label>
                    <select 
                        id="type" 
                        name="type" 
                        required
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white"
                    >
                        <option value="revenue" {{ old('type') === 'revenue' ? 'selected' : '' }}>1. Pendapatan Desa (Akun 4)</option>
                        <option value="expenditure" {{ old('type') === 'expenditure' ? 'selected' : '' }}>2. Belanja Desa (Akun 5)</option>
                        <option value="financing" {{ old('type') === 'financing' ? 'selected' : '' }}>3. Pembiayaan Desa (Akun 6)</option>
                    </select>
                </div>

                <div>
                    <label for="category" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Kategori / Uraian Kegiatan <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="category" 
                        name="category" 
                        value="{{ old('category') }}" 
                        required 
                        placeholder="Contoh: Dana Desa (DDS) / Bidang Pembangunan"
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                    @error('category')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="budgeted_amount" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Target Anggaran (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="budgeted_amount" 
                        name="budgeted_amount" 
                        value="{{ old('budgeted_amount') }}" 
                        required 
                        min="0"
                        placeholder="Contoh: 150000000"
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none font-mono"
                    >
                    @error('budgeted_amount')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="realized_amount" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Realisasi Saat Ini (Rp)
                    </label>
                    <input 
                        type="number" 
                        id="realized_amount" 
                        name="realized_amount" 
                        value="{{ old('realized_amount', 0) }}" 
                        min="0"
                        placeholder="Contoh: 145000000"
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none font-mono"
                    >
                    @error('realized_amount')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="notes" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Catatan / Sumber Dana
                    </label>
                    <input 
                        type="text" 
                        id="notes" 
                        name="notes" 
                        value="{{ old('notes') }}" 
                        placeholder="Keterangan opsional..."
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>

                <button type="submit" class="w-full px-4 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
                    Tambahkan ke APBDes
                </button>
            </form>
        </div>

        <!-- Tabel Rincian Per Pilar Akun -->
        <div class="lg:col-span-2 space-y-6">
            <!-- 1. Pendapatan -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="p-4 bg-emerald-50 border-b border-emerald-100 flex items-center justify-between">
                    <h3 class="font-bold text-emerald-950 text-xs uppercase tracking-wider flex items-center space-x-2">
                        <span>💰</span>
                        <span>1. Pendapatan Desa ({{ $budget->revenues->count() }} item)</span>
                    </h3>
                    <span class="text-xs font-bold text-emerald-800 font-mono">
                        Realisasi: Rp {{ number_format($budget->total_realized_revenue, 0, ',', '.') }}
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200 text-[11px]">
                                <th class="py-2.5 px-4">Kategori / Uraian</th>
                                <th class="py-2.5 px-4 text-right">Anggaran</th>
                                <th class="py-2.5 px-4 text-right">Realisasi</th>
                                <th class="py-2.5 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($budget->revenues as $item)
                                <tr class="hover:bg-slate-50">
                                    <td class="py-2.5 px-4 font-semibold text-slate-800">{{ $item->category }}</td>
                                    <td class="py-2.5 px-4 text-right font-mono text-slate-600">{{ number_format($item->budgeted_amount, 0, ',', '.') }}</td>
                                    <td class="py-2.5 px-4 text-right font-mono font-bold text-emerald-700">{{ number_format($item->realized_amount, 0, ',', '.') }}</td>
                                    <td class="py-2.5 px-4 text-center">
                                        <form action="{{ route('admin.budgets.items.destroy', [$budget, $item]) }}" method="POST" onsubmit="return confirm('Hapus item ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold text-[11px]">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-slate-400">Belum ada item pendapatan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 2. Belanja -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="p-4 bg-rose-50 border-b border-rose-100 flex items-center justify-between">
                    <h3 class="font-bold text-rose-950 text-xs uppercase tracking-wider flex items-center space-x-2">
                        <span>🛒</span>
                        <span>2. Belanja Desa ({{ $budget->expenditures->count() }} item)</span>
                    </h3>
                    <span class="text-xs font-bold text-rose-800 font-mono">
                        Realisasi: Rp {{ number_format($budget->total_realized_expenditure, 0, ',', '.') }}
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200 text-[11px]">
                                <th class="py-2.5 px-4">Bidang Belanja</th>
                                <th class="py-2.5 px-4 text-right">Anggaran</th>
                                <th class="py-2.5 px-4 text-right">Realisasi</th>
                                <th class="py-2.5 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($budget->expenditures as $item)
                                <tr class="hover:bg-slate-50">
                                    <td class="py-2.5 px-4 font-semibold text-slate-800">{{ $item->category }}</td>
                                    <td class="py-2.5 px-4 text-right font-mono text-slate-600">{{ number_format($item->budgeted_amount, 0, ',', '.') }}</td>
                                    <td class="py-2.5 px-4 text-right font-mono font-bold text-rose-700">{{ number_format($item->realized_amount, 0, ',', '.') }}</td>
                                    <td class="py-2.5 px-4 text-center">
                                        <form action="{{ route('admin.budgets.items.destroy', [$budget, $item]) }}" method="POST" onsubmit="return confirm('Hapus item ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold text-[11px]">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-slate-400">Belum ada item belanja.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 3. Pembiayaan -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="p-4 bg-blue-50 border-b border-blue-100 flex items-center justify-between">
                    <h3 class="font-bold text-blue-950 text-xs uppercase tracking-wider flex items-center space-x-2">
                        <span>⚖️</span>
                        <span>3. Pembiayaan Desa ({{ $budget->financings->count() }} item)</span>
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200 text-[11px]">
                                <th class="py-2.5 px-4">Uraian Pembiayaan</th>
                                <th class="py-2.5 px-4 text-right">Anggaran</th>
                                <th class="py-2.5 px-4 text-right">Realisasi</th>
                                <th class="py-2.5 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($budget->financings as $item)
                                <tr class="hover:bg-slate-50">
                                    <td class="py-2.5 px-4 font-semibold text-slate-800">{{ $item->category }}</td>
                                    <td class="py-2.5 px-4 text-right font-mono text-slate-600">{{ number_format($item->budgeted_amount, 0, ',', '.') }}</td>
                                    <td class="py-2.5 px-4 text-right font-mono font-bold text-blue-700">{{ number_format($item->realized_amount, 0, ',', '.') }}</td>
                                    <td class="py-2.5 px-4 text-center">
                                        <form action="{{ route('admin.budgets.items.destroy', [$budget, $item]) }}" method="POST" onsubmit="return confirm('Hapus item ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold text-[11px]">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-slate-400">Belum ada item pembiayaan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
