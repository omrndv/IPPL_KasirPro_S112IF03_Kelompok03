@extends('layouts.app')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Riwayat Transaksi</h1>
            <p class="text-gray-500 text-sm mt-1">Daftar lengkap semua transaksi penjualan yang telah terjadi.</p>
        </div>

        <button
            class="flex items-center justify-center text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2.5 transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            Export PDF Transaksi
        </button>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm mb-6 p-4 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-2 relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="text"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                placeholder="Cari No. Nota, Kasir, atau Nominal...">
        </div>

        <div>
            <select
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="">Semua Metode</option>
                <option value="tunai">Tunai</option>
                <option value="qris">QRIS</option>
                <option value="card">Kartu Debit/Kredit</option>
            </select>
        </div>

        <div>
            <input type="date"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-4">Waktu</th>
                        <th scope="col" class="px-6 py-4">No. Nota</th>
                        <th scope="col" class="px-6 py-4">Metode</th>
                        <th scope="col" class="px-6 py-4">Kasir</th>
                        <th scope="col" class="px-6 py-4 text-right">Total Transaksi</th>
                        <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="bg-white hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">25 Mar 2026</div>
                            <div class="text-xs text-gray-500">14:30 WIB</div>
                        </td>
                        <td class="px-6 py-4 font-semibold text-blue-600">INV-260325-004</td>
                        <td class="px-6 py-4"><span
                                class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">QRIS</span></td>
                        <td class="px-6 py-4 text-gray-900">Admin</td>
                        <td class="px-6 py-4 text-right font-bold text-gray-900">Rp 56.100</td>
                        <td class="px-6 py-4 text-center">
                            <button class="text-blue-600 hover:underline text-sm font-medium">Lihat Detail</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200 flex justify-between items-center text-sm text-gray-500">
            <span>Menampilkan 1 sampai 1 dari 1 transaksi</span>
            <div class="inline-flex">
                <button
                    class="px-3 py-1 border border-gray-300 rounded-l-lg bg-gray-100 text-gray-400 cursor-not-allowed">Sebelumnya</button>
                <button class="px-3 py-1 border border-gray-300 rounded-r-lg hover:bg-gray-50">Selanjutnya</button>
            </div>
        </div>
    </div>
@endsection
