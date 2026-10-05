@extends('themes.default.layouts.app')

@section('title', 'Transparansi APBDes ' . ($selectedYear ?? date('Y')) . ' - ' . \App\Models\Setting::get('village_name', 'Desa Sukamaju'))

@section('content')
<!-- Header Banner -->
<section class="bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900 text-white py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-200 border border-emerald-400/30 mb-3 space-x-1.5">
            <span>📊</span>
            <span>Akuntabilitas & Transparansi Publik</span>
        </span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight">
            Transparansi APBDes {{ $selectedYear }}
        </h1>
        <p class="mt-2 text-sm sm:text-base text-emerald-100 max-w-2xl leading-relaxed">
            Publikasi resmi Anggaran Pendapatan dan Belanja Desa (APBDes) {{ \App\Models\Setting::get('village_name', 'Desa Sukamaju') }} sebagai wujud keterbukaan informasi dan tata kelola keuangan desa yang akuntabel.
        </p>

        <!-- Selector Tahun Anggaran -->
        @if($budgets->count() > 1)
            <div class="mt-6 flex flex-wrap items-center gap-2">
                <span class="text-xs text-emerald-200 font-semibold mr-2">Pilih Tahun:</span>
                @foreach($budgets as $b)
                    <a 
                        href="{{ route('budgets.index', ['year' => $b->year]) }}" 
                        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $b->year === $selectedYear ? 'bg-white text-emerald-900 shadow-sm' : 'bg-emerald-800/60 text-emerald-100 hover:bg-emerald-700/60 border border-emerald-600/40' }}"
                    >
                        Tahun {{ $b->year }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    @if(!$budget)
        <div class="p-16 text-center text-slate-400 bg-white rounded-3xl border border-dashed border-slate-200">
            <div class="text-5xl mb-3">📈</div>
            <h3 class="text-base font-bold text-slate-700">Data APBDes Belum Tersedia</h3>
            <p class="text-xs text-slate-400 mt-1">Data anggaran pendapatan dan belanja desa untuk tahun {{ $selectedYear }} belum dipublikasikan.</p>
        </div>
    @else
        <!-- Ringkasan 4 Kartu Utama -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Pendapatan -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-600">Pendapatan Desa</span>
                    <span class="p-2 bg-emerald-50 text-emerald-600 rounded-xl text-sm">💰</span>
                </div>
                <div class="text-xl font-black text-slate-800">
                    Rp {{ number_format($budget->total_realized_revenue, 0, ',', '.') }}
                </div>
                <div class="text-xs text-slate-500 flex items-center justify-between pt-2 border-t border-slate-100">
                    <span>Anggaran: Rp {{ number_format($budget->total_budgeted_revenue, 0, ',', '.') }}</span>
                    <span class="font-bold text-emerald-600">{{ $budget->revenue_realization_percentage }}%</span>
                </div>
            </div>

            <!-- Belanja -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-rose-600">Belanja Desa</span>
                    <span class="p-2 bg-rose-50 text-rose-600 rounded-xl text-sm">🛒</span>
                </div>
                <div class="text-xl font-black text-slate-800">
                    Rp {{ number_format($budget->total_realized_expenditure, 0, ',', '.') }}
                </div>
                <div class="text-xs text-slate-500 flex items-center justify-between pt-2 border-t border-slate-100">
                    <span>Anggaran: Rp {{ number_format($budget->total_budgeted_expenditure, 0, ',', '.') }}</span>
                    <span class="font-bold text-rose-600">{{ $budget->expenditure_realization_percentage }}%</span>
                </div>
            </div>

            <!-- Pembiayaan Neto -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-600">Pembiayaan Neto</span>
                    <span class="p-2 bg-blue-50 text-blue-600 rounded-xl text-sm">⚖️</span>
                </div>
                @php
                    $penerimaan = $budget->financings->where('category', 'like', '%Penerimaan%')->sum('realized_amount');
                    $pengeluaran = $budget->financings->where('category', 'like', '%Pengeluaran%')->sum('realized_amount');
                    $neto = $penerimaan - $pengeluaran;
                @endphp
                <div class="text-xl font-black text-slate-800">
                    Rp {{ number_format($neto, 0, ',', '.') }}
                </div>
                <div class="text-xs text-slate-500 pt-2 border-t border-slate-100">
                    <span>Penerimaan - Pengeluaran</span>
                </div>
            </div>

            <!-- Surplus / Defisit -->
            @php
                $surplusRealized = $budget->surplus_deficit_realized;
            @endphp
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Surplus / (Defisit)</span>
                    <span class="p-2 bg-slate-100 text-slate-600 rounded-xl text-sm">📊</span>
                </div>
                <div class="text-xl font-black {{ $surplusRealized >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                    Rp {{ number_format($surplusRealized, 0, ',', '.') }}
                </div>
                <div class="text-xs text-slate-500 pt-2 border-t border-slate-100">
                    <span>{{ $surplusRealized >= 0 ? 'Surplus Realisasi Anggaran' : 'Defisit Anggaran Terkendali' }}</span>
                </div>
            </div>
        </div>

        <!-- Visualisasi Grafik Interaktif Chart.js -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Grafik Bar: Realisasi vs Anggaran -->
            <div class="lg:col-span-2 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Capaian Realisasi vs Target Anggaran</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Perbandingan total pendapatan desa dan realisasi belanja dalam Rupiah.</p>
                </div>
                <div class="h-72 w-full">
                    <canvas id="overviewChart"></canvas>
                </div>
            </div>

            <!-- Grafik Donut: Komposisi Belanja Desa -->
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-4 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Komposisi Bidang Belanja</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Proporsi pembagian alokasi realisasi belanja desa.</p>
                </div>
                <div class="h-60 w-full flex items-center justify-center">
                    <canvas id="expenditureDonutChart"></canvas>
                </div>
                <p class="text-[11px] text-center text-slate-400">Data bersumber dari Sistem Keuangan Desa (Siskeudes).</p>
            </div>
        </div>

        <!-- Rincian Tabel Transparansi APBDes -->
        <div class="space-y-8">
            <!-- 1. Tabel Pendapatan Desa -->
            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="p-6 bg-gradient-to-r from-emerald-50 to-white border-b border-slate-200 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-slate-800 text-base flex items-center space-x-2">
                            <span>1.</span>
                            <span>Pendapatan Desa (Akun 4)</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Rincian sumber pendapatan asli desa, dana transfer APBN, dan bagi hasil daerah.</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                        Total: Rp {{ number_format($budget->total_realized_revenue, 0, ',', '.') }}
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 text-slate-600 font-bold uppercase tracking-wider border-b border-slate-200">
                                <th class="py-3 px-6">Sumber / Rekening Pendapatan</th>
                                <th class="py-3 px-6 text-right">Anggaran (Rp)</th>
                                <th class="py-3 px-6 text-right">Realisasi (Rp)</th>
                                <th class="py-3 px-6 text-center">% Capaian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($budget->revenues as $rev)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3 px-6 font-semibold text-slate-800">{{ $rev->category }}</td>
                                    <td class="py-3 px-6 text-right font-mono">{{ number_format($rev->budgeted_amount, 0, ',', '.') }}</td>
                                    <td class="py-3 px-6 text-right font-mono font-bold text-emerald-700">{{ number_format($rev->realized_amount, 0, ',', '.') }}</td>
                                    <td class="py-3 px-6 text-center font-bold">
                                        <span class="px-2 py-0.5 rounded-full text-[11px] {{ $rev->realization_percentage >= 100 ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                            {{ $rev->realization_percentage }}%
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-slate-400">Belum ada rincian data pendapatan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 2. Tabel Belanja Desa -->
            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="p-6 bg-gradient-to-r from-rose-50 to-white border-b border-slate-200 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-slate-800 text-base flex items-center space-x-2">
                            <span>2.</span>
                            <span>Belanja Desa (Akun 5)</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Rincian belanja per bidang pembangunan, kemasyarakatan, dan pemerintahan.</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800">
                        Total: Rp {{ number_format($budget->total_realized_expenditure, 0, ',', '.') }}
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 text-slate-600 font-bold uppercase tracking-wider border-b border-slate-200">
                                <th class="py-3 px-6">Bidang Belanja</th>
                                <th class="py-3 px-6 text-right">Anggaran (Rp)</th>
                                <th class="py-3 px-6 text-right">Realisasi (Rp)</th>
                                <th class="py-3 px-6 text-center">% Capaian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($budget->expenditures as $exp)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3 px-6 font-semibold text-slate-800">{{ $exp->category }}</td>
                                    <td class="py-3 px-6 text-right font-mono">{{ number_format($exp->budgeted_amount, 0, ',', '.') }}</td>
                                    <td class="py-3 px-6 text-right font-mono font-bold text-rose-700">{{ number_format($exp->realized_amount, 0, ',', '.') }}</td>
                                    <td class="py-3 px-6 text-center font-bold">
                                        <span class="px-2 py-0.5 rounded-full text-[11px] {{ $exp->realization_percentage >= 90 ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                            {{ $exp->realization_percentage }}%
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-slate-400">Belum ada rincian data belanja.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 3. Tabel Pembiayaan Desa -->
            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="p-6 bg-gradient-to-r from-blue-50 to-white border-b border-slate-200 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-slate-800 text-base flex items-center space-x-2">
                            <span>3.</span>
                            <span>Pembiayaan Desa (Akun 6)</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Penerimaan SiLPA dan pengeluaran penyertaan modal desa.</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 text-slate-600 font-bold uppercase tracking-wider border-b border-slate-200">
                                <th class="py-3 px-6">Uraian Pembiayaan</th>
                                <th class="py-3 px-6 text-right">Anggaran (Rp)</th>
                                <th class="py-3 px-6 text-right">Realisasi (Rp)</th>
                                <th class="py-3 px-6 text-center">% Capaian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($budget->financings as $fin)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3 px-6 font-semibold text-slate-800">{{ $fin->category }}</td>
                                    <td class="py-3 px-6 text-right font-mono">{{ number_format($fin->budgeted_amount, 0, ',', '.') }}</td>
                                    <td class="py-3 px-6 text-right font-mono font-bold text-blue-700">{{ number_format($fin->realized_amount, 0, ',', '.') }}</td>
                                    <td class="py-3 px-6 text-center font-bold">
                                        <span class="px-2 py-0.5 rounded-full text-[11px] bg-blue-50 text-blue-700">
                                            {{ $fin->realization_percentage }}%
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-slate-400">Belum ada rincian data pembiayaan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if($budget)
            const chartData = @json($chartData);

            // 1. Overview Bar Chart
            const ctxOverview = document.getElementById('overviewChart');
            if (ctxOverview) {
                new Chart(ctxOverview, {
                    type: 'bar',
                    data: {
                        labels: chartData.overview.labels,
                        datasets: [
                            {
                                label: 'Target Anggaran (Rp)',
                                data: chartData.overview.budgeted,
                                backgroundColor: '#94a3b8',
                                borderRadius: 8,
                            },
                            {
                                label: 'Realisasi (Rp)',
                                data: chartData.overview.realized,
                                backgroundColor: ['#059669', '#e11d48'],
                                borderRadius: 8,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'top' },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + (value / 1000000) + ' Jt';
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // 2. Expenditure Doughnut Chart
            const ctxDonut = document.getElementById('expenditureDonutChart');
            if (ctxDonut) {
                new Chart(ctxDonut, {
                    type: 'doughnut',
                    data: {
                        labels: chartData.expenditures.labels,
                        datasets: [{
                            data: chartData.expenditures.values,
                            backgroundColor: [
                                '#3b82f6',
                                '#10b981',
                                '#f59e0b',
                                '#8b5cf6',
                                '#ef4444'
                            ],
                            borderWidth: 2,
                            borderColor: '#ffffff',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                    }
                                }
                            }
                        },
                        cutout: '65%'
                    }
                });
            }
        @endif
    });
</script>
@endsection
