@extends('admin.layouts.app')

@section('title', 'Tambah Template Surat')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.letter-templates.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800">Tambah Template Surat Baru</h2>
            <p class="text-xs text-slate-500">Definisikan format redaksi dan variabel otomatis surat resmi desa.</p>
        </div>
    </div>

    <form action="{{ route('admin.letter-templates.store') }}" method="POST" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Surat <span class="text-rose-500">*</span></label>
                <input type="text" name="code" value="{{ old('code') }}" required placeholder="cth: SKTM, SKCK" class="w-full px-3 py-2 border rounded-xl text-xs uppercase font-mono @error('code') border-rose-500 @enderror">
                @error('code') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Resmi Surat <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="cth: Surat Keterangan Tidak Mampu (SKTM)" class="w-full px-3 py-2 border rounded-xl text-xs @error('name') border-rose-500 @enderror">
                @error('name') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1">
                Format Penomoran Surat <span class="text-slate-400 font-normal">(Opsional - Kosongkan untuk memakai format standar config)</span>
            </label>
            <input type="text" name="number_format" value="{{ old('number_format') }}" placeholder="Default config: {{ config('letters.default_number_format') }}" class="w-full px-3 py-2 border rounded-xl text-xs font-mono @error('number_format') border-rose-500 @enderror">
            <span class="text-[11px] text-slate-500 mt-1 block">
                Placeholder yang didukung: <code>{nomor}</code>, <code>{nomor:3}</code>, <code>{kode}</code>, <code>{klasifikasi}</code>, <code>{bulan}</code>, <code>{bulan_romawi}</code>, <code>{tahun}</code>, <code>{desa}</code>.
            </span>
            @error('number_format') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi / Kegunaan</label>
            <input type="text" name="description" value="{{ old('description') }}" placeholder="Penjelasan singkat tujuan penerbitan surat ini..." class="w-full px-3 py-2 border rounded-xl text-xs">
        </div>

        <div x-data="{
            tab: 'editor',
            content: @js(old('content_template', '')),
            get previewHtml() {
                let html = this.content || '<p class=\'text-slate-400 italic\'>Ketik format redaksi HTML di tab editor untuk melihat pratinjau langsung...</p>';
                return html.replaceAll('[NAMA]', '<strong>Budi Santoso</strong>')
                           .replaceAll('[NIK]', '3201011508900001')
                           .replaceAll('[NO_KK]', '3201011202150001')
                           .replaceAll('[TEMPAT_TANGGAL_LAHIR]', 'Bogor, 15 Agustus 1990')
                           .replaceAll('[JENIS_KELAMIN]', 'Laki-laki')
                           .replaceAll('[AGAMA]', 'Islam')
                           .replaceAll('[STATUS_KAWIN]', 'Kawin')
                           .replaceAll('[PEKERJAAN]', 'Wiraswasta')
                           .replaceAll('[PENDIDIKAN]', 'S1/D4')
                           .replaceAll('[KEWARGANEGARAAN]', 'WNI')
                           .replaceAll('[ALAMAT]', 'Jl. Merpati No. 12')
                           .replaceAll('[RT]', '001')
                           .replaceAll('[RW]', '002')
                           .replaceAll('[DUSUN]', 'Dusun Sukamaju')
                           .replaceAll('[NAMA_DESA]', 'Sukamaju')
                           .replaceAll('[NAMA_KECAMATAN]', 'Cibinong')
                           .replaceAll('[NAMA_KABUPATEN]', 'Bogor')
                           .replaceAll('[KEPERLUAN]', 'Contoh Keperluan Pengajuan Surat')
                           .replaceAll('[NOMOR_SURAT]', '470/001/DS/2026')
                           .replaceAll('[TANGGAL_SURAT]', '04 Oktober 2026')
                           .replaceAll('[NAMA_USAHA]', 'Warung Berkah Mandiri')
                           .replaceAll('[LOKASI_USAHA]', 'RT 001 / RW 002')
                           .replaceAll('[LAMA_USAHA]', '3 Tahun');
            }
        }">
            <div class="flex items-center justify-between mb-2">
                <label class="block text-xs font-semibold text-slate-700">Format Isi Template (HTML) <span class="text-rose-500">*</span></label>
                <div class="flex space-x-1 bg-slate-100 p-1 rounded-xl">
                    <button type="button" @click="tab = 'editor'" :class="tab === 'editor' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-600'" class="px-3 py-1 rounded-lg text-xs font-semibold transition">
                        📝 Kode HTML
                    </button>
                    <button type="button" @click="tab = 'preview'" :class="tab === 'preview' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-600'" class="px-3 py-1 rounded-lg text-xs font-semibold transition flex items-center space-x-1">
                        <span>👁️</span>
                        <span>Pratinjau Langsung</span>
                    </button>
                </div>
            </div>

            <div x-show="tab === 'editor'">
                <textarea name="content_template" x-model="content" rows="12" required class="w-full px-3 py-2 border rounded-xl text-xs font-mono @error('content_template') border-rose-500 @enderror"></textarea>
                <div class="text-[11px] text-slate-400 mt-1">Placeholder: [NAMA], [NIK], [NO_KK], [TEMPAT_TANGGAL_LAHIR], [ALAMAT], [RT], [RW], [DUSUN], [KEPERLUAN], dll.</div>
            </div>

            <div x-show="tab === 'preview'" class="p-6 bg-slate-50 border border-slate-200 rounded-xl font-serif text-xs text-slate-800 leading-relaxed shadow-inner min-h-[250px]" x-html="previewHtml">
            </div>
            @error('content_template') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center space-x-2">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
            <label for="is_active" class="text-xs font-medium text-slate-700">Aktifkan template ini agar dapat dipilih warga</label>
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end space-x-3">
            <a href="{{ route('admin.letter-templates.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-xs font-semibold hover:bg-slate-200 transition">
                Batal
            </a>
            <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition">
                Simpan Template
            </button>
        </div>
    </form>
</div>
@endsection
