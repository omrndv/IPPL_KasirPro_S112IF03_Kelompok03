@extends('layouts.app')

@section('content')
    @php
        $user = auth()->user();
        $outlet = $user->outlet ?? null;

        $outletName = $outlet->name ?? 'Outlet belum diatur';
        $role = $user->role ?? 'owner';

        $roleLabel = match ($role) {
            'owner' => 'Owner',
            'admin' => 'Admin',
            'cashier' => 'Kasir',
            default => ucfirst($role),
        };
    @endphp

    <div class="space-y-7">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <div class="mb-3 flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-xs font-black text-blue-700">
                        <span class="h-2 w-2 rounded-full bg-blue-600"></span>
                        {{ $outletName }}
                    </span>

                    <span class="inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-1 text-xs font-black text-slate-600">
                        Role: {{ $roleLabel }}
                    </span>
                </div>

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

        {{-- AI Target Sales Tracker --}}
        <div class="rounded-[2.2rem] border border-white bg-white/70 p-6 shadow-md backdrop-blur-md">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex-1 space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="text-xl">🎯</span>
                        <h2 class="text-lg font-black tracking-tight text-slate-950">AI Target Sales Tracker</h2>
                        <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-black {{ $targetStatusColor }}">
                            {{ $targetStatus }}
                        </span>
                    </div>
                    <p class="text-sm font-semibold text-slate-500">
                        @if($targetSales > 0)
                            Target omzet bulan ini adalah <strong class="text-slate-800">Rp {{ number_format($targetSales, 0, ',', '.') }}</strong>. Sisa hari: <strong class="text-slate-800">{{ $remainingDays }} hari</strong>.
                        @else
                            Target penjualan bulanan belum diatur. Silakan atur target omzet di <a href="{{ route('settings.index') }}" class="font-black text-blue-600 hover:underline">Pengaturan Sistem</a>.
                        @endif
                    </p>
                </div>

                @if($targetSales > 0)
                <div class="flex flex-wrap items-center gap-6">
                    <div class="text-right">
                        <p class="text-xs font-bold text-slate-400 uppercase">Proyeksi Akhir Bulan</p>
                        <p class="text-xl font-black text-slate-950">Rp {{ number_format($projectedRevenue, 0, ',', '.') }}</p>
                        <p class="text-[10px] font-semibold text-slate-400">berdasarkan kecepatan transaksi saat ini</p>
                    </div>

                    <div class="relative flex h-16 w-16 items-center justify-center">
                        <svg class="absolute transform -rotate-90" viewBox="0 0 36 36" width="64" height="64">
                            <path class="text-slate-100" stroke-width="4" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="text-blue-600 transition-all duration-500 ease-out" stroke-dasharray="{{ $targetProgress }}, 100" stroke-width="4" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <span class="text-sm font-black text-slate-950">{{ $targetProgress }}%</span>
                    </div>
                </div>
                @endif
            </div>
            
            @if($targetSales > 0)
            <div class="mt-5 h-2.5 w-full rounded-full bg-slate-100 overflow-hidden">
                <div class="h-full rounded-full bg-gradient-to-r from-blue-500 via-cyan-400 to-blue-600 transition-all duration-500" style="width: {{ $targetProgress }}%"></div>
            </div>
            @endif
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
                        <h3 class="text-3xl font-black tracking-tight text-slate-950">
                            {{ number_format($totalTransactions, 0, ',', '.') }}
                        </h3>
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
                        <h3 class="text-3xl font-black tracking-tight text-slate-950">
                            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                        </h3>
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
                        <h3 class="text-3xl font-black tracking-tight">
                            Rp {{ number_format($netProfit, 0, ',', '.') }}
                        </h3>
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
                                $height = $maxChartValue > 0
                                    ? max(($chart['value'] / $maxChartValue) * 100, $chart['value'] > 0 ? 8 : 2)
                                    : 2;
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

                    <a href="{{ route('analytics.laporan') }}" class="text-sm font-black text-blue-600 transition hover:text-blue-800">
                        See All
                    </a>
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
                                        <h3 class="truncate font-black text-slate-950">
                                            {{ $top->product_name }}
                                        </h3>
                                        <p class="text-sm font-semibold text-slate-400">
                                            Terjual {{ $top->total_qty }} pcs
                                        </p>
                                    </div>
                                </div>

                                <p class="shrink-0 text-sm font-black text-slate-950">
                                    Rp {{ number_format($top->total_revenue, 0, ',', '.') }}
                                </p>
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
                        <p class="mt-1 text-sm text-slate-500">Aktivitas transaksi terbaru di outlet ini.</p>
                    </div>

                    <a href="{{ route('analytics.riwayat') }}" class="text-sm font-black text-blue-600 transition hover:text-blue-800">
                        Lihat Detail
                    </a>
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
                                    <td class="py-4 font-black text-slate-950">
                                        {{ $trx->invoice_no }}
                                    </td>

                                    <td class="py-4 font-semibold text-slate-500">
                                        {{ $trx->details->sum('qty') }} Produk
                                    </td>

                                    <td class="py-4">
                                        @if (strtolower($trx->payment_method) == 'cash')
                                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-600">Cash</span>
                                        @elseif (strtolower($trx->payment_method) == 'qris')
                                            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-black text-blue-600">QRIS</span>
                                        @else
                                            <span class="rounded-full bg-orange-50 px-3 py-1 text-xs font-black text-orange-600">Card</span>
                                        @endif
                                    </td>

                                    <td class="py-4 text-right font-black text-slate-950">
                                        Rp {{ number_format($trx->grand_total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-sm font-bold text-slate-400">
                                        Belum ada transaksi di outlet ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="rounded-[2rem] border border-white/80 bg-white p-6 shadow-sm">
                <p class="text-sm font-bold text-slate-400">Total Produk Outlet</p>
                <h3 class="mt-2 text-3xl font-black text-slate-950">
                    {{ number_format($totalProducts, 0, ',', '.') }}
                </h3>
            </div>

            <div class="rounded-[2rem] border border-white/80 bg-white p-6 shadow-sm">
                <p class="text-sm font-bold text-slate-400">Produk Stok Menipis</p>
                <h3 class="mt-2 text-3xl font-black {{ $lowStockProducts > 0 ? 'text-rose-600' : 'text-slate-950' }}">
                    {{ number_format($lowStockProducts, 0, ',', '.') }}
                </h3>
            </div>
        </div>
    </div>

    <!-- Floating AI Chat Button -->
    <div class="fixed bottom-6 right-6 z-50">
        <button id="btn-toggle-ai" class="flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white shadow-xl shadow-blue-500/30 transition-all duration-300 hover:scale-110 hover:shadow-2xl hover:shadow-indigo-600/40 focus:outline-none" title="Tanya Asisten AI">
            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
        </button>
    </div>

    <!-- AI Chat Window -->
    <div id="ai-chat-window" class="fixed bottom-24 right-6 z-50 hidden w-[500px] max-w-[calc(100vw-2rem)] overflow-hidden rounded-[2rem] border border-slate-100 bg-white/95 shadow-2xl shadow-slate-900/15 backdrop-blur-md transition-all duration-300 transform scale-95 opacity-0">
        <!-- Header -->
        <div class="flex items-center justify-between bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 text-white">
            <div class="flex items-center gap-3.5">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/20 text-xl font-black">✨</div>
                <div>
                    <h3 class="text-base font-black tracking-tight">KasirPro AI Assistant</h3>
                    <p class="text-xs font-semibold text-blue-100">Analisis bisnis real-time tokomu</p>
                </div>
            </div>
            <div class="flex items-center gap-1">
                <button id="btn-clear-ai" title="Hapus riwayat chat" class="rounded-lg p-1.5 text-blue-100 hover:bg-white/10 hover:text-white transition">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
                <button id="btn-close-ai" title="Tutup" class="rounded-lg p-1.5 text-blue-100 hover:bg-white/10 hover:text-white transition">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Chat Messages -->
        <div id="ai-chat-messages" class="h-[440px] overflow-y-auto p-5 space-y-4 bg-slate-50/50">
            <!-- Initial AI message -->
            <div class="flex gap-3 ai-message">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white text-xs font-black shadow-sm">AI</div>
                <div class="rounded-2xl rounded-tl-none bg-white border border-slate-100 px-4 py-3 text-sm leading-6 text-slate-700 shadow-sm max-w-[85%]">
                    Halo! Saya <strong>KasirPro AI</strong>, analis bisnis pintarmu 🚀<br><br>
                    Saya sudah membaca data real-time tokomu hari ini — mulai dari omzet, laba, stok, hingga tren 7 hari terakhir.<br><br>
                    Mau tanya apa? 👇
                </div>
            </div>
            <!-- Quick Prompts -->
            <div id="quick-prompts" class="flex flex-wrap gap-2 mt-1">
                <button class="quick-prompt-btn rounded-full border border-blue-200 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-100 transition">📊 Analisis hari ini</button>
                <button class="quick-prompt-btn rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-100 transition">🏆 Produk terlaris</button>
                <button class="quick-prompt-btn rounded-full border border-violet-200 bg-violet-50 px-3 py-1.5 text-xs font-semibold text-violet-700 hover:bg-violet-100 transition">💡 Tips promo</button>
                <button class="quick-prompt-btn rounded-full border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700 hover:bg-amber-100 transition">📦 Cek stok kritis</button>
                <button class="quick-prompt-btn rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-100 transition">📈 Tren penjualan</button>
            </div>
        </div>

        <!-- Input Box -->
        <form id="ai-chat-form" class="border-t border-slate-100 px-4 py-3.5 bg-white">
            <div class="flex gap-2.5">
                <input type="text" id="ai-chat-input" placeholder="Tanya sesuatu tentang tokomu..." autocomplete="off" class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/10" required>
                <button type="submit" id="btn-send-ai" class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white shadow-md shadow-blue-500/25 transition hover:shadow-lg hover:shadow-blue-500/30 hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed disabled:scale-100">
                    <svg id="send-icon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    <svg id="loading-spinner" class="h-5 w-5 hidden animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                </button>
            </div>
            <p class="mt-2 text-[10px] text-slate-400 text-center">Tekan <kbd class="bg-slate-100 px-1 rounded">Enter</kbd> untuk kirim</p>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn    = document.getElementById('btn-toggle-ai');
            const closeBtn     = document.getElementById('btn-close-ai');
            const clearBtn     = document.getElementById('btn-clear-ai');
            const sendBtn      = document.getElementById('btn-send-ai');
            const sendIcon     = document.getElementById('send-icon');
            const loadingSpinner = document.getElementById('loading-spinner');
            const chatWindow   = document.getElementById('ai-chat-window');
            const chatForm     = document.getElementById('ai-chat-form');
            const chatInput    = document.getElementById('ai-chat-input');
            const chatMessages = document.getElementById('ai-chat-messages');
            const quickPromptsContainer = document.getElementById('quick-prompts');

            // Conversation history for multi-turn
            let conversationHistory = [];
            let isLoading = false;

            // ── Toggle open/close ─────────────────────────────────────────────
            function openChat() {
                chatWindow.classList.remove('hidden');
                setTimeout(() => {
                    chatWindow.classList.remove('scale-95', 'opacity-0');
                    chatWindow.classList.add('scale-100', 'opacity-100');
                    chatInput.focus();
                }, 10);
            }

            function closeChat() {
                chatWindow.classList.remove('scale-100', 'opacity-100');
                chatWindow.classList.add('scale-95', 'opacity-0');
                setTimeout(() => chatWindow.classList.add('hidden'), 300);
            }

            toggleBtn.addEventListener('click', () => {
                chatWindow.classList.contains('hidden') ? openChat() : closeChat();
            });
            closeBtn.addEventListener('click', closeChat);

            // ── Clear chat ────────────────────────────────────────────────────
            clearBtn.addEventListener('click', () => {
                conversationHistory = [];
                chatMessages.innerHTML = `
                    <div class="flex gap-3 ai-message">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white text-xs font-black shadow-sm">AI</div>
                        <div class="rounded-2xl rounded-tl-none bg-white border border-slate-100 px-4 py-3 text-sm leading-6 text-slate-700 shadow-sm max-w-[85%]">
                            Chat telah direset 🔄<br><br>Ada yang ingin ditanyakan lagi?
                        </div>
                    </div>
                    <div id="quick-prompts" class="flex flex-wrap gap-2 mt-1">
                        <button class="quick-prompt-btn rounded-full border border-blue-200 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-100 transition">📊 Analisis hari ini</button>
                        <button class="quick-prompt-btn rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-100 transition">🏆 Produk terlaris</button>
                        <button class="quick-prompt-btn rounded-full border border-violet-200 bg-violet-50 px-3 py-1.5 text-xs font-semibold text-violet-700 hover:bg-violet-100 transition">💡 Tips promo</button>
                        <button class="quick-prompt-btn rounded-full border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700 hover:bg-amber-100 transition">📦 Cek stok kritis</button>
                        <button class="quick-prompt-btn rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-100 transition">📈 Tren penjualan</button>
                    </div>`;
                attachQuickPrompts();
            });

            // ── Quick prompt chips ────────────────────────────────────────────
            function attachQuickPrompts() {
                document.querySelectorAll('.quick-prompt-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        chatInput.value = btn.textContent.trim().replace(/^[^\s]+\s/, ''); // strip emoji
                        chatInput.focus();
                        chatForm.dispatchEvent(new Event('submit'));
                    });
                });
            }
            attachQuickPrompts();

            // ── Set loading state ─────────────────────────────────────────────
            function setLoading(state) {
                isLoading = state;
                sendBtn.disabled = state;
                chatInput.disabled = state;
                sendIcon.classList.toggle('hidden', state);
                loadingSpinner.classList.toggle('hidden', !state);
            }

            // ── Form submit ───────────────────────────────────────────────────
            chatForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                if (isLoading) return;

                const message = chatInput.value.trim();
                if (!message) return;

                // Hide quick prompts once user starts chatting
                const qp = document.getElementById('quick-prompts');
                if (qp) qp.remove();

                appendMessage('user', message);
                chatInput.value = '';
                setLoading(true);

                const loadingId = appendLoading();

                try {
                    const response = await fetch("{{ route('dashboard.ai-chat') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message: message,
                            history: conversationHistory
                        })
                    });

                    const data = await response.json();
                    removeLoading(loadingId);

                    if (response.ok && data.success) {
                        const reply = data.reply;
                        appendMessage('ai', reply);

                        // Append to history for multi-turn
                        conversationHistory.push({ role: 'user',  content: message });
                        conversationHistory.push({ role: 'model', content: reply });

                        // Keep history to last 10 turns (20 entries) to avoid huge payloads
                        if (conversationHistory.length > 20) {
                            conversationHistory = conversationHistory.slice(-20);
                        }
                    } else {
                        appendMessage('ai', '⚠️ Maaf, terjadi kesalahan saat menghubungi asisten AI. Silakan coba lagi.');
                    }
                } catch (error) {
                    removeLoading(loadingId);
                    console.error(error);
                    appendMessage('ai', '❌ Koneksi gagal. Pastikan server aktif dan coba lagi.');
                } finally {
                    setLoading(false);
                }
            });

            // ── Render markdown ───────────────────────────────────────────────
            function renderMarkdown(text) {
                return text
                    // Code blocks
                    .replace(/```([\s\S]*?)```/g, '<pre class="bg-slate-100 rounded-lg p-3 text-xs overflow-x-auto my-2 text-slate-800 font-mono">$1</pre>')
                    // Inline code
                    .replace(/`([^`]+)`/g, '<code class="bg-slate-100 rounded px-1 font-mono text-xs text-indigo-700">$1</code>')
                    // H3
                    .replace(/^### (.+)$/gm, '<h4 class="font-black text-slate-800 mt-3 mb-1 text-sm">$1</h4>')
                    // H2
                    .replace(/^## (.+)$/gm, '<h3 class="font-black text-slate-800 mt-3 mb-1 text-base">$1</h3>')
                    // Bold
                    .replace(/\*\*(.*?)\*\*/g, '<strong class="font-bold text-slate-900">$1</strong>')
                    // Italic
                    .replace(/\*(.*?)\*/g, '<em class="italic">$1</em>')
                    // Bullet list items
                    .replace(/^[-•]\s+(.+)$/gm, '<li class="flex gap-1.5 items-start"><span class="mt-1 h-1.5 w-1.5 shrink-0 rounded-full bg-blue-400 inline-block"></span><span>$1</span></li>')
                    // Wrap consecutive <li> in <ul>
                    .replace(/(<li[\s\S]*?<\/li>(\n<li[\s\S]*?<\/li>)*)/g, '<ul class="my-2 space-y-1">$1</ul>')
                    // Numbered lists
                    .replace(/^\d+\.\s+(.+)$/gm, '<li class="ml-4 list-decimal">$1</li>')
                    // Horizontal rule
                    .replace(/^━+$/gm, '<hr class="border-slate-200 my-2">')
                    // Line breaks
                    .replace(/\n/g, '<br>');
            }

            // ── Append message ────────────────────────────────────────────────
            function appendMessage(sender, text) {
                const wrapper = document.createElement('div');
                wrapper.className = 'flex gap-3 ' + (sender === 'user' ? 'justify-end' : '');
                wrapper.style.animation = 'fadeInUp 0.25s ease both';

                const time = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

                if (sender === 'user') {
                    wrapper.innerHTML = `
                        <div class="flex flex-col items-end gap-1 max-w-[80%]">
                            <div class="rounded-2xl rounded-tr-none bg-gradient-to-br from-blue-600 to-indigo-600 text-white px-4 py-3 text-sm leading-6 shadow-md shadow-blue-500/20">${escapeHtml(text)}</div>
                            <span class="text-[10px] text-slate-400">${time}</span>
                        </div>`;
                } else {
                    wrapper.innerHTML = `
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white text-xs font-black shadow-sm mt-1">AI</div>
                        <div class="flex flex-col gap-1 max-w-[82%]">
                            <div class="rounded-2xl rounded-tl-none bg-white border border-slate-100 px-4 py-3 text-sm leading-6 text-slate-700 shadow-sm">${renderMarkdown(text)}</div>
                            <span class="text-[10px] text-slate-400">${time}</span>
                        </div>`;
                }

                chatMessages.appendChild(wrapper);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            // ── Loading dots ──────────────────────────────────────────────────
            function appendLoading() {
                const id = 'loading-' + Date.now();
                const wrapper = document.createElement('div');
                wrapper.id = id;
                wrapper.className = 'flex gap-3';
                wrapper.innerHTML = `
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white text-xs font-black shadow-sm">AI</div>
                    <div class="rounded-2xl rounded-tl-none bg-white border border-slate-100 px-4 py-3 shadow-sm flex items-center gap-1.5">
                        <span class="h-2 w-2 animate-bounce rounded-full bg-blue-400" style="animation-delay:0s"></span>
                        <span class="h-2 w-2 animate-bounce rounded-full bg-indigo-400" style="animation-delay:0.18s"></span>
                        <span class="h-2 w-2 animate-bounce rounded-full bg-blue-400" style="animation-delay:0.36s"></span>
                    </div>`;
                chatMessages.appendChild(wrapper);
                chatMessages.scrollTop = chatMessages.scrollHeight;
                return id;
            }

            function removeLoading(id) {
                const el = document.getElementById(id);
                if (el) el.remove();
            }

            function escapeHtml(text) {
                const d = document.createElement('div');
                d.textContent = text;
                return d.innerHTML;
            }
        });
    </script>
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
@endsection