@extends('admin.layouts.app')

@section('title', 'Unggah Dokumen Publik PPID')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Unggah Dokumen Publik Baru</h2>
            <p class="text-xs text-slate-500 mt-1">Tambahkan berkas resmi ke Daftar Informasi Publik (DIP) Desa.</p>
        </div>
        <a href="{{ route('admin.ppid-documents.index') }}" class="text-xs text-slate-500 hover:text-slate-800">
            &larr; Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-xs space-y-1">
            <div class="font-bold">⚠️ Periksa isian formulir:</div>
            <ul class="list-disc list-inside space-y-0.5 text-[11px] pt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.ppid-documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label for="title" class="block text-xs font-semibold text-slate-700 mb-1">
                    Judul Dokumen Publik <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    value="{{ old('title') }}" 
                    required 
                    placeholder="Contoh: Rencana Kerja Pemerintah Desa (RKPDes) Tahun 2026"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="category" class="block text-xs font-semibold text-slate-700 mb-1">
                        Klasifikasi KIP <span class="text-rose-500">*</span>
                    </label>
                    <select name="category" id="category" required class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                        <option value="berkala" {{ old('category') === 'berkala' ? 'selected' : '' }}>Informasi Berkala</option>
                        <option value="setiap_saat" {{ old('category') === 'setiap_saat' ? 'selected' : '' }}>Informasi Setiap Saat</option>
                        <option value="serta_merta" {{ old('category') === 'serta_merta' ? 'selected' : '' }}>Informasi Serta Merta</option>
                        <option value="dikecualikan" {{ old('category') === 'dikecualikan' ? 'selected' : '' }}>Informasi Dikecualikan</option>
                    </select>
                </div>

                <div>
                    <label for="document_type" class="block text-xs font-semibold text-slate-700 mb-1">
                        Tipe Dokumen <span class="text-rose-500">*</span>
                    </label>
                    <select name="document_type" id="document_type" required class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                        @foreach($documentTypes as $type)
                            <option value="{{ $type }}" {{ old('document_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="year" class="block text-xs font-semibold text-slate-700 mb-1">
                        Tahun Penetapan
                    </label>
                    <input 
                        type="number" 
                        name="year" 
                        id="year" 
                        value="{{ old('year', date('Y')) }}" 
                        placeholder="{{ date('Y') }}"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>
            </div>

            <div>
                <label for="description" class="block text-xs font-semibold text-slate-700 mb-1">
                    Ringkasan Isi Dokumen
                </label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="3" 
                    placeholder="Penjelasan ringkas mengenai substansi dokumen..."
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >{{ old('description') }}</textarea>
            </div>

            <div>
                <label for="file" class="block text-xs font-semibold text-slate-700 mb-1">
                    Berkas Dokumen (PDF, DOC/DOCX, XLS/XLSX, ZIP maks 10MB) <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="file" 
                    name="file" 
                    id="file" 
                    required 
                    accept=".pdf,.doc,.docx,.xls,.xlsx,.zip"
                    class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                >
            </div>

            <div class="pt-2">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', '1') === '1' ? 'checked' : '' }} class="h-4 w-4 text-blue-600 rounded">
                    <span class="text-xs text-slate-700 font-medium">Langsung Terbitkan ke Portal Publik (Daftar Informasi Publik)</span>
                </label>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('admin.ppid-documents.index') }}" class="text-xs text-slate-500 hover:text-slate-800">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-sm transition text-xs">
                    Simpan & Unggah Dokumen
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
