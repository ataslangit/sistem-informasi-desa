@extends('admin.layouts.app')

@section('title', 'Permohonan Informasi Publik (PPID)')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Permohonan Informasi Publik Daring</h2>
            <p class="text-xs text-slate-500 mt-1">Daftar permohonan informasi masuk dari masyarakat yang wajib ditindaklanjuti PPID Desa.</p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
        <a href="{{ route('admin.ppid-requests.index') }}" class="p-3.5 rounded-2xl border transition {{ empty($status) ? 'bg-slate-900 text-white border-slate-900 shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
            <span class="text-xs font-semibold block">Semua</span>
            <span class="text-xl font-black mt-1 block">{{ $counts['total'] }}</span>
        </a>
        <a href="{{ route('admin.ppid-requests.index', ['status' => 'submitted']) }}" class="p-3.5 rounded-2xl border transition {{ $status === 'submitted' ? 'bg-amber-500 text-white border-amber-500 shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
            <span class="text-xs font-semibold block">Menunggu</span>
            <span class="text-xl font-black mt-1 block">{{ $counts['submitted'] }}</span>
        </a>
        <a href="{{ route('admin.ppid-requests.index', ['status' => 'processed']) }}" class="p-3.5 rounded-2xl border transition {{ $status === 'processed' ? 'bg-blue-600 text-white border-blue-600 shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
            <span class="text-xs font-semibold block">Diproses</span>
            <span class="text-xl font-black mt-1 block">{{ $counts['processed'] }}</span>
        </a>
        <a href="{{ route('admin.ppid-requests.index', ['status' => 'approved']) }}" class="p-3.5 rounded-2xl border transition {{ $status === 'approved' ? 'bg-emerald-600 text-white border-emerald-600 shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
            <span class="text-xs font-semibold block">Disetujui</span>
            <span class="text-xl font-black mt-1 block">{{ $counts['approved'] }}</span>
        </a>
        <a href="{{ route('admin.ppid-requests.index', ['status' => 'rejected']) }}" class="p-3.5 rounded-2xl border transition {{ $status === 'rejected' ? 'bg-rose-600 text-white border-rose-600 shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
            <span class="text-xs font-semibold block">Ditolak</span>
            <span class="text-xl font-black mt-1 block">{{ $counts['rejected'] }}</span>
        </a>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.ppid-requests.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="sm:col-span-2">
                <input 
                    type="text" 
                    name="keyword" 
                    value="{{ $keyword }}" 
                    placeholder="Cari nomor tiket, nama pemohon, atau email..." 
                    class="w-full px-4 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-700 transition">
                    Cari
                </button>
                @if($keyword || $status)
                    <a href="{{ route('admin.ppid-requests.index') }}" class="px-3 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-semibold hover:bg-slate-200 transition flex items-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Requests -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                    <tr>
                        <th class="px-5 py-3.5">Nomor Tiket & Tanggal</th>
                        <th class="px-5 py-3.5">Pemohon</th>
                        <th class="px-5 py-3.5">Informasi yang Dimohon</th>
                        <th class="px-5 py-3.5">Cara Peroleh</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($requests as $req)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-4">
                                <span class="font-mono font-bold text-slate-800 block">{{ $req->ticket_number }}</span>
                                <span class="text-[11px] text-slate-400">{{ $req->created_at->format('d/m/Y H:i') }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="font-bold text-slate-800 block">{{ $req->applicant_name }}</span>
                                <span class="text-[11px] text-slate-500">{{ $req->applicant_phone }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <p class="text-slate-700 line-clamp-2 max-w-xs">{{ $req->information_requested }}</p>
                                <span class="text-[10px] text-slate-400 block mt-0.5">Tujuan: {{ Str::limit($req->purpose, 40) }}</span>
                            </td>
                            <td class="px-5 py-4 text-slate-600 capitalize">
                                {{ str_replace('_', ' ', $req->acquisition_way) }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold border {{ $req->status_badge_class }}">
                                    {{ $req->status_label }}
                                </span>
                                @if($req->objection)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-100 text-amber-800 mt-1 block w-max">
                                        Ada Keberatan
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('admin.ppid-requests.show', $req) }}" class="inline-flex items-center px-3 py-1.5 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-100 font-semibold transition space-x-1">
                                    <span>🔍</span>
                                    <span>Tindak Lanjut</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-400">
                                Belum ada permohonan informasi publik.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $requests->links() }}
        </div>
    </div>
</div>
@endsection
