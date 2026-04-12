@extends('layouts.app')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Riwayat Invoice</h1>
            <p class="text-gray-500 text-sm mt-1">Pantau seluruh riwayat transaksi kasir dan cetak ulang struk pelanggan.</p>
        </div>
        <div class="flex gap-2">
            <button
                class="flex items-center justify-center text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-4 py-2.5 transition shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Export PDF
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-600 rounded-xl p-5 text-white shadow-sm relative overflow-hidden">
            <div class="absolute -right-6 -top-6 opacity-20">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                    </path>
                </svg>
            </div>
            <p class="text-blue-100 font-medium text-sm mb-1 relative z-10">Transaksi Hari Ini</p>
            <h3 class="text-3xl font-bold relative z-10">
                {{ $transactions->where('created_at', '>=', \Carbon\Carbon::today())->count() }} <span
                    class="text-sm font-normal">Struk</span>
            </h3>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
            <p class="text-gray-500 font-medium text-sm mb-1">Pendapatan Hari Ini</p>
            <h3 class="text-2xl font-bold text-gray-900">Rp
                {{ number_format($transactions->where('created_at', '>=', \Carbon\Carbon::today())->sum('grand_total'), 0, ',', '.') }}
            </h3>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
            <p class="text-gray-500 font-medium text-sm mb-1">Pajak Terkumpul (Tax)</p>
            <h3 class="text-2xl font-bold text-gray-900">Rp
                {{ number_format($transactions->where('created_at', '>=', \Carbon\Carbon::today())->sum('tax'), 0, ',', '.') }}
            </h3>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4">Invoice / Tanggal</th>
                        <th class="px-6 py-4 text-center">Item Terjual</th>
                        <th class="px-6 py-4 text-right">Subtotal</th>
                        <th class="px-6 py-4 text-right">Tax (Pajak)</th>
                        <th class="px-6 py-4 text-right">Total Akhir</th>
                        <th class="px-6 py-4 text-center">Metode</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $trx)
                        <tr class="bg-white border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-blue-600 text-sm">{{ $trx->invoice_no }}</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y, H:i') }} WIB
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-gray-200">
                                    {{ $trx->details->sum('qty') }} Produk
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-gray-500 font-medium">Rp
                                {{ number_format($trx->subtotal, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-right text-gray-500">Rp {{ number_format($trx->tax, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-gray-900 text-base">Rp
                                {{ number_format($trx->grand_total, 0, ',', '.') }}</td>

                            <td class="px-6 py-4 text-center">
                                @if (strtolower($trx->payment_method) == 'cash')
                                    <span
                                        class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-md border border-emerald-200 block w-max mx-auto uppercase">
                                        CASH
                                    </span>
                                @elseif(strtolower($trx->payment_method) == 'qris')
                                    <span
                                        class="bg-orange-100 text-orange-800 text-xs font-bold px-3 py-1 rounded-md border border-orange-200 block w-max mx-auto uppercase">
                                        QRIS
                                    </span>
                                @else
                                    <span
                                        class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-md border border-blue-200 block w-max mx-auto uppercase">
                                        CARD
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                <button
                                    onclick="showInvoiceDetail('{{ $trx->invoice_no }}', '{{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y, H:i') }}', '{{ $trx->payment_method }}', {{ $trx->subtotal }}, {{ $trx->tax }}, {{ $trx->grand_total }}, {{ $trx->pay_amount }}, {{ $trx->return_amount }}, {{ json_encode($trx->details) }})"
                                    data-modal-target="invoice-modal" data-modal-toggle="invoice-modal"
                                    class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition inline-flex items-center justify-center"
                                    title="Lihat Struk">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-gray-500">Belum ada riwayat transaksi
                                kasir.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="invoice-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur-sm bg-gray-900/50">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-xl shadow-2xl overflow-hidden">
                <div
                    class="h-2 w-full bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI4IiBoZWlnaHQ9IjgiPgo8cG9seWdvbiBwb2ludHM9IjAsMCA4LDAgNCw4IiBmaWxsPSIjRjNGNEY2Ii8+Cjwvc3ZnPg==')]">
                </div>

                <div class="p-6">
                    <div class="text-center mb-6 border-b border-dashed border-gray-300 pb-4">
                        <h2 class="text-2xl font-black text-gray-900 mb-1">KASIRPRO</h2>
                        <p class="text-xs text-gray-500">Jl. Teknologi No. 404, Purwokerto</p>
                        <p class="text-xs text-gray-500">Telp: 0812-3456-7890</p>
                    </div>

                    <div class="flex justify-between items-center text-xs text-gray-600 mb-4">
                        <div>
                            <p>Invoice: <span id="modal-inv" class="font-bold text-gray-900"></span></p>
                            <p>Kasir: Admin</p>
                            <p>Metode: <span id="modal-method" class="uppercase font-bold text-blue-600"></span></p>
                        </div>
                        <div class="text-right">
                            <p id="modal-date"></p>
                        </div>
                    </div>

                    <div class="border-t border-b border-dashed border-gray-300 py-3 mb-4 space-y-2" id="modal-items"></div>

                    <div class="space-y-1 text-sm">
                        <div class="flex justify-between text-gray-500">
                            <p>Subtotal</p>
                            <p id="modal-subtotal"></p>
                        </div>
                        <div class="flex justify-between text-gray-500">
                            <p>Tax (10%)</p>
                            <p id="modal-tax"></p>
                        </div>
                        <div
                            class="flex justify-between text-gray-900 font-bold text-base pt-2 border-t border-gray-100 mt-2">
                            <p>TOTAL</p>
                            <p id="modal-grand"></p>
                        </div>
                        <div class="flex justify-between text-gray-500 pt-2">
                            <p>Cash / Dibayar</p>
                            <p id="modal-pay"></p>
                        </div>
                        <div class="flex justify-between text-gray-500">
                            <p>Kembalian</p>
                            <p id="modal-return"></p>
                        </div>
                    </div>

                    <div class="mt-8 text-center">
                        <p class="text-xs text-gray-400 italic">Terima kasih atas kunjungannya!</p>
                    </div>
                </div>

                <div class="p-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-2">
                    <button data-modal-hide="invoice-modal"
                        class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-100">Tutup</button>
                    <button onclick="window.print()"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                            </path>
                        </svg>
                        Cetak Struk
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const formatRp = (number) => new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number);

        // BUGS DIPERBAIKI DI SINI: parameter method ditambahkan
        function showInvoiceDetail(inv, date, method, subtotal, tax, grand, pay, returnAmount, items) {
            document.getElementById('modal-inv').innerText = inv;
            document.getElementById('modal-date').innerText = date;
            document.getElementById('modal-method').innerText = method;
            document.getElementById('modal-subtotal').innerText = formatRp(subtotal);
            document.getElementById('modal-tax').innerText = formatRp(tax);
            document.getElementById('modal-grand').innerText = formatRp(grand);
            document.getElementById('modal-pay').innerText = formatRp(pay);
            document.getElementById('modal-return').innerText = formatRp(returnAmount);

            let itemsHtml = '';
            items.forEach(item => {
                itemsHtml += `
                    <div class="flex justify-between text-sm">
                        <div class="flex-1 pr-2">
                            <p class="font-medium text-gray-900">${item.product_name}</p>
                            <p class="text-xs text-gray-500">${item.qty} x ${formatRp(item.price)}</p>
                        </div>
                        <p class="font-medium text-gray-900">${formatRp(item.subtotal)}</p>
                    </div>
                `;
            });
            document.getElementById('modal-items').innerHTML = itemsHtml;
        }
    </script>
@endsection
