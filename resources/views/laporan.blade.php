@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-3xl font-black tracking-tight text-slate-950 md:text-4xl">Analitik Laba & Rugi</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Pantau performa bisnis, pendapatan, modal HPP, pajak, dan laba bersih berdasarkan periode yang dipilih.</p>
            </div>

            <div class="flex flex-col gap-3 xl:flex-row xl:items-center">
                <form action="{{ route('analytics.laporan') }}" method="GET" class="flex flex-col gap-2 rounded-[1.5rem] border border-white/80 bg-white p-2 shadow-sm sm:flex-row sm:items-center">
                    <input type="date" name="start_date" value="{{ $startDate }}" class="block rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-bold text-slate-600 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required title="Mulai Tanggal">
                    <span class="hidden text-sm font-black text-slate-300 sm:block">—</span>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="block rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-bold text-slate-600 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required title="Sampai Tanggal">
                    <button type="submit" class="rounded-2xl bg-slate-950 px-5 py-2.5 text-sm font-black text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-blue-600">Filter</button>
                </form>

                <a href="{{ route('analytics.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-3 text-sm font-black text-emerald-700 shadow-sm transition hover:-translate-y-0.5 hover:bg-emerald-100">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export Excel
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="group relative overflow-hidden rounded-[2rem] border border-white/80 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/70">
                <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-blue-100/70 transition group-hover:scale-125"></div>
                <div class="relative">
                    <div class="mb-5 flex items-center justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-black text-blue-600">Revenue</span>
                    </div>
                    <p class="text-sm font-bold text-slate-400">Pendapatan Kotor</p>
                    <h3 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Rp {{ number_format($pendapatan, 0, ',', '.') }}</h3>
                    <p class="mt-3 text-xs font-semibold text-slate-400">Periode terpilih tanpa pajak</p>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-[2rem] border border-white/80 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/70">
                <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-rose-100/70 transition group-hover:scale-125"></div>
                <div class="relative">
                    <div class="mb-5 flex items-center justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-50 text-rose-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-black text-rose-600">HPP</span>
                    </div>
                    <p class="text-sm font-bold text-slate-400">Total Modal</p>
                    <h3 class="mt-2 text-2xl font-black tracking-tight text-rose-600">Rp {{ number_format($hpp, 0, ',', '.') }}</h3>
                    <p class="mt-3 text-xs font-semibold text-slate-400">Harga beli dikali jumlah terjual</p>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-[2rem] border border-slate-900 bg-slate-950 p-6 text-white shadow-xl shadow-slate-900/10 transition hover:-translate-y-1 hover:shadow-2xl hover:shadow-blue-600/20">
                <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-emerald-500/25 blur-2xl transition group-hover:scale-125"></div>
                <div class="relative">
                    <div class="mb-5 flex items-center justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"></path>
                            </svg>
                        </div>
                        <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-black text-emerald-200">Profit</span>
                    </div>
                    <p class="text-sm font-bold text-slate-400">Laba Bersih</p>
                    <h3 class="mt-2 text-3xl font-black tracking-tight">Rp {{ number_format($labaBersih, 0, ',', '.') }}</h3>
                    <p class="mt-3 text-xs font-semibold text-slate-400">Pendapatan dikurangi modal</p>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-[2rem] border border-white/80 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/70">
                <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-slate-100 transition group-hover:scale-125"></div>
                <div class="relative">
                    <div class="mb-5 flex items-center justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                            </svg>
                        </div>
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-black text-slate-600">Tax</span>
                    </div>
                    <p class="text-sm font-bold text-slate-400">Pajak 10%</p>
                    <h3 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Rp {{ number_format($pajak, 0, ',', '.') }}</h3>
                    <p class="mt-3 text-xs font-semibold text-slate-400">Estimasi pajak dari transaksi</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="rounded-[2rem] border border-white/80 bg-white p-6 shadow-sm xl:col-span-2">
                <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-black text-slate-950">Tren Pendapatan</h3>
                        <p class="mt-1 text-sm font-semibold text-slate-400">Pendapatan kotor dalam 7 hari terakhir.</p>
                    </div>
                    <span class="w-fit rounded-full bg-blue-50 px-3 py-1 text-xs font-black text-blue-600">7 Hari Terakhir</span>
                </div>

                <div class="relative h-80 w-full rounded-[1.5rem] border border-slate-100 bg-slate-50 p-4">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <div class="rounded-[2rem] border border-white/80 bg-white p-6 shadow-sm">
                <div class="mb-6 flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-black text-slate-950">Produk Terlaris</h3>
                        <p class="mt-1 text-sm font-semibold text-slate-400">Berdasarkan revenue bulan ini.</p>
                    </div>
                    <span class="rounded-full bg-slate-50 px-3 py-1 text-xs font-black text-slate-500">Top</span>
                </div>

                <div class="space-y-4">
                    @forelse ($topProducts as $index => $top)
                        <div class="rounded-3xl border border-slate-100 bg-slate-50 p-4 transition hover:bg-white hover:shadow-sm">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex min-w-0 items-center gap-3">
                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-sm font-black text-blue-600">#{{ $index + 1 }}</div>
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-black text-slate-950">{{ $top->product_name }}</p>
                                        <p class="mt-1 text-xs font-bold text-slate-400">Terjual: {{ $top->total_qty }} Pcs</p>
                                    </div>
                                </div>
                                <div class="shrink-0 text-right">
                                    <p class="text-sm font-black text-blue-600">Rp {{ number_format($top->total_revenue, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex h-56 flex-col items-center justify-center rounded-[1.5rem] border border-dashed border-slate-200 bg-slate-50 text-center text-slate-400">
                            <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-2xl">📊</div>
                            <p class="text-sm font-bold">Belum ada data penjualan bulan ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = {!! json_encode($chartLabels) !!};
        const dataPoints = {!! json_encode($chartData) !!};

        const ctx = document.getElementById('revenueChart').getContext('2d');

        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(37, 99, 235, 0.22)');
        gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan Kotor (Rp)',
                    data: dataPoints,
                    borderColor: '#2563eb',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#2563eb',
                    pointBorderWidth: 3,
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.42
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 14,
                        cornerRadius: 14,
                        titleFont: {
                            size: 13,
                            weight: '700'
                        },
                        bodyFont: {
                            size: 14,
                            weight: '800'
                        },
                        callbacks: {
                            label: function(context) {
                                let value = context.raw;
                                return ' Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: {
                                weight: '700'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#e2e8f0',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: {
                                weight: '700'
                            },
                            callback: function(value) {
                                if (value >= 1000000) return 'Rp ' + (value / 1000000) + ' Jt';
                                if (value >= 1000) return 'Rp ' + (value / 1000) + ' Rb';
                                return value;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
