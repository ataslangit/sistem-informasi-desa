@extends('admin.layouts.app')

@section('title', 'Edit Kartu Keluarga')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Edit Kartu Keluarga: {{ $family->family_card_number }}</h2>
            <p class="text-xs text-slate-500 mt-1">Perbarui data alamat dan informasi Kartu Keluarga.</p>
        </div>
        <a href="{{ route('admin.families.show', $family) }}" class="text-xs text-slate-600 hover:text-slate-800 font-semibold">
            ← Kembali ke Detail KK
        </a>
    </div>

    @if ($errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-xs">
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
        <form action="{{ route('admin.families.update', $family) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="family_card_number" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                        Nomor Kartu Keluarga (16 Digit) <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="family_card_number" 
                        id="family_card_number" 
                        value="{{ old('family_card_number', $family->family_card_number) }}" 
                        maxlength="16" 
                        required 
                        class="w-full font-mono px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>

                <div>
                    <label for="head_of_family_id" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                        Kepala Keluarga
                    </label>
                    <select name="head_of_family_id" id="head_of_family_id" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">-- Pilih dari Anggota KK --</option>
                        @foreach($family->members as $member)
                            <option value="{{ $member->id }}" {{ (string)old('head_of_family_id', $family->head_of_family_id) === (string)$member->id ? 'selected' : '' }}>
                                {{ $member->name }} (NIK: {{ $member->nik }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="rt" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                        RT <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="rt" 
                        id="rt" 
                        value="{{ old('rt', $family->rt) }}" 
                        maxlength="5" 
                        required 
                        class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>
                <div>
                    <label for="rw" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                        RW <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="rw" 
                        id="rw" 
                        value="{{ old('rw', $family->rw) }}" 
                        maxlength="5" 
                        required 
                        class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>
                <div>
                    <label for="hamlet" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                        Dusun / Lingkungan
                    </label>
                    <input 
                        type="text" 
                        name="hamlet" 
                        id="hamlet" 
                        value="{{ old('hamlet', $family->hamlet) }}" 
                        class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>
            </div>

            <div>
                <label for="address" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                    Alamat Lengkap / Jalan
                </label>
                <textarea 
                    name="address" 
                    id="address" 
                    rows="2" 
                    class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >{{ old('address', $family->address) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="postal_code" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                        Kode Pos
                    </label>
                    <input 
                        type="text" 
                        name="postal_code" 
                        id="postal_code" 
                        value="{{ old('postal_code', $family->postal_code) }}" 
                        maxlength="10" 
                        class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>
                <div>
                    <label for="economic_status" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                        Status Ekonomi <span class="text-rose-500">*</span>
                    </label>
                    <select name="economic_status" id="economic_status" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="mampu" {{ old('economic_status', $family->economic_status) === 'mampu' ? 'selected' : '' }}>Mampu / Cukup</option>
                        <option value="rentan" {{ old('economic_status', $family->economic_status) === 'rentan' ? 'selected' : '' }}>Rentan Miskin</option>
                        <option value="miskin" {{ old('economic_status', $family->economic_status) === 'miskin' ? 'selected' : '' }}>Miskin</option>
                        <option value="sangat_miskin" {{ old('economic_status', $family->economic_status) === 'sangat_miskin' ? 'selected' : '' }}>Sangat Miskin</option>
                    </select>
                </div>
                <div>
                    <label for="social_assistance_status" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                        Status Bansos
                    </label>
                    <input 
                        type="text" 
                        name="social_assistance_status" 
                        id="social_assistance_status" 
                        value="{{ old('social_assistance_status', $family->social_assistance_status) }}" 
                        class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end space-x-3">
                <a href="{{ route('admin.families.show', $family) }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-sm transition">
                    Perbarui Kartu Keluarga
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
