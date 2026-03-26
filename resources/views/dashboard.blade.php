@extends('layouts.app')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>

        <div class="flex flex-wrap items-center gap-2">
            <div
                class="flex items-center bg-white border border-gray-200 rounded-lg px-3 py-2 shadow-sm text-sm text-gray-600">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Oct 18 - Nov 18
            </div>
            <button
                class="flex items-center bg-white border border-gray-200 rounded-lg px-3 py-2 shadow-sm text-sm text-gray-600 hover:bg-gray-50">
                Monthly <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <button
                class="flex items-center bg-white border border-gray-200 rounded-lg px-3 py-2 shadow-sm text-sm text-gray-600 hover:bg-gray-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                    </path>
                </svg> Filter
            </button>
            <button
                class="flex items-center bg-white border border-gray-200 rounded-lg px-3 py-2 shadow-sm text-sm text-gray-600 hover:bg-gray-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg> Export
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 relative">
            <div class="flex items-center justify-between mb-3 text-gray-500 text-sm font-medium">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                    Total Transaksi
                </div>
                <button><svg class="w-4 h-4 text-gray-300 hover:text-gray-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg></button>
            </div>
            <div class="flex items-end gap-3">
                <h3 class="text-3xl font-bold text-gray-900">12,450</h3>
                <span
                    class="bg-emerald-50 text-emerald-600 border border-emerald-100 text-xs font-bold px-2 py-0.5 rounded flex items-center mb-1">
                    15.8% <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18">
                        </path>
                    </svg>
                </span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 relative">
            <div class="flex items-center justify-between mb-3 text-gray-500 text-sm font-medium">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Total Revenue
                </div>
                <button><svg class="w-4 h-4 text-gray-300 hover:text-gray-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg></button>
            </div>
            <div class="flex items-end gap-3">
                <h3 class="text-3xl font-bold text-gray-900">Rp 9.2M</h3>
                <span
                    class="bg-rose-50 text-rose-600 border border-rose-100 text-xs font-bold px-2 py-0.5 rounded flex items-center mb-1">
                    4.0% <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 relative">
            <div class="flex items-center justify-between mb-3 text-gray-500 text-sm font-medium">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    Net Profit
                </div>
                <button><svg class="w-4 h-4 text-gray-300 hover:text-gray-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg></button>
            </div>
            <div class="flex items-end gap-3">
                <h3 class="text-3xl font-bold text-gray-900">36.5%</h3>
                <span
                    class="bg-emerald-50 text-emerald-600 border border-emerald-100 text-xs font-bold px-2 py-0.5 rounded flex items-center mb-1">
                    24.2% <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                    </svg>
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div
            class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col justify-center items-center text-gray-400">
            <svg class="w-16 h-16 mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                </path>
            </svg>
            <p class="text-sm font-medium">Area Grafik Sales Overview (Membutuhkan Library ApexCharts / Chart.js)</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-0 overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                <div class="flex items-center text-sm font-bold text-gray-900">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                    List of Products
                </div>
                <a href="#" class="text-blue-600 text-sm font-medium hover:underline">See All</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-400 uppercase bg-white border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-5 py-3 font-medium">Product</th>
                            <th scope="col" class="px-5 py-3 font-medium">Category</th>
                            <th scope="col" class="px-5 py-3 font-medium text-right">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4 flex items-center gap-3">
                                <div
                                    class="w-6 h-6 rounded bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">
                                    K</div>
                                <span class="font-bold text-gray-900">Kopi Gula Aren</span>
                            </td>
                            <td class="px-5 py-4">Minuman</td>
                            <td class="px-5 py-4 text-right font-medium text-gray-900">Rp 650.000</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4 flex items-center gap-3">
                                <div
                                    class="w-6 h-6 rounded bg-orange-100 text-orange-600 flex items-center justify-center text-xs font-bold">
                                    R</div>
                                <span class="font-bold text-gray-900">Roti Bakar</span>
                            </td>
                            <td class="px-5 py-4">Makanan</td>
                            <td class="px-5 py-4 text-right font-medium text-gray-900">Rp 432.250</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4 flex items-center gap-3">
                                <div
                                    class="w-6 h-6 rounded bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold">
                                    K</div>
                                <span class="font-bold text-gray-900">Kentang Goreng</span>
                            </td>
                            <td class="px-5 py-4">Snack</td>
                            <td class="px-5 py-4 text-right font-medium text-gray-900">Rp 210.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
