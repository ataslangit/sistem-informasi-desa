@extends('admin.layouts.app')

@section('title', 'Layanan Surat Warga Mandiri')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Layanan Pengajuan Surat Mandiri</h2>
            <p class="text-xs text-slate-500 mt-1">Ajukan permohonan surat administrasi desa secara online dan pantau status verifikasinya.</p>
        </div>
        <div>
            <a href="{{ route('citizen.letters.create') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm space-x-1">
                <span>➕</span>
                <span>Buat Pengajuan Surat</span>
            </a>
        </div>
    </div>

    <!-- Table Surat Warga -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-3 px-4">No. Pengajuan</th>
                        <th class="py-3 px-4">Jenis Surat</th>
                        <th class="py-3 px-4">Keperluan</th>
                        <th class="py-3 px-4">Tgl Pengajuan</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse($requests as $req)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3 px-4 font-mono font-bold text-slate-800">
                                {{ $req->request_number }}
                                @if($req->letter_number)
                                    <div class="text-[10px] text-blue-600 font-semibold">{{ $req->letter_number }}</div>
                                @endif
                            </td>
                            <td class="py-3 px-4 font-semibold text-slate-800">
                                {{ $req->template->name }}
                            </td>
                            <td class="py-3 px-4 text-slate-600 italic">
                                {{ $req->purpose }}
                            </td>
                            <td class="py-3 px-4 text-slate-500 whitespace-nowrap text-[11px]">
                                {{ $req->created_at->translatedFormat('d M Y') }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                @php
                                    $badge = match($req->status) {
                                        'pending_rt' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'pending_staff' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'pending_kades' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                        'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'rejected' => 'bg-rose-50 text-rose-700 border-rose-200',
                                        default => 'bg-slate-50 text-slate-700 border-slate-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $badge }}">
                                    {{ $req->status_label }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center whitespace-nowrap space-x-1">
                                <a href="{{ route('citizen.letters.show', $req) }}" class="inline-flex items-center px-3 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-semibold hover:bg-blue-100 transition">
                                    Pantau
                                </a>
                                @if($req->isApproved())
                                    <a href="{{ route('citizen.letters.pdf', $req) }}" target="_blank" class="inline-flex items-center px-2.5 py-1 rounded-lg bg-emerald-600 text-white text-xs font-semibold hover:bg-emerald-700 transition space-x-1">
                                        <span>📥</span>
                                        <span>Unduh PDF</span>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <p class="text-sm">Anda belum pernah mengajukan permohonan surat.</p>
                                <a href="{{ route('citizen.letters.create') }}" class="inline-block mt-3 px-4 py-2 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition">
                                    Ajukan Surat Sekarang &rarr;
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($requests->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
