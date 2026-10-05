@extends('admin.layouts.app')

@section('title', 'Edit Penduduk: ' . $resident->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6"
     x-data="{
         regencies: [],
         async init() {
             try {
                 const res = await fetch('{{ route('admin.api.wilayah.all-regencies') }}');
                 const json = await res.json();
                 this.regencies = json.data || [];
             } catch (e) {
                 console.error('Gagal memuat regencies:', e);
             }
         }
     }">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Edit Biodata: {{ $resident->name }}</h2>
            <p class="text-xs text-slate-500 mt-1 font-mono">NIK: {{ $resident->nik }}</p>
        </div>
        <a href="{{ route('admin.residents.show', $resident) }}" class="text-xs text-slate-600 hover:text-slate-800 font-semibold">
            ← Kembali ke Biodata
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
        <form action="{{ route('admin.residents.update', $resident) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1 -->
            <div>
                <h3 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">
                    1. Identitas Pokok & Kartu Keluarga
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="nik" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            NIK (16 Digit) <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="nik" 
                            id="nik" 
                            value="{{ old('nik', $resident->nik) }}" 
                            maxlength="16" 
                            required 
                            class="w-full font-mono px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>

                    <div>
                        <label for="family_id" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            Kartu Keluarga
                        </label>
                        <select name="family_id" id="family_id" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="">-- Tanpa KK / Belum Terdaftar --</option>
                            @foreach($families as $fam)
                                <option value="{{ $fam->id }}" {{ (string)old('family_id', $resident->family_id) === (string)$fam->id ? 'selected' : '' }}>
                                    No. KK: {{ $fam->family_card_number }} (RT {{ $fam->rt }}/RW {{ $fam->rw }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="name" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            value="{{ old('name', $resident->name) }}" 
                            required 
                            class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>
                </div>
            </div>

            <!-- Section 2 -->
            <div>
                <h3 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">
                    2. Kelahiran & Karakteristik Fisik
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="birth_place" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            Tempat Lahir <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="birth_place" 
                            id="birth_place" 
                            list="birth_place_list"
                            value="{{ old('birth_place', $resident->birth_place) }}" 
                            required 
                            placeholder="Ketik Kota / Kabupaten..."
                            class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>

                    <div>
                        <label for="birth_date" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            Tanggal Lahir <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="date" 
                            name="birth_date" 
                            id="birth_date" 
                            value="{{ old('birth_date', $resident->birth_date ? $resident->birth_date->format('Y-m-d') : '') }}" 
                            required 
                            class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>

                    <div>
                        <label for="gender" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            Jenis Kelamin <span class="text-rose-500">*</span>
                        </label>
                        <select name="gender" id="gender" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="L" {{ old('gender', $resident->gender) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender', $resident->gender) === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label for="blood_type" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            Golongan Darah
                        </label>
                        <select name="blood_type" id="blood_type" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="-" {{ old('blood_type', $resident->blood_type) === '-' ? 'selected' : '' }}>-</option>
                            <option value="A" {{ old('blood_type', $resident->blood_type) === 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('blood_type', $resident->blood_type) === 'B' ? 'selected' : '' }}>B</option>
                            <option value="AB" {{ old('blood_type', $resident->blood_type) === 'AB' ? 'selected' : '' }}>AB</option>
                            <option value="O" {{ old('blood_type', $resident->blood_type) === 'O' ? 'selected' : '' }}>O</option>
                        </select>
                    </div>

                    <div>
                        <label for="religion" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            Agama <span class="text-rose-500">*</span>
                        </label>
                        <select name="religion" id="religion" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'] as $rel)
                                <option value="{{ $rel }}" {{ old('religion', $resident->religion) === $rel ? 'selected' : '' }}>{{ $rel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="marital_status" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            Status Perkawinan <span class="text-rose-500">*</span>
                        </label>
                        <select name="marital_status" id="marital_status" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $mStatus)
                                <option value="{{ $mStatus }}" {{ old('marital_status', $resident->marital_status) === $mStatus ? 'selected' : '' }}>{{ $mStatus }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section 3 -->
            <div>
                <h3 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">
                    3. Hubungan Keluarga, Pendidikan & Profesi
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="family_relationship_status" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            Hubungan dalam KK <span class="text-rose-500">*</span>
                        </label>
                        <select name="family_relationship_status" id="family_relationship_status" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            @foreach(['Kepala Keluarga', 'Istri', 'Anak', 'Orang Tua', 'Mertua', 'Famili Lain', 'Lainnya'] as $relStatus)
                                <option value="{{ $relStatus }}" {{ old('family_relationship_status', $resident->family_relationship_status) === $relStatus ? 'selected' : '' }}>{{ $relStatus }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="education_level" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            Pendidikan Terakhir <span class="text-rose-500">*</span>
                        </label>
                        <select name="education_level" id="education_level" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            @foreach(['Tidak/Belum Sekolah', 'SD Sederajat', 'SMP Sederajat', 'SMA Sederajat', 'D1/D2/D3', 'S1/D4', 'S2', 'S3'] as $edu)
                                <option value="{{ $edu }}" {{ old('education_level', $resident->education_level) === $edu ? 'selected' : '' }}>{{ $edu }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="occupation" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            Pekerjaan <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="occupation" 
                            id="occupation" 
                            value="{{ old('occupation', $resident->occupation) }}" 
                            required 
                            class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>

                    <div>
                        <label for="father_name" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            Nama Ayah Kandung
                        </label>
                        <input 
                            type="text" 
                            name="father_name" 
                            id="father_name" 
                            value="{{ old('father_name', $resident->father_name) }}" 
                            class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>

                    <div>
                        <label for="mother_name" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            Nama Ibu Kandung
                        </label>
                        <input 
                            type="text" 
                            name="mother_name" 
                            id="mother_name" 
                            value="{{ old('mother_name', $resident->mother_name) }}" 
                            class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>

                    <div>
                        <label for="status" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            Status Penduduk <span class="text-rose-500">*</span>
                        </label>
                        <select name="status" id="status" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="active" {{ old('status', $resident->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="moved" {{ old('status', $resident->status) === 'moved' ? 'selected' : '' }}>Pindah</option>
                            <option value="deceased" {{ old('status', $resident->status) === 'deceased' ? 'selected' : '' }}>Meninggal</option>
                            <option value="temporary" {{ old('status', $resident->status) === 'temporary' ? 'selected' : '' }}>Sementara</option>
                        </select>
                    </div>
                </div>

                <input type="hidden" name="nationality" value="WNI">
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end space-x-3">
                <a href="{{ route('admin.residents.show', $resident) }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Datalist Autocomplete Kabupaten untuk Tempat Lahir -->
    <datalist id="birth_place_list">
        <template x-for="r in regencies" :key="r.code">
            <option :value="r.name"></option>
        </template>
    </datalist>
</div>
@endsection
