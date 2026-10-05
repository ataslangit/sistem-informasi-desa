@extends(theme_layout())

@section('title', 'Daftar Dokumen Informasi Publik (DIP) - PPID Desa')

@section('content')
<!-- Header Banner -->
<section class="bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 text-white py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/20 text-blue-200 border border-blue-400/30 mb-3 space-x-1.5">
            <span>📁</span>
            <span>Daftar Informasi Publik (DIP Desa)</span>
        </span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight">
            Repositori Dokumen Publik
        </h1>
        <p class="mt-2 text-sm sm:text-base text-blue-100 max-w-2xl leading-relaxed">
            Akses dan unduh berkas resmi penyelenggaraan pemerintahan desa seperti RPJMDes, RKPDes, LPPD, LKPPD, dan Peraturan Desa sesuai amanat UU No. 14 Tahun 2008.
        </p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <!-- Filter Bar -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
        <form action="{{ route('public.ppid.documents') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="lg:col-span-2">
                <label for="keyword" class="block text-xs font-semibold text-slate-700 mb-1">Cari Dokumen</label>
                <input 
                    type="text" 
                    id="keyword"
                    name="keyword" 
                    value="{{ $keyword }}" 
                    placeholder="Judul atau kata kunci dokumen..." 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
            </div>

            <div>
                <label for="category" class="block text-xs font-semibold text-slate-700 mb-1">Kategori KIP</label>
                <select id="category" name="category" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                    <option value="">Semua Kategori</option>
                    <option value="berkala" {{ $category === 'berkala' ? 'selected' : '' }}>Informasi Berkala</option>
                    <option value="setiap_saat" {{ $category === 'setiap_saat' ? 'selected' : '' }}>Informasi Setiap Saat</option>
                    <option value="serta_merta" {{ $category === 'serta_merta' ? 'selected' : '' }}>Informasi Serta Merta</option>
                </select>
            </div>

            <div>
                <label for="year" class="block text-xs font-semibold text-slate-700 mb-1">Tahun</label>
                <select id="year" name="year" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $y)
                        <option value="{{ $y }}" {{ (string)$year === (string)$y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end space-x-2">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs shadow-sm transition">
                    Filter
                </button>
                @if($keyword || $category || $documentType || $year)
                    <a href="{{ route('public.ppid.documents') }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Documents Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($documents as $doc)
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow-md transition space-y-4">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                            {{ $doc->document_type }}
                        </span>
                        @if($doc->year)
                            <span class="text-[11px] font-semibold text-slate-400">Tahun {{ $doc->year }}</span>
                        @endif
                    </div>
                    <h3 class="font-bold text-sm text-slate-800 leading-snug">{{ $doc->title }}</h3>
                    <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                        {{ $doc->description ?? 'Dokumen resmi publikasi PPID Desa.' }}
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <div class="text-[11px] text-slate-400">
                        <span class="font-mono">{{ $doc->formatted_file_size }}</span> • 
                        <span>{{ $doc->download_count }}x diunduh</span>
                    </div>
                    <a href="{{ route('public.ppid.documents.download', $doc) }}" class="inline-flex items-center px-3.5 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold transition space-x-1 shadow-sm">
                        <span>⬇️ Unduh</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full p-16 text-center bg-white rounded-3xl border border-dashed border-slate-200 text-slate-400 space-y-2">
                <span class="text-4xl block">📭</span>
                <p class="text-sm font-semibold">Tidak ada dokumen publik yang sesuai kriteria pencarian.</p>
                <p class="text-xs">Coba atur ulang kata kunci atau filter tahun pencarian Anda.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pt-4">
        {{ $documents->links() }}
    </div>
</div>
@endsection
