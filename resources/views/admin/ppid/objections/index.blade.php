@extends('admin.layouts.app')

@section('title', 'Keberatan Informasi Publik (PPID)')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Keberatan Atas Permohonan Informasi Publik</h2>
            <p class="text-xs text-slate-500 mt-1">Daftar pengajuan keberatan masyarakat yang diajukan kepada Atasan PPID (Kepala Desa).</p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
        <a href="{{ route('admin.ppid-objections.index') }}" class="p-3.5 rounded-2xl border transition {{ empty($status) ? 'bg-slate-900 text-white border-slate-900 shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
            <span class="text-xs font-semibold block">Semua</span>
            <span class="text-xl font-black mt-1 block">{{ $counts['total'] }}</span>
        </a>
        <a href="{{ route('admin.ppid-objections.index', ['status' => 'submitted']) }}" class="p-3.5 rounded-2xl border transition {{ $status === 'submitted' ? 'bg-amber-500 text-white border-amber-500 shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
            <span class="text-xs font-semibold block">Menunggu</span>
            <span class="text-xl font-black mt-1 block">{{ $counts['submitted'] }}</span>
        </a>
        <a href="{{ route('admin.ppid-objections.index', ['status' => 'reviewed']) }}" class="p-3.5 rounded-2xl border transition {{ $status === 'reviewed' ? 'bg-blue-600 text-white border-blue-600 shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
            <span class="text-xs font-semibold block">Ditinjau</span>
            <span class="text-xl font-black mt-1 block">{{ $counts['reviewed'] }}</span>
        </a>
        <a href="{{ route('admin.ppid-objections.index', ['status' => 'upheld']) }}" class="p-3.5 rounded-2xl border transition {{ $status === 'upheld' ? 'bg-emerald-600 text-white border-emerald-600 shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
            <span class="text-xs font-semibold block">Diterima</span>
            <span class="text-xl font-black mt-1 block">{{ $counts['upheld'] }}</span>
        </a>
        <a href="{{ route('admin.ppid-objections.index', ['status' => 'rejected']) }}" class="p-3.5 rounded-2xl border transition {{ $status === 'rejected' ? 'bg-rose-600 text-white border-rose-600 shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
            <span class="text-xs font-semibold block">Ditolak</span>
            <span class="text-xl font-black mt-1 block">{{ $counts['rejected'] }}</span>
        </a>
    </div>

    <!-- Table Objections -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                    <tr>
                        <th class="px-5 py-3.5">Tiket Keberatan</th>
                        <th class="px-5 py-3.5">Tiket Asal / Pemohon</th>
                        <th class="px-5 py-3.5">Alasan Keberatan</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($objections as $obj)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-4">
                                <span class="font-mono font-bold text-slate-800 block">{{ $obj->ticket_number }}</span>
                                <span class="text-[11px] text-slate-400">{{ $obj->created_at->format('d/m/Y H:i') }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <a href="{{ route('admin.ppid-requests.show', $obj->request) }}" class="font-mono text-blue-600 hover:underline block">
                                    {{ $obj->request->ticket_number }}
                                </a>
                                <span class="text-slate-800 font-semibold">{{ $obj->request->applicant_name }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="font-bold text-slate-800 block">{{ $obj->reason_label }}</span>
                                <p class="text-slate-500 line-clamp-2 max-w-xs mt-0.5">{{ $obj->objection_detail }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold border {{ $obj->status_badge_class }}">
                                    {{ $obj->status_label }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('admin.ppid-objections.show', $obj) }}" class="inline-flex items-center px-3 py-1.5 rounded-xl bg-amber-50 text-amber-800 hover:bg-amber-100 font-semibold transition space-x-1">
                                    <span>⚖️</span>
                                    <span>Tinjau Kades</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-slate-400">
                                Belum ada pengajuan keberatan informasi publik.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $objections->links() }}
        </div>
    </div>
</div>
@endsection
