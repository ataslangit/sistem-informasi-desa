@extends('admin.layouts.app')

@section('title', 'Buat Pengajuan Surat')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center space-x-3">
        <a href="{{ route('citizen.letters.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800">Form Pengajuan Surat Mandiri</h2>
            <p class="text-xs text-slate-500">Pilih jenis surat dan masukkan data keperluan penerbitan surat resmi desa.</p>
        </div>
    </div>

    @if(!$resident)
        <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl text-amber-800 text-xs">
            ⚠️ <strong>Perhatian:</strong> Akun Anda belum terhubung dengan data kependudukan (NIK). Harap hubungi operator desa terlebih dahulu untuk menautkan akun Anda dengan data kependudukan resmi.
        </div>
    @else
        <!-- Info Biodata Pemohon -->
        <div class="bg-blue-50/60 border border-blue-200 rounded-2xl p-4 text-xs">
            <div class="font-bold text-blue-900 mb-2">Identitas Pemohon Terhubung:</div>
            <div class="grid grid-cols-2 gap-2 text-slate-700">
                <div>Nama: <strong class="text-slate-900">{{ $resident->name }}</strong></div>
                <div>NIK: <strong class="font-mono text-slate-900">{{ $resident->nik }}</strong></div>
                <div>No KK: <span class="font-mono">{{ $resident->family?->family_card_number ?? '-' }}</span></div>
                <div>Wilayah: RT {{ $resident->family?->rt ?? '-' }} / RW {{ $resident->family?->rw ?? '-' }}</div>
            </div>
        </div>

        <form action="{{ route('citizen.letters.store') }}" method="POST" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Jenis Surat <span class="text-rose-500">*</span></label>
                <select name="letter_template_id" required class="w-full px-3 py-2 border rounded-xl text-xs @error('letter_template_id') border-rose-500 @enderror">
                    <option value="">-- Pilih Jenis Surat --</option>
                    @foreach($templates as $tpl)
                        <option value="{{ $tpl->id }}" {{ old('letter_template_id') == $tpl->id ? 'selected' : '' }}>
                            {{ $tpl->name }} ({{ $tpl->code }})
                        </option>
                    @endforeach
                </select>
                @error('letter_template_id') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Keperluan Pengajuan Surat <span class="text-rose-500">*</span></label>
                <textarea name="purpose" rows="4" required placeholder="Contoh: Untuk persyaratan pendaftaran beasiswa anak, melamar pekerjaan, atau pembukaan rekening bank..." class="w-full px-3 py-2 border rounded-xl text-xs @error('purpose') border-rose-500 @enderror">{{ old('purpose') }}</textarea>
                @error('purpose') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                <p class="text-[10px] text-slate-400 mt-1">Jelaskan secara spesifik agar aparat desa dapat memverifikasi dengan tepat.</p>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end space-x-3">
                <a href="{{ route('citizen.letters.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-xs font-semibold hover:bg-slate-200 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition">
                    Kirim Permohonan &rarr;
                </button>
            </div>
        </form>
    @endif
</div>
@endsection
