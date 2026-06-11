@extends('layouts.app')

@section('content')
    <div class="space-y-7">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-3xl font-black tracking-tight text-slate-950 md:text-4xl">Dashboard</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                    Pantau ringkasan transaksi, revenue, profit, dan performa produk tokomu dalam satu tampilan yang rapi.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <div class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-600 shadow-sm">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ now()->startOfMonth()->format('d M') }} - {{ now()->endOfMonth()->format('d M Y') }}
                </div>

                <a href="{{ route('analytics.laporan') }}" class="inline-flex items-center gap-2 rounded-2xl bg-slate-950 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-slate-900/15 transition hover:-translate-y-0.5 hover:bg-blue-600">
                    Lihat Laporan
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="group relative overflow-hidden rounded-[2rem] border border-white/80 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/70">
                <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-blue-100/70 transition group-hover:scale-125"></div>
                <div class="relative">
                    <div class="mb-5 flex items-center justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <span class="inline-flex items-center rounded-full border {{ $transactionGrowth >= 0 ? 'border-emerald-100 bg-emerald-50 text-emerald-600' : 'border-rose-100 bg-rose-50 text-rose-600' }} px-2.5 py-1 text-xs font-black">
                            {{ $transactionGrowth >= 0 ? '+' : '' }}{{ $transactionGrowth }}%
                        </span>
                    </div>
                    <p class="text-sm font-bold text-slate-400">Total Transaksi</p>
                    <div class="mt-2 flex items-end justify-between gap-4">
                        <h3 class="text-3xl font-black tracking-tight text-slate-950">{{ number_format($totalTransactions, 0, ',', '.') }}</h3>
                        <p class="text-xs font-semibold text-slate-400">vs bulan lalu</p>
                    </div>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-[2rem] border border-white/80 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/70">
                <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-cyan-100/70 transition group-hover:scale-125"></div>
                <div class="relative">
                    <div class="mb-5 flex items-center justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-cyan-50 text-cyan-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="inline-flex items-center rounded-full border {{ $revenueGrowth >= 0 ? 'border-emerald-100 bg-emerald-50 text-emerald-600' : 'border-rose-100 bg-rose-50 text-rose-600' }} px-2.5 py-1 text-xs font-black">
                            {{ $revenueGrowth >= 0 ? '+' : '' }}{{ $revenueGrowth }}%
                        </span>
                    </div>
                    <p class="text-sm font-bold text-slate-400">Total Revenue</p>
                    <div class="mt-2 flex items-end justify-between gap-4">
                        <h3 class="text-3xl font-black tracking-tight text-slate-950">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                        <p class="text-xs font-semibold text-slate-400">bulan ini</p>
                    </div>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-[2rem] border border-slate-900 bg-slate-950 p-6 text-white shadow-xl shadow-slate-900/10 transition hover:-translate-y-1 hover:shadow-2xl hover:shadow-blue-600/20">
                <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-blue-500/30 blur-2xl transition group-hover:scale-125"></div>
                <div class="relative">
                    <div class="mb-5 flex items-center justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <span class="inline-flex items-center rounded-full border border-emerald-400/20 bg-emerald-400/10 px-2.5 py-1 text-xs font-black text-emerald-300">
                            {{ number_format($profitMargin, 1) }}%
                        </span>
                    </div>
                    <p class="text-sm font-bold text-slate-400">Net Profit</p>
                    <div class="mt-2 flex items-end justify-between gap-4">
                        <h3 class="text-3xl font-black tracking-tight">Rp {{ number_format($netProfit, 0, ',', '.') }}</h3>
                        <p class="text-xs font-semibold text-slate-400">profit margin</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="rounded-[2rem] border border-white/80 bg-white p-6 shadow-sm xl:col-span-2">
                <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-black text-slate-950">Sales Overview</h2>
                        <p class="mt-1 text-sm text-slate-500">Performa pendapatan 7 hari terakhir.</p>
                    </div>
                    <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-black text-blue-600">Revenue</span>
                </div>

                <div class="rounded-[1.5rem] border border-slate-100 bg-slate-50 p-5">
                    <div class="flex h-72 items-end gap-3">
                        @foreach ($salesChart as $chart)
                            @php
                                $height = $maxChartValue > 0 ? max(($chart['value'] / $maxChartValue) * 100, $chart['value'] > 0 ? 8 : 2) : 2;
                            @endphp

                            <div class="flex h-full flex-1 flex-col justify-end gap-3">
                                <div class="rounded-t-2xl {{ $loop->last ? 'bg-blue-600 shadow-lg shadow-blue-600/20' : 'bg-blue-200' }}" style="height: {{ $height }}%"></div>
                                <p class="text-center text-xs font-bold text-slate-400">{{ $chart['label'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="rounded-[2rem] border border-white/80 bg-white p-6 shadow-sm">
                <div class="mb-6 flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-black text-slate-950">Top Products</h2>
                        <p class="mt-1 text-sm text-slate-500">Produk dengan revenue tertinggi.</p>
                    </div>
                    <a href="{{ route('analytics.laporan') }}" class="text-sm font-black text-blue-600 transition hover:text-blue-800">See All</a>
                </div>

                <div class="space-y-4">
                    @forelse ($topProducts as $top)
                        <div class="rounded-3xl border border-slate-100 bg-slate-50 p-4 transition hover:bg-white hover:shadow-sm">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex min-w-0 items-center gap-3">
                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-sm font-black text-blue-600">
                                        {{ strtoupper(substr($top->product_name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="truncate font-black text-slate-950">{{ $top->product_name }}</h3>
                                        <p class="text-sm font-semibold text-slate-400">Terjual {{ $top->total_qty }} pcs</p>
                                    </div>
                                </div>
                                <p class="shrink-0 text-sm font-black text-slate-950">Rp {{ number_format($top->total_revenue, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-6 text-center text-sm font-bold text-slate-400">
                            Belum ada data produk terlaris.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="rounded-[2rem] border border-white/80 bg-white p-6 shadow-sm">
                <div class="mb-5 flex items-center justify-between">
                    <h2 class="text-lg font-black text-slate-950">Payment Method</h2>
                    <span class="rounded-full bg-slate-50 px-3 py-1 text-xs font-black text-slate-500">Today</span>
                </div>

                <div class="space-y-4">
                    @foreach ($paymentStats as $payment)
                        @php
                            $barColor = match (strtolower($payment['method'])) {
                                'cash' => 'bg-emerald-500',
                                'qris' => 'bg-blue-600',
                                'card' => 'bg-orange-400',
                                default => 'bg-slate-500',
                            };
                        @endphp

                        <div>
                            <div class="mb-2 flex justify-between text-sm font-bold text-slate-600">
                                <span>{{ $payment['method'] }}</span>
                                <span>{{ $payment['percentage'] }}%</span>
                            </div>
                            <div class="h-3 rounded-full bg-slate-100">
                                <div class="h-3 rounded-full {{ $barColor }}" style="width: {{ $payment['percentage'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-[2rem] border border-white/80 bg-white p-6 shadow-sm lg:col-span-2">
                <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-black text-slate-950">Recent Transactions</h2>
                        <p class="mt-1 text-sm text-slate-500">Aktivitas transaksi terbaru di toko.</p>
                    </div>
                    <a href="{{ route('analytics.riwayat') }}" class="text-sm font-black text-blue-600 transition hover:text-blue-800">Lihat Detail</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[620px] text-left text-sm">
                        <thead>
                            <tr class="border-b border-slate-100 text-xs uppercase tracking-[0.14em] text-slate-400">
                                <th class="pb-3 font-black">Invoice</th>
                                <th class="pb-3 font-black">Item</th>
                                <th class="pb-3 font-black">Method</th>
                                <th class="pb-3 text-right font-black">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($recentTransactions as $trx)
                                <tr>
                                    <td class="py-4 font-black text-slate-950">{{ $trx->invoice_no }}</td>
                                    <td class="py-4 font-semibold text-slate-500">{{ $trx->details->sum('qty') }} Produk</td>
                                    <td class="py-4">
                                        @if (strtolower($trx->payment_method) == 'cash')
                                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-600">Cash</span>
                                        @elseif (strtolower($trx->payment_method) == 'qris')
                                            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-black text-blue-600">QRIS</span>
                                        @else
                                            <span class="rounded-full bg-orange-50 px-3 py-1 text-xs font-black text-orange-600">Card</span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-right font-black text-slate-950">Rp {{ number_format($trx->grand_total, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-sm font-bold text-slate-400">Belum ada transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="rounded-[2rem] border border-white/80 bg-white p-6 shadow-sm">
                <p class="text-sm font-bold text-slate-400">Total Produk</p>
                <h3 class="mt-2 text-3xl font-black text-slate-950">{{ number_format($totalProducts, 0, ',', '.') }}</h3>
            </div>

            <div class="rounded-[2rem] border border-white/80 bg-white p-6 shadow-sm">
                <p class="text-sm font-bold text-slate-400">Produk Stok Menipis</p>
                <h3 class="mt-2 text-3xl font-black {{ $lowStockProducts > 0 ? 'text-rose-600' : 'text-slate-950' }}">{{ number_format($lowStockProducts, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
@endsection