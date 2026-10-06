@extends('admin.layouts.app')

@section('title', 'Biodata Penduduk: ' . $resident->name)

@section('content')
<div class="space-y-6">
    <!-- Top Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.residents.index') }}" class="text-xs text-slate-500 hover:text-slate-800">Buku Induk</a>
                <span class="text-xs text-slate-400">/</span>
                <span class="text-xs font-semibold text-slate-700">Biodata Penduduk</span>
            </div>
            <h2 class="text-xl font-bold text-slate-800 mt-1">{{ $resident->name }}</h2>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.residents.edit', $resident) }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
                Edit Biodata
            </a>
            <a href="{{ route('admin.residents.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                Kembali
            </a>
        </div>
    </div>

    <!-- Main Biodata Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Col 1: Summary & Account Cards -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex flex-col items-center text-center">
                <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-bold flex items-center justify-center text-4xl shadow-md mb-4">
                    {{ strtoupper(substr($resident->name, 0, 1)) }}
                </div>
                <h3 class="text-lg font-bold text-slate-800">{{ $resident->name }}</h3>
                <p class="font-mono text-sm text-slate-500 mt-0.5">{{ $resident->nik }}</p>

                <div class="mt-4 flex flex-wrap justify-center gap-2">
                    @if($resident->status === 'active')
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">Warga Aktif</span>
                    @elseif($resident->status === 'deceased')
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-200 text-slate-800">Meninggal Dunia</span>
                    @elseif($resident->status === 'moved')
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">Pindah Keluar</span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">{{ $resident->status }}</span>
                    @endif

                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                        {{ $resident->gender_label }} &bull; {{ $resident->age }} Th
                    </span>
                </div>

                <div class="w-full mt-6 pt-6 border-t border-slate-100 text-left space-y-3 text-xs">
                    <div>
                        <span class="text-slate-400 block">Hubungan dalam Keluarga</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $resident->family_relationship_status }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Pekerjaan</span>
                        <span class="font-semibold text-slate-800">{{ $resident->occupation }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Pendidikan Terakhir</span>
                        <span class="font-semibold text-slate-800">{{ $resident->education_level }}</span>
                    </div>
                </div>
            </div>

            <!-- Kartu Status Akun Layanan Mandiri -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-3.5">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center space-x-1.5">
                        <span>📱</span>
                        <span>Akun Layanan Mandiri</span>
                    </span>
                    @if($resident->user)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                            Aktif
                        </span>
                    @else
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500">
                            Belum Ada
                        </span>
                    @endif
                </div>

                @if($resident->user)
                    <div class="p-3 bg-slate-50 rounded-xl space-y-1.5 text-xs">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400">Username:</span>
                            <span class="font-mono font-bold text-slate-700">{{ $resident->user->username }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400">Email:</span>
                            <span class="text-slate-700 font-medium truncate max-w-[140px]">{{ $resident->user->email }}</span>
                        </div>
                    </div>

                    @if(auth()->user()->hasRole('superadmin'))
                        <a href="{{ route('admin.users.edit', $resident->user) }}" class="w-full inline-flex items-center justify-center px-3 py-2 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 transition">
                            Kelola Akun Pengguna &rsaquo;
                        </a>
                    @endif
                @else
                    <p class="text-[11px] text-slate-500 leading-relaxed">
                        Warga ini belum memiliki akun untuk mengajukan permohonan surat secara online.
                    </p>

                    <div x-data="{ open: false }">
                        <button 
                            type="button" 
                            @click="open = !open" 
                            class="w-full inline-flex items-center justify-center px-3.5 py-2.5 rounded-xl text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white transition shadow-sm space-x-1.5"
                        >
                            <span>🔑</span>
                            <span x-text="open ? 'Tutup Formulir' : 'Buatkan Akun Layanan Mandiri'"></span>
                        </button>

                        <form 
                            x-show="open" 
                            x-transition
                            action="{{ route('admin.residents.create-account', $resident) }}" 
                            method="POST" 
                            class="mt-3 p-3.5 bg-blue-50/60 rounded-xl border border-blue-200 space-y-3"
                        >
                            @csrf
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">
                                    Alamat Email Warga <span class="text-rose-500">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    required 
                                    value="{{ old('email', $resident->nik . '@warga.desa.id') }}"
                                    class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 bg-white"
                                >
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">
                                    Kata Sandi Akun <span class="text-rose-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="password" 
                                    required 
                                    placeholder="Minimal 8 karakter..."
                                    value="desa123456"
                                    class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500 bg-white"
                                >
                                <span class="text-[10px] text-slate-500 block mt-0.5">Password awal (bisa diubah warga nanti).</span>
                            </div>

                            <button 
                                type="submit" 
                                class="w-full py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg transition shadow-2xs"
                            >
                                Simpan & Berikan Akses
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <!-- Col 2: Detailed Attributes -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-6">
            <div>
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">
                    Informasi Demografi & Akta
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-3 bg-slate-50 rounded-xl">
                        <span class="text-slate-500 block mb-0.5">Tempat & Tanggal Lahir</span>
                        <span class="font-bold text-slate-800">{{ $resident->formatted_ttl }}</span>
                    </div>

                    <div class="p-3 bg-slate-50 rounded-xl">
                        <span class="text-slate-500 block mb-0.5">Golongan Darah</span>
                        <span class="font-bold text-slate-800">{{ $resident->blood_type ?: '-' }}</span>
                    </div>

                    <div class="p-3 bg-slate-50 rounded-xl">
                        <span class="text-slate-500 block mb-0.5">Agama</span>
                        <span class="font-bold text-slate-800">{{ $resident->religion }}</span>
                    </div>

                    <div class="p-3 bg-slate-50 rounded-xl">
                        <span class="text-slate-500 block mb-0.5">Status Perkawinan</span>
                        <span class="font-bold text-slate-800">{{ $resident->marital_status }}</span>
                    </div>

                    <div class="p-3 bg-slate-50 rounded-xl">
                        <span class="text-slate-500 block mb-0.5">Nama Ayah</span>
                        <span class="font-bold text-slate-800">{{ $resident->father_name ?: '-' }}</span>
                    </div>

                    <div class="p-3 bg-slate-50 rounded-xl">
                        <span class="text-slate-500 block mb-0.5">Nama Ibu</span>
                        <span class="font-bold text-slate-800">{{ $resident->mother_name ?: '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Family Card Link -->
            <div>
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 border-b border-slate-100 pb-2">
                    Kartu Keluarga (KK)
                </h4>
                @if($resident->family)
                    <div class="p-4 bg-blue-50/50 rounded-xl border border-blue-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <span class="text-xs text-blue-600 font-semibold block">Nomor KK:</span>
                            <span class="font-mono text-base font-bold text-slate-800">{{ $resident->family->family_card_number }}</span>
                            <p class="text-xs text-slate-500 mt-1">{{ $resident->family->full_address }}</p>
                        </div>
                        <a href="{{ route('admin.families.show', $resident->family) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl text-center transition">
                            Lihat Kartu Keluarga →
                        </a>
                    </div>
                @else
                    <div class="p-4 bg-slate-50 rounded-xl text-xs text-slate-500">
                        Penduduk ini belum terdaftar di dalam Kartu Keluarga mana pun.
                    </div>
                @endif
            </div>

            <!-- Mutation History Timeline -->
            <div>
                <div class="flex items-center justify-between mb-3 border-b border-slate-100 pb-2">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center space-x-1.5">
                        <span>📜</span>
                        <span>Riwayat Mutasi &amp; Peristiwa Warga</span>
                    </h4>
                    <a href="{{ route('admin.mutations.create', ['resident_id' => $resident->id]) }}" class="text-[11px] font-semibold text-blue-600 hover:text-blue-800">
                        + Catat Mutasi
                    </a>
                </div>

                @if($resident->mutations->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($resident->mutations as $mut)
                            <div class="p-4 rounded-xl border border-slate-200 bg-white hover:border-slate-300 transition text-xs space-y-2">
                                <div class="flex items-center justify-between pb-1.5 border-b border-slate-100">
                                    <div class="flex items-center space-x-2">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $mut->type_badge_class }}">
                                            @if($mut->type === 'birth') 👶 Kelahiran
                                            @elseif($mut->type === 'death') 🕊️ Kematian
                                            @elseif($mut->type === 'moved_out') 📦 Pindah Keluar
                                            @elseif($mut->type === 'moved_in') 🏡 Pindah Datang
                                            @else {{ $mut->type_label }} @endif
                                        </span>
                                    </div>
                                    <span class="text-slate-500 font-mono text-[11px]">
                                        📅 {{ $mut->date ? $mut->date->translatedFormat('d F Y') : '-' }}
                                    </span>
                                </div>

                                <div>
                                    <span class="text-slate-400 text-[11px]">Keterangan:</span>
                                    <p class="font-semibold text-slate-800 mt-0.5">{{ $mut->reason ?: '-' }}</p>
                                </div>

                                @if($mut->formatted_target_address)
                                    <div class="p-2.5 rounded-lg bg-slate-50 text-[11px] text-slate-600">
                                        <span class="font-semibold block text-slate-700">📍 Tujuan:</span>
                                        {{ $mut->formatted_target_address }}
                                    </div>
                                @endif

                                @if($mut->notes)
                                    <p class="text-slate-500 italic text-[11px]">"{{ $mut->notes }}"</p>
                                @endif

                                <div class="pt-1.5 flex flex-wrap items-center justify-between text-[10px] text-slate-400 border-t border-slate-100">
                                    <span>
                                        @if($mut->reference_number)
                                            No. Berkas: <strong class="font-mono text-slate-600">{{ $mut->reference_number }}</strong>
                                        @endif
                                    </span>
                                    <span>
                                        Dicatat oleh: <strong class="text-slate-600">{{ $mut->creator?->name ?? 'Sistem' }}</strong>
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 text-center">
                        <p class="text-xs text-slate-400 italic">Belum ada catatan mutasi atau peristiwa kependudukan untuk warga ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
