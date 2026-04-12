@extends('layouts.app')

@section('content')
    <div class="mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Analitik Laba & Rugi</h1>
            <p class="text-gray-500 text-sm mt-1">Performa bisnis, perhitungan modal (HPP), dan laba bersih.</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <form action="{{ route('analytics.laporan') }}" method="GET"
                class="flex flex-wrap sm:flex-nowrap gap-2 items-center">
                <input type="date" name="start_date" value="{{ $startDate }}"
                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 shadow-sm"
                    required title="Mulai Tanggal">
                <span class="text-gray-500 font-bold hidden sm:block">-</span>
                <input type="date" name="end_date" value="{{ $endDate }}"
                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 shadow-sm"
                    required title="Sampai Tanggal">

                <button type="submit"
                    class="text-white bg-gray-900 hover:bg-black font-medium rounded-lg text-sm px-4 py-2.5 shadow-sm transition">
                    Filter
                </button>
            </form>

            <a href="{{ route('analytics.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                class="flex items-center justify-center text-emerald-700 bg-emerald-50 border border-emerald-200 hover:bg-emerald-100 focus:ring-4 focus:ring-emerald-100 font-bold rounded-lg text-sm px-4 py-2.5 transition shadow-sm whitespace-nowrap">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Export Excel
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="text-gray-500 font-bold text-xs uppercase tracking-wider mb-1">Pendapatan Kotor</p>
                    <h3 class="text-2xl font-black text-gray-900">Rp {{ number_format($pendapatan, 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-2">Bulan Ini (Tanpa Pajak)</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="text-gray-500 font-bold text-xs uppercase tracking-wider mb-1">Total Modal (HPP)</p>
                    <h3 class="text-2xl font-black text-rose-600">Rp {{ number_format($hpp, 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-rose-50 flex items-center justify-center text-rose-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-2">Harga Beli x Terjual</p>
        </div>

        <div
            class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-5 shadow-sm text-white relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 opacity-20">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z">
                    </path>
                </svg>
            </div>
            <div class="relative z-10">
                <p class="text-emerald-100 font-bold text-xs uppercase tracking-wider mb-1">Laba Bersih</p>
                <h3 class="text-3xl font-black">Rp {{ number_format($labaBersih, 0, ',', '.') }}</h3>
                <p class="text-xs text-emerald-100 mt-2 font-medium">Pendapatan dikurangi Modal</p>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="text-gray-500 font-bold text-xs uppercase tracking-wider mb-1">Pajak (Tax 10%)</p>
                    <h3 class="text-2xl font-black text-gray-900">Rp {{ number_format($pajak, 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-2">Titipan Negara</p>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        <div class="lg:col-span-2 bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Tren Pendapatan (7 Hari Terakhir)</h3>
            <div class="relative h-72 w-full">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Produk Terlaris Bulan Ini</h3>

            <div class="space-y-4">
                @forelse ($topProducts as $index => $top)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-xs">
                                #{{ $index + 1 }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $top->product_name }}</p>
                                <p class="text-xs text-gray-500">Terjual: {{ $top->total_qty }} Pcs</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-blue-600">Rp
                                {{ number_format($top->total_revenue, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-400 py-10 text-sm">
                        Belum ada data penjualan bulan ini.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data dari Controller
        const labels = {!! json_encode($chartLabels) !!};
        const dataPoints = {!! json_encode($chartData) !!};

        const ctx = document.getElementById('revenueChart').getContext('2d');

        // Bikin Gradient Biru untuk efek fill di bawah garis
        let gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)'); // Biru 20%
        gradient.addColorStop(1, 'rgba(37, 99, 235, 0)'); // Transparan

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan Kotor (Rp)',
                    data: dataPoints,
                    borderColor: '#2563eb', // Blue 600
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#2563eb',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4 // Membuat garisnya melengkung halus (spline)
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#111827',
                        padding: 12,
                        titleFont: {
                            size: 13
                        },
                        bodyFont: {
                            size: 14,
                            weight: 'bold'
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
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [4, 4],
                            color: '#f3f4f6',
                            drawBorder: false
                        },
                        ticks: {
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
