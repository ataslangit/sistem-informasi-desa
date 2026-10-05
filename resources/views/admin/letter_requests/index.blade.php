@extends('admin.layouts.app')

@section('title', 'Permohonan E-Surat')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Pelayanan & Permohonan E-Surat</h2>
            <p class="text-xs text-slate-500 mt-1">Daftar permohonan surat masuk warga dengan alur verifikasi 3 tahap: RT/RW -> Staf Desa -> TTE Kepala Desa.</p>
        </div>
    </div>

    <!-- Status Tabs -->
    <div class="flex overflow-x-auto space-x-2 pb-2">
        <a href="{{ route('admin.letter-requests.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition {{ !$status ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            Semua ({{ array_sum($counts) }})
        </a>
        <a href="{{ route('admin.letter-requests.index', ['status' => 'pending_rt']) }}" class="px-3.5 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition {{ $status === 'pending_rt' ? 'bg-amber-500 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            ⏳ Menunggu RT/RW ({{ $counts['pending_rt'] }})
        </a>
        <a href="{{ route('admin.letter-requests.index', ['status' => 'pending_staff']) }}" class="px-3.5 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition {{ $status === 'pending_staff' ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            📋 Menunggu Staf ({{ $counts['pending_staff'] }})
        </a>
        <a href="{{ route('admin.letter-requests.index', ['status' => 'pending_kades']) }}" class="px-3.5 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition {{ $status === 'pending_kades' ? 'bg-indigo-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            ✍️ Menunggu TTE Kades ({{ $counts['pending_kades'] }})
        </a>
        <a href="{{ route('admin.letter-requests.index', ['status' => 'approved']) }}" class="px-3.5 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition {{ $status === 'approved' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            ✅ Disahkan ({{ $counts['approved'] }})
        </a>
        <a href="{{ route('admin.letter-requests.index', ['status' => 'rejected']) }}" class="px-3.5 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition {{ $status === 'rejected' ? 'bg-rose-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            ❌ Ditolak ({{ $counts['rejected'] }})
        </a>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.letter-requests.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <input type="hidden" name="status" value="{{ $status }}">
            <div class="sm:col-span-2">
                <input 
                    type="text" 
                    name="keyword" 
                    value="{{ $keyword }}" 
                    placeholder="Cari No. Permohonan, No. Surat, NIK, atau Nama Warga..." 
                    class="w-full px-4 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
            </div>
            <div>
                <select name="template_id" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="">Semua Jenis Surat</option>
                    @foreach($templates as $tpl)
                        <option value="{{ $tpl->id }}" {{ $templateId == $tpl->id ? 'selected' : '' }}>{{ $tpl->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-700 transition">
                    Filter
                </button>
                @if($keyword || $templateId)
                    <a href="{{ route('admin.letter-requests.index', ['status' => $status]) }}" class="px-3 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-semibold hover:bg-slate-200 transition flex items-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-3 px-4">No. Permohonan / Surat</th>
                        <th class="py-3 px-4">Jenis Surat</th>
                        <th class="py-3 px-4">Nama Pemohon (NIK)</th>
                        <th class="py-3 px-4">Tgl Pengajuan</th>
                        <th class="py-3 px-4 text-center">Status Tahapan</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse($requests as $req)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3 px-4">
                                <div class="font-mono font-bold text-slate-800">{{ $req->request_number }}</div>
                                @if($req->letter_number)
                                    <div class="text-[11px] text-blue-600 font-mono font-semibold">{{ $req->letter_number }}</div>
                                @endif
                            </td>
                            <td class="py-3 px-4 font-semibold text-slate-800">
                                {{ $req->template->name }}
                                <div class="text-[11px] text-slate-400 font-normal italic truncate max-w-xs">{{ $req->purpose }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-bold text-slate-800">{{ $req->resident->name }}</div>
                                <div class="text-[11px] font-mono text-slate-500">
                                    NIK: {{ $req->resident->nik }}
                                    @if($req->resident->family)
                                        (RT {{ $req->resident->family->rt }}/RW {{ $req->resident->family->rw }})
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap text-slate-500 text-[11px]">
                                {{ $req->created_at->translatedFormat('d M Y H:i') }}
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
                                <a href="{{ route('admin.letter-requests.show', $req) }}" class="inline-flex items-center px-3 py-1 rounded-lg bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition">
                                    Proses / Detail
                                </a>
                                @if($req->isApproved())
                                    <a href="{{ route('admin.letter-requests.pdf', $req) }}" target="_blank" class="inline-flex items-center px-2 py-1 rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold hover:bg-slate-200 transition" title="Cetak PDF">
                                        📄 PDF
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">
                                Belum ada permohonan surat pada kriteria ini.
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
