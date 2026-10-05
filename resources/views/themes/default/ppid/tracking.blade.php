@extends(theme_layout())

@section('title', 'Lacak Status Tiket Layanan Informasi - PPID Desa')

@section('content')
<!-- Header Banner -->
<section class="bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 text-white py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto text-center">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/20 text-blue-200 border border-blue-400/30 mb-3 space-x-1.5">
            <span>🔍</span>
            <span>Pelacakan Tiket Layanan Informasi</span>
        </span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight">
            Lacak Status Tiket KIP
        </h1>
        <p class="mt-2 text-sm sm:text-base text-blue-100 max-w-xl mx-auto leading-relaxed">
            Pantau status progres tindak lanjut permohonan informasi publik atau pengajuan keberatan Anda secara real-time.
        </p>
    </div>
</section>

<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 sm:p-10 space-y-6">
        @if (session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-xs flex items-center space-x-2">
                <span>⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('public.ppid.tracking.check') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="ticket_number" class="block text-xs font-semibold text-slate-700 mb-1">
                    Nomor Tiket Layanan (INF-... atau KBR-...)
                </label>
                <input 
                    type="text" 
                    name="ticket_number" 
                    id="ticket_number" 
                    required 
                    placeholder="Contoh: INF-20261005-0001 atau KBR-20261005-0001"
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 font-mono text-sm uppercase focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
                <p class="text-[11px] text-slate-400 mt-1">
                    Nomor tiket diberikan saat Anda selesai mengirimkan formulir permohonan informasi daring.
                </p>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow-md transition text-xs flex items-center justify-center space-x-2">
                <span>🔎</span>
                <span>Periksa Status Tiket</span>
            </button>
        </form>

        <div class="pt-6 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-500 mb-2">Belum pernah mengajukan permohonan informasi?</p>
            <a href="{{ route('public.ppid.requests.create') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 space-x-1">
                <span>Ajukan Permohonan Informasi Daring Sekarang &rarr;</span>
            </a>
        </div>
    </div>
</div>
@endsection
