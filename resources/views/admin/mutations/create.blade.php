@extends('admin.layouts.app')

@section('title', 'Pencatatan Peristiwa Mutasi Penduduk')

@section('content')
<div class="max-w-3xl mx-auto space-y-6" x-data="{ currentType: '{{ old('type', $type) }}' }">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Pencatatan Mutasi Penduduk</h2>
            <p class="text-xs text-slate-500 mt-1">Catat peristiwa kelahiran baru, kematian, maupun kepindahan domisili warga.</p>
        </div>
        <a href="{{ route('admin.mutations.index') }}" class="text-xs text-slate-600 hover:text-slate-800 font-semibold">
            ← Kembali ke Riwayat Mutasi
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

    <!-- Mutation Type Selector Tabs -->
    <div class="bg-white p-2 rounded-2xl border border-slate-200 shadow-sm flex space-x-2">
        <button 
            type="button" 
            @click="currentType = 'birth'" 
            :class="currentType === 'birth' ? 'bg-emerald-600 text-white font-bold shadow-sm' : 'text-slate-600 hover:bg-slate-100'"
            class="flex-1 py-2.5 px-3 rounded-xl text-xs transition flex items-center justify-center space-x-2"
        >
            <span>👶</span>
            <span>Kelahiran Baru</span>
        </button>

        <button 
            type="button" 
            @click="currentType = 'death'" 
            :class="currentType === 'death' ? 'bg-slate-800 text-white font-bold shadow-sm' : 'text-slate-600 hover:bg-slate-100'"
            class="flex-1 py-2.5 px-3 rounded-xl text-xs transition flex items-center justify-center space-x-2"
        >
            <span>🕊️</span>
            <span>Kematian</span>
        </button>

        <button 
            type="button" 
            @click="currentType = 'moved_out'" 
            :class="currentType === 'moved_out' ? 'bg-rose-600 text-white font-bold shadow-sm' : 'text-slate-600 hover:bg-slate-100'"
            class="flex-1 py-2.5 px-3 rounded-xl text-xs transition flex items-center justify-center space-x-2"
        >
            <span>📦</span>
            <span>Pindah Keluar</span>
        </button>
    </div>

    <!-- Main Mutation Form -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
        <form action="{{ route('admin.mutations.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="type" :value="currentType">

            <!-- Form Tab 1: Kelahiran Baru -->
            <div x-show="currentType === 'birth'" class="space-y-4">
                <div class="bg-emerald-50 text-emerald-800 p-3 rounded-xl text-xs border border-emerald-200">
                    ℹ️ Mengisi form ini akan otomatis menambahkan bayi ke dalam Buku Induk Penduduk dan mencatat log mutasi lahir.
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="birth_nik" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            NIK Bayi (16 Digit) <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="nik" 
                            id="birth_nik" 
                            maxlength="16" 
                            placeholder="Contoh: 3201011508260001" 
                            class="w-full font-mono px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                        >
                    </div>

                    <div>
                        <label for="birth_family_id" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            Masuk Kartu Keluarga
                        </label>
                        <select name="family_id" id="birth_family_id" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            <option value="">-- Tanpa KK --</option>
                            @foreach($families as $fam)
                                <option value="{{ $fam->id }}">No. KK: {{ $fam->family_card_number }} (RT {{ $fam->rt }}/RW {{ $fam->rw }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="birth_name" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            Nama Lengkap Bayi <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="birth_name" 
                            placeholder="Nama bayi yang baru lahir" 
                            class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                        >
                    </div>

                    <div>
                        <label for="birth_place_input" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            Tempat Lahir <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="birth_place" 
                            id="birth_place_input" 
                            placeholder="Kota/Kabupaten kelahiran" 
                            class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                        >
                    </div>

                    <div>
                        <label for="birth_date_input" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            Tanggal Lahir <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="date" 
                            name="birth_date" 
                            id="birth_date_input" 
                            value="{{ date('Y-m-d') }}" 
                            class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                        >
                    </div>

                    <div>
                        <label for="birth_gender" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            Jenis Kelamin <span class="text-rose-500">*</span>
                        </label>
                        <select name="gender" id="birth_gender" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label for="birth_religion" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            Agama
                        </label>
                        <select name="religion" id="birth_religion" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>

                    <div>
                        <label for="birth_father" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            Nama Ayah
                        </label>
                        <input type="text" name="father_name" id="birth_father" class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>

                    <div>
                        <label for="birth_mother" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                            Nama Ibu
                        </label>
                        <input type="text" name="mother_name" id="birth_mother" class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>
                </div>
            </div>

            <!-- Form Tab 2 & 3: Kematian & Pindah Keluar (Pilih dari Penduduk yang Ada) -->
            <div x-show="currentType === 'death' || currentType === 'moved_out'" class="space-y-4">
                <div>
                    <label for="resident_id" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                        Pilih Penduduk <span class="text-rose-500">*</span>
                    </label>
                    <select name="resident_id" id="resident_id" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">-- Pilih Penduduk Aktif --</option>
                        @foreach($residents as $res)
                            <option value="{{ $res->id }}" {{ (string)old('resident_id') === (string)$res->id ? 'selected' : '' }}>
                                {{ $res->name }} (NIK: {{ $res->nik }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="reason" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                        Keterangan / Alasan <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="reason" 
                        id="reason" 
                        value="{{ old('reason') }}" 
                        placeholder="Contoh: Sakit menua, Serangan jantung, atau Pindah kerja ke luar kota" 
                        class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>
            </div>

            <!-- Bagian Umum (Tanggal, Nomor Surat, Catatan) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div>
                    <label for="date" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                        Tanggal Peristiwa Mutasi <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        name="date" 
                        id="date" 
                        value="{{ old('date', date('Y-m-d')) }}" 
                        required 
                        class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>

                <div>
                    <label for="reference_number" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                        Nomor Surat Pengantar / Akta
                    </label>
                    <input 
                        type="text" 
                        name="reference_number" 
                        id="reference_number" 
                        value="{{ old('reference_number') }}" 
                        placeholder="Contoh: 472.11/05/DS/2026" 
                        class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>

                <div class="sm:col-span-2">
                    <label for="notes" class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                        Catatan Tambahan (Alamat Tujuan Pindah / Tempat Meninggal)
                    </label>
                    <textarea 
                        name="notes" 
                        id="notes" 
                        rows="2" 
                        placeholder="Keterangan tambahan..." 
                        class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end space-x-3">
                <a href="{{ route('admin.mutations.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-sm transition">
                    Simpan Catatan Mutasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
