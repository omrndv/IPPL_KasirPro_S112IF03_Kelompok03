@extends('layouts.app')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan Laba & Rugi</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau performa keuangan dan profitabilitas bisnis Anda.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <div
                class="flex items-center bg-white border border-gray-200 rounded-lg px-3 py-2 shadow-sm text-sm text-gray-600">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Mar 01 - Mar 31, 2026
            </div>
            <button
                class="flex items-center bg-white border border-gray-200 rounded-lg px-3 py-2 shadow-sm text-sm text-gray-600 hover:bg-gray-50 transition">
                This Month <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <button
                class="flex items-center bg-gray-900 text-white border border-gray-900 rounded-lg px-4 py-2 shadow-sm text-sm font-bold hover:bg-black transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg> Export PDF
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 relative">
            <div class="flex justify-between items-start mb-4 text-sm font-medium">
                <div class="flex items-center text-gray-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    Total Revenue (Omset)
                </div>
                <button><svg class="w-4 h-4 text-gray-300 hover:text-gray-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg></button>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-2">Rp 14.500.000</h3>
            <div class="flex items-center text-xs text-gray-500">
                <span
                    class="bg-emerald-50 text-emerald-600 border border-emerald-100 font-bold px-1.5 py-0.5 rounded flex items-center mr-2">
                    8.5% <svg class="w-3 h-3 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18">
                        </path>
                    </svg>
                </span>
                vs last month
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 relative">
            <div class="flex justify-between items-start mb-4 text-sm font-medium">
                <div class="flex items-center text-gray-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Cost of Goods (Modal)
                </div>
                <button><svg class="w-4 h-4 text-gray-300 hover:text-gray-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg></button>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-2">Rp 9.200.000</h3>
            <div class="flex items-center text-xs text-gray-500">
                <span
                    class="bg-rose-50 text-rose-600 border border-rose-100 font-bold px-1.5 py-0.5 rounded flex items-center mr-2">
                    2.1% <svg class="w-3 h-3 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </span>
                vs last month
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 border-b-4 border-b-emerald-400 p-5 relative">
            <div class="flex justify-between items-start mb-4 text-sm font-medium">
                <div class="flex items-center text-emerald-600 font-bold">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    Net Profit (Laba Bersih)
                </div>
                <button><svg class="w-4 h-4 text-gray-300 hover:text-gray-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg></button>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-2">Rp 5.300.000</h3>
            <div class="flex items-center text-xs text-gray-500">
                <span class="font-bold text-gray-900 mr-1">Profit Margin: 36.5%</span>
                (Sangat Sehat)
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 relative">
            <div class="flex justify-between items-start mb-4 text-sm font-medium">
                <div class="flex items-center text-gray-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Avg. Order Value
                </div>
                <button><svg class="w-4 h-4 text-gray-300 hover:text-gray-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg></button>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-2">Rp 42.390</h3>
            <div class="flex items-center text-xs text-gray-500">
                Dari total <span class="font-bold text-gray-900 mx-1">342</span> transaksi sukses
            </div>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="font-bold text-gray-900 text-lg">Revenue vs Profit (Mar 2026)</h3>
                <p class="text-xs text-gray-500 mt-1">Perbandingan tren omset kotor dengan laba bersih.</p>
            </div>
            <button
                class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 transition border border-gray-200 rounded-lg px-3 py-1.5 hover:bg-gray-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg> Download SVG
            </button>
        </div>

        <div id="revenue-chart" class="w-full h-80"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Skema warna Nexus UI (Biru laut dan Hijau zamrud cerah)
            const primaryColor = '#3b82f6'; // Biru (Revenue)
            const successColor = '#10b981'; // Hijau (Profit)

            const options = {
                chart: {
                    height: 320,
                    type: "area",
                    fontFamily: "Inter, sans-serif",
                    dropShadow: {
                        enabled: false
                    },
                    toolbar: {
                        show: false
                    },
                },
                tooltip: {
                    enabled: true,
                    theme: 'light',
                    x: {
                        show: false
                    }
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: [2, 2],
                    curve: 'smooth'
                },
                grid: {
                    show: true,
                    borderColor: '#f3f4f6',
                    strokeDashArray: 4,
                    padding: {
                        left: 10,
                        right: 10,
                        top: 0,
                        bottom: 0
                    },
                },
                colors: [primaryColor, successColor],
                series: [{
                        name: "Revenue (Omset)",
                        data: [1200000, 1500000, 1100000, 2100000, 1800000, 2400000],
                    },
                    {
                        name: "Net Profit (Laba)",
                        data: [400000, 550000, 300000, 800000, 650000, 950000],
                    }
                ],
                xaxis: {
                    categories: ["20 Mar", "21 Mar", "22 Mar", "23 Mar", "24 Mar", "25 Mar"],
                    labels: {
                        show: true,
                        style: {
                            fontFamily: "Inter, sans-serif",
                            colors: '#9ca3af',
                            fontSize: '12px'
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    tooltip: {
                        enabled: false
                    }
                },
                yaxis: {
                    show: true,
                    labels: {
                        style: {
                            colors: '#9ca3af',
                            fontSize: '12px'
                        },
                        formatter: function(value) {
                            return "Rp " + (value / 1000) + "k";
                        }
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    markers: {
                        radius: 12
                    }
                }
            }

            if (document.getElementById("revenue-chart") && typeof ApexCharts !== 'undefined') {
                const chart = new ApexCharts(document.getElementById("revenue-chart"), options);
                chart.render();
            }
        });
    </script>
@endsection
